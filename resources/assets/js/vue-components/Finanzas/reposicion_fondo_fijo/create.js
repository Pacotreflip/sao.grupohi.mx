Vue.component('reposicion-fondo-fijo-create', {
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

    mounted: function () {
        var self = this;
        setTimeout(function () {
            self.getFondos();
        }, 250);

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
                                fondo_fijo: item.fondo_fijo
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
            placeholder: '[--BUSCAR--]',
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
                complete : function () {
                    self.guardando = false;
                }
            })
        }
    }
});