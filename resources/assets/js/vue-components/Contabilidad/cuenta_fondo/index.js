Vue.component('cuenta-fondo-index', {
    props: ['datos_contables', 'url_cuenta_fondo_store', 'fondos'],
    data: function() {
        return {
            'data' : {
                'fondos' : this.fondos,
                'fondo_edit': {}
            },
            'form': {
                'cuenta_fondo': {
                    'id': '',
                    'id_fondo': '',
                    'cuenta' : ''
                }
            },
            'guardando' : false
        }
    },
    methods:{
        editar:function (fondo){
            this.data.fondo_edit = fondo;
            Vue.set(this.form.cuenta_fondo, 'id_fondo', fondo.id_fondo);
            if(fondo.cuenta_fondo != null){
                Vue.set(this.form.cuenta_fondo, 'cuenta', fondo.cuenta_fondo.cuenta);
                Vue.set(this.form.cuenta_fondo, 'id', fondo.cuenta_fondo.id);
            }else{
                Vue.set(this.form.cuenta_fondo, 'cuenta', '');
                Vue.set(this.form.cuenta_fondo, 'id', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'confirm_save_cuenta') {
                this.confirm_save_cuenta();
            } else if (funcion == 'confirm_update_cuenta') {
                this.confirm_update_cuenta();
            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },
        confirm_update_cuenta: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function () {
            var self = this;
            var url = this.url_cuenta_fondo_store + '/' + this.form.cuenta_fondo.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta_fondo.cuenta
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente',
                    }).then(function () {
                        self.data.fondo_edit.cuenta_fondo = data.data.cuenta_fondo;
                        self.close_edit_cuenta();
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        confirm_save_cuenta: function () {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.save_cuenta();
                }
            }).catch(swal.noop);
        },

        save_cuenta: function () {
            var self = this;
            var url = this.url_cuenta_fondo_store;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta_fondo.cuenta,
                    id_fondo: self.form.cuenta_fondo.id_fondo
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente',
                    }).then(function () {
                        self.data.fondo_edit.cuenta_fondo = data.data.cuenta_fondo;
                        self.close_edit_cuenta();
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        close_edit_cuenta: function () {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form.cuenta_fondo, 'cuenta', '');
            Vue.set(this.form.cuenta_fondo, 'id', '');
            Vue.set(this.form.cuenta_fondo, 'id_fondo', '');
        }
    }
});
