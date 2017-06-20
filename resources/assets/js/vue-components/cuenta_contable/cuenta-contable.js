Vue.component('cuenta-contable', {
    props: ['obra', 'obra_update_url', 'cuenta_store_url'],
    data: function() {
        return {
            'form': {
                'cuenta_contable': {
                    'id_int_tipo_cuenta_contable': '',
                    'prefijo': '',
                    'cuenta_contable': '',
                }
            },
            'guardando' : false
        }
    },

    methods: {
        confirm_datos_obra: function () {
            var self = this;
            swal({
                title: "Guardar Datos de Obra",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_datos_obra();
            }).catch(swal.noop);
        },

        save_datos_obra: function () {
            var self = this;
            $.ajax({
                type: 'POST',
                url: self.obra_update_url,
                data: {
                    BDContPaq : self.obra.BDContPaq,
                    FormatoCuenta : self.obra.FormatoCuenta,
                    NumobraContPaq : self.obra.NumobraContPaq,
                    _method : 'PATCH'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos de la Obra <b>' +self.obra.nombre + '</b> actualizados correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        confirm_cuenta_contable: function () {
            var self = this;
            swal({
                title: "Guardar Cuenta",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },

        save_cuenta_contable: function () {
            var self = this;
            var url = self.cuenta_store_url;
            var data = self.form.cuenta_contable;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {

                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        validateForm: function(scope) {
            this.$validator.validateAll(scope).then(() => {
                this.confirm_datos_obra();
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