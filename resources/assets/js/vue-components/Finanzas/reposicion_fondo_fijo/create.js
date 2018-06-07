Vue.component('reposicion-fondo-fijo-create', {
    props: ['comprobante_fondo_fijo'],
    template: require('./templates/create.html'),

    data: function () {
        return {
            form: {
                cumplimiento: new Date().dateShortFormat(),
                vencimiento: new Date().dateShortFormat(),
                destino: '',
                fecha: new Date().dateShortFormat(),
                id_referente: '',
                id_antecedente: '',
                observaciones: '',
                monto: ''
            },
            fondos: {},
            fondo_fijo: {},
            cargando : true,
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

    watch : {
        'form.id_referente' : function (id) {
            if(id) {
                this.setAFavorDe(id);
            } else {
                this.form.destino = '';
            }
        }
    },

    computed: {
        tiene_compobante: function() {
            return this.comprobante_fondo_fijo != null;
        }
    },

    mounted: function () {
        var self = this;

        if(self.tiene_compobante) {
                self.form.destino = self.comprobante_fondo_fijo.fondo_fijo.nombre;
                self.form.id_referente = self.comprobante_fondo_fijo.fondo_fijo.id_fondo;
                Vue.set(self.form, 'id_antecedente', self.comprobante_fondo_fijo.id_transaccion);
                self.form.observaciones = self.comprobante_fondo_fijo.observaciones;
                self.form.monto = self.comprobante_fondo_fijo.monto;
        }

        self.getFondos();

        $('#cumplimiento').datepicker().on("changeDate", function() {
            self.form.cumplimiento = $('#cumplimiento').val();
            //Vue.set(self.form, 'cumplimiento',$('#cumplimiento').val());
        });

        $('#fecha').datepicker().on("changeDate", function() {
            self.form.fecha = $('#fecha').val();
            //Vue.set(self.form, 'cumplimiento',$('#cumplimiento').val());
        });

        $('#vencimiento').datepicker().on("changeDate", function() {
            self.form.vencimiento = $('#vencimiento').val()
            // Vue.set(self.form, 'vencimiento', $('#vencimiento').val())
        });

        $('#id_antecedente').select2({
            width: '100%',
            ajax: {
                url: App.host + '/api/finanzas/comprobante_fondo_fijo/search',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        q: params.term,
                        limit: 10,
                        with: 'fondoFijo'
                    }

                    return query;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            var text = '# ' + item.numero_folio + " - " + item.referencia.trim() + ' (' + item.observaciones.trim() + ')';
                            return {
                                text:text,
                                id: item.id_transaccion,
                                monto: item.monto,
                                id_referente: item.id_referente,
                                fondo_fijo: item.fondo_fijo,
                                observaciones: item.observaciones
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
            placeholder: self.tiene_compobante ? '# ' + self.comprobante_fondo_fijo.numero_folio + " - " + self.comprobante_fondo_fijo.referencia.trim() + ' (' + self.comprobante_fondo_fijo.observaciones.trim() + ')' : '[--BUSCAR--]',
            minimumInputLength: 1,
            allowClear: true
        }).on('select2:select', function (e) {
            var data = e.params.data;
            self.form.id_antecedente = data.id;
            self.fillData(e.params.data);
        }).on('select2:unselecting', function (e) {
            self.form.id_antecedente = '';
            self.form.monto = '';
            self.form.id_referente = '';
            self.form.destino = '';
        });
    },

    methods: {
        getFondos: function() {
            var self = this;
            $.ajax({
                url: App.host + '/api/fondo/lists',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                success: function(data) {
                    self.fondos = data;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },
        fillData: function (data) {
            this.form.monto = data.monto;
            this.form.id_referente = data.id_referente;
            this.form.destino = data.fondo_fijo.nombre;
            this.form.observaciones = data.observaciones;
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
                title: 'Guardar Reposición de Fondo Fijo',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.save();
                }
            });
        },
        setAFavorDe: function() {
            var self = this;
            $.ajax({
                url: App.host + '/api/fondo/' + self.form.id_referente,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.form.destino = response.nombre;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },

        save : function () {
            var self = this;
            $.ajax({
                url : App.host + '/api/finanzas/solicitud_cheque/reposicion_fondo_fijo',
                type : 'POST',
                data : self.form,
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Reposición de Fondo Fijo guardada correctamente'
                    }).then(function () {
                        location.reload();
                    });
                },
                error: function(error) {
                    $.each(error.responseJSON.errors, function(e, key) {
                        var field = $('#' + e );
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