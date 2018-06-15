Vue.component('reposicion-fondo-fijo-create', {
    props: ['id_antecedente'],
    template: require('./templates/create.html'),

    data: function () {
        return {
            form: {
                cumplimiento: new Date().dateShortFormat(),
                vencimiento: new Date().dateShortFormat(),
                destino: '',
                fecha: '',
                id_referente: '',
                id_antecedente: '',
                observaciones: '',
                monto: ''
            },
            comprobante_fondo_fijo: {},
            cargando : false,
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
        'comprobante_fondo_fijo': function (comprobante_fondo_fijo) {
            if (Object.keys(comprobante_fondo_fijo).length === 0) {
                this.form.destino = '';
                this.form.fecha = '';
                this.form.id_referente = '';
                this.form.id_antecedente = '';
                this.form.observaciones = '';
                this.form.monto = '';
            } else {
                this.form.destino = comprobante_fondo_fijo.fondo_fijo.nombre;
                this.form.fecha = comprobante_fondo_fijo.fecha;
                this.form.id_referente = comprobante_fondo_fijo.fondo_fijo.id_fondo;
                this.form.id_antecedente = comprobante_fondo_fijo.id_transaccion;
                this.form.observaciones = comprobante_fondo_fijo.observaciones;
                this.form.monto = comprobante_fondo_fijo.monto;
            }
        }
    },

    mounted: function () {
        var self = this;

        if(self.id_antecedente) {
            self.getComprobanteFondoFijo().then(function (data) {
                self.comprobante_fondo_fijo = data.comprobante_fondo_fijo;
            });
        } else {
            $('#id_antecedente_rff').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/api/finanzas/comprobante_fondo_fijo/search',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    data: function (params) {
                        var query = {
                            q: params.term,
                            limit: 10,
                            with: 'fondoFijo'
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
                                    comprobante_fondo_fijo: item
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
                placeholder: '[--BUSCAR COMPROBANTE--]',
                minimumInputLength: 1,
                allowClear: true
            }).on('select2:select', function (e) {
                var data = e.params.data;
                self.form.id_antecedente = data.id;
                self.comprobante_fondo_fijo = data.comprobante_fondo_fijo;
            }).on('select2:unselecting', function () {
                self.form.id_antecedente = '';
                self.comprobante_fondo_fijo = {};
            });
        }

        $('#cumplimiento_rff').datepicker().on("changeDate", function() {
            self.form.cumplimiento = $('#cumplimiento_rff').val();
        });

        $('#vencimiento_rff').datepicker().on("changeDate", function() {
            self.form.vencimiento = $('#vencimiento_rff').val()
        });
    },

    methods: {
        getComprobanteFondoFijo: function() {
            var self =this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/comprobante_fondo_fijo/' + self.id_antecedente,
                    type: 'GET',
                    data: {
                        with: 'fondoFijo'
                    },
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    beforeSend: function () {
                        self.cargando = true;

                    },
                    success: function (response) {
                        self.cargando = false;
                        resolve({comprobante_fondo_fijo: response});
                    },
                });
            });
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_reposicion') {
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
                title: 'Generar Solicitud de Pago',
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
        save : function () {
            var self = this;
            $.ajax({
                url : App.host + '/api/finanzas/solicitud_pago/reposicion_fondo_fijo',
                type : 'POST',
                data : self.form,
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
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
                        var field = $('#' + e + '_rff' );
                        self.validation_errors.errors.push({
                            field: field.attr('name'),
                            msg: key[0],
                            rule: 'valid',
                            scope: 'form_reposicion_fondo_fijo'
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