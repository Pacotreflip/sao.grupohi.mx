Vue.component('pago-cuenta-create', {
    template: require('./templates/create.html'),
    data: function () {
        return {
            form: {
                cumplimiento: new Date().dateShortFormat(),
                vencimiento: new Date().dateShortFormat(),
                id_antecedente: '',
                destino: '',
                fecha: '',
                id_empresa: '',
                observaciones: '',
                monto: '',
                id_costo: '',
                tipo_transaccion: ''
            },
            costo: '',
            tipos_tran: [],
            transaccion: {},
            cargando: false,
            guardando: false
        }
    },
    directives: {
        datepicker: {
            inserted: function (el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        }
    },

    watch: {
        'form.tipo_transaccion' : function () {
            var self = this;
            $('#id_antecedente_pc').val(null).trigger('change');
            self.form.id_antecedente = '';
            self.transaccion = {};

            $('#id_antecedente_pc').select2({
                width: '100%',
                ajax: {
                    url: self.url,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    data: function (params) {
                        var query = {
                            q: params.term,
                            limit: 10,
                            with: ['empresa', 'costo', (self.form.tipo_transaccion == 19 ? 'requisicion' : 'contratoProyectado')],
                            cols: ['numero_folio', 'referencia', 'observaciones']
                        };
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                var text = '# ' + item.numero_folio + " - " + (item.referencia ? item.referencia.trim() : '---') + (item.observaciones ? ' (' + item.observaciones.trim() + ')' : '');
                                return {
                                    text:text,
                                    id: item.id_transaccion,
                                    transaccion: item
                                }
                            })
                        };
                    },
                    error: function (error) {},
                    cache: true
                },
                delay: 500,
                escapeMarkup: function (markup) {
                    return markup;
                },
                placeholder: '[--BUSCAR ' + (self.form.tipo_transaccion == 19 ? 'ORDEN DE COMPRA' : 'SUBCONTRATO') + '--]',
                minimumInputLength: 1,
                allowClear: true
            }).on('select2:select', function (e) {
                var data = e.params.data;
                self.form.id_antecedente = data.id;
                self.transaccion = data.transaccion;
            }).on('select2:unselecting', function () {
                self.form.id_antecedente = '';
                self.costo = '';
                self.transaccion = {};
            });
        },
        'transaccion': function (transaccion) {
            if (Object.keys(transaccion).length === 0) {
                this.form.destino = '';
                this.form.fecha = '';
                this.form.id_empresa = '';
                this.form.id_antecedente = '';
                this.form.observaciones = '';
                this.form.monto = '';
                this.form.id_costo = '';
                this.costo = '';

            } else {
                this.form.destino = transaccion.empresa.razon_social;
                this.form.fecha = transaccion.fecha;
                this.form.id_empresa = transaccion.id_empresa;
                this.form.id_antecedente = transaccion.id_transaccion;
                this.form.observaciones = transaccion.observaciones;
                this.form.monto = transaccion.monto;
                this.form.id_costo = transaccion.id_costo;
                this.costo = transaccion.costo != null ? transaccion.costo.descripcion : '';
            }
        }
    },

    computed: {
        url: function () {
            return App.host + '/api/' + (this.form.tipo_transaccion == 19 ? 'compras/orden_compra' : 'contratos/subcontrato') + '/search';
        }
    },

    mounted: function () {

        var self = this;

        self.carga_arbol();
        self.get_tipos_tran();

        $('#cumplimiento_pc').datepicker().on("changeDate", function() {
            self.form.cumplimiento = $('#cumplimiento_pc').val();
        });

        $('#vencimiento_pc').datepicker().on("changeDate", function() {
            self.form.vencimiento = $('#vencimiento_pc').val()
        });


    },
    methods: {
        get_tipos_tran: function() {
            var self = this;
            $.ajax({
                url: App.host + '/api/finanzas/solicitud_cheque/pago_cuenta/tipos_transaccion',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.tipos_tran = response;
                },
                complete: function () {

                    self.cargando = false;
                }
            });
        },
        carga_arbol: function() {
            var self = this;
            
            var jstreeConf = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function (node) {
                            var costos = "";
                            if (node.id === "#") {
                                return App.host + '/api/costo/jstree';
                            }
                            return App.host + '/api/costo/' + node.id + '/jstree';
                        },
                        "data": function (node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'default': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'opened': {
                        'icon': 'fa fa-folder-open-o text-success'
                    }
                },
                'plugins': ['types']
            };

            $('#myModal_pc').on('shown.bs.modal', function (e) {
                $('#jstree_pc').jstree(jstreeConf);
            }).on('hidden.bs.modal', function (e) {
                var jstree = $('#jstree_pc').jstree(true);
                var node = jstree.get_selected(true)[0];

                if (node) {
                    self.form.id_costo = node.id;
                    self.costo = node.text;
                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_pago') {
                this.confirmSave();

            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },
        confirmSave: function () {
            var self = this;
            swal({
                title: 'Generar Solicitud de Cheque',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Generar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.save();
                }
            });
        },
        save: function () {
            var self = this;
            $.ajax({
                url : App.host + '/api/finanzas/solicitud_cheque/pago_cuenta',
                type : 'POST',
                data : self.form,
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function () {
                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Solicitud generada correctamente'
                    }).then(function () {
                        location.reload();
                    });
                },
                error: function(error) {
                    $.each(error.responseJSON.errors, function(e, key) {
                        console.log('#' + e + '_pc');
                        var field = $('#' + e + '_pc');


                        self.validation_errors.errors.push({
                            field: field.attr('name'),
                            msg: key[0],
                            rule: 'valid',
                            scope: 'form_pago_cuenta'

                        });
                    });
                },
                complete : function () {
                    self.guardando = false;
                }
            })
        }
    }
});