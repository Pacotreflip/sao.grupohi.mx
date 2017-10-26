Vue.component('traspaso-cuentas-index', {
    props: ['url_traspaso_cuentas_index', 'cuentas', 'traspasos', 'monedas'],
    data : function () {
        return {
            'data' : {
                'traspasos' : this.traspasos,
                'cuentas': this.cuentas,
                'monedas': this.monedas
            },
            'form' : {
                'id_cuenta_origen': '',
                'id_cuenta_destino': '',
                'observaciones': '',
                'importe': '',
                'fecha': moment().format('YYYY-MM-DD'),
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'traspaso_edit': {
                'id_traspaso': '',
                'id_cuenta_origen': '',
                'id_cuenta_destino': '',
                'observaciones': '',
                'importe': '',
                'fecha': '',
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'guardando' : false
        }
    },
    computed: {
        cuentas_disponibles: function () {
            var self = this;
            return this.cuentas.filter(function (cuenta) {
                return cuenta.id_cuenta != self.form.id_cuenta_origen;
            });
        }
    },
    mounted: function()
    {
        var self = this;
        $("#cumplimiento").datepicker().on("changeDate",function () {
            Vue.set(self.form, 'vencimiento', $('#cumplimiento').val());
            Vue.set(self.form, 'cumplimiento', $('#cumplimiento').val());
        });

        $(".fechas_edit").datepicker().on("changeDate",function () {
            var thisElement = $(this);
            var id = thisElement.attr('id').replace('edit_','');
            Vue.set(self.traspaso_edit, id, thisElement.val());
        });
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
        },
    },
    methods: {
        datos_cuenta: function (id) {
            return this.cuentas[id];
        },
        confirm_guardar: function() {
            var self = this;
            swal({
                title: "Guardar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.guardar();
            }).catch(swal.noop);
        },
        guardar: function () {
            var self = this;

            $.ajax({
                type: 'POST',
                url : self.url_traspaso_cuentas_index,
                data: self.form,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {console.log(data);
                    self.data.traspasos.push(data.data.traspaso);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso guardado correctamente'
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        confirm_eliminar: function(id_traspaso) {
            var self = this;
            swal({
                title: "Eliminar traspaso",
                text: "¿Estás seguro/a de que deseas eliminar este traspaso?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.eliminar(id_traspaso);
            }).catch(swal.noop);
        },
        eliminar: function (id_traspaso) {
            var self = this;
            $.ajax({
                type: 'GET',
                url : self.url_traspaso_cuentas_index +'/'+ id_traspaso,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === id_traspaso) {
                            self.data.traspasos.splice(self.data.traspasos.indexOf(traspaso), 1);
                        }
                    });

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso eliminado'
                    });
                },
                complete: function () { }
            });
        },
        modal_editar: function (traspaso){

            Vue.set(this.traspaso_edit, 'id_traspaso', traspaso.id_traspaso);
            Vue.set(this.traspaso_edit, 'id_cuenta_origen', traspaso.id_cuenta_origen);
            Vue.set(this.traspaso_edit, 'id_cuenta_destino', traspaso.id_cuenta_destino);
            Vue.set(this.traspaso_edit, 'observaciones', traspaso.observaciones);
            Vue.set(this.traspaso_edit, 'importe', traspaso.importe);
            Vue.set(this.traspaso_edit, 'fecha', traspaso.traspaso_transaccion.transaccion_debito.fecha.substring(0,10));
            Vue.set(this.traspaso_edit, 'cumplimiento', traspaso.traspaso_transaccion.transaccion_debito.cumplimiento.substring(0,10));
            Vue.set(this.traspaso_edit, 'vencimiento', traspaso.traspaso_transaccion.transaccion_debito.vencimiento.substring(0,10));
            Vue.set(this.traspaso_edit, 'referencia', traspaso.traspaso_transaccion.transaccion_debito.referencia);

            this.validation_errors.clear('form_editar_traspaso');
            $('#edit_traspaso_modal').modal('show');
            $('#edit_id_cuenta_origen').focus();
        },
        confirm_editar: function() {
            var self = this;
            swal({
                title: "Editar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.editar();
            }).catch(swal.noop);
        },
        editar: function () {
            var self = this;

            self.traspaso_edit._method = 'PATCH';
            $.ajax({
                type: 'POST',
                url : self.url_traspaso_cuentas_index + '/' + self.traspaso_edit.id_traspaso,
                data: self.traspaso_edit,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {console.log(data);

                    self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === data.data.traspaso.id_traspaso) {
                            Vue.set(self.data.traspasos, self.data.traspasos.indexOf(traspaso), data.data.traspaso);
                        }
                    });
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso guardado correctamente'
                    });

                    self.close_edit_traspaso();
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        close_edit_traspaso: function () {
            $('#edit_traspaso_modal').modal('hide');
        },
        validateForm: function(scope, funcion) {
            self = this;
            this.$validator.validateAll(scope).then(() => {
                if(funcion === 'confirm_guardar') {
                self.confirm_guardar();
            } else if (funcion === 'confirm_editar') {
                self.confirm_editar();
            }
            }).catch(() => {
                    swal({
                             type: 'warning',
                             title: 'Advertencia',
                             text: 'Por favor corrija los errores del formulario'
                         });
            });
        }
    }
});