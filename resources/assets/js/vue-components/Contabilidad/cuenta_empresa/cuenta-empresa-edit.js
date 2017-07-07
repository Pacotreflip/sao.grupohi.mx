Vue.component('cuenta-empresa-edit', {
    props: ['empresa', 'tipo_cuenta_empresa','cuenta_store_url','datos_contables'],

    data: function () {
        return {
            'data': {
                'empresa': this.empresa
            },
            'form': {
                'cuenta_empresa': '',
                'cuenta_empresa_create': {
                    'id':'',
                    'cuenta': '',
                    'id_empresa':'',
                    'id_tipo_cuenta_empresa': '',
                    'tipo_cuenta_empresa': {
                        'descripcion': ''
                    }


                }
            },
            'guardando': false,
            'nuevo_registro': false
        }
    },
    methods: {
        cerrar_dialog: function () {
            $('#add_movimiento_modal').modal('hide');
            $('#edit_movimiento_modal').modal('hide');
        },
        confirm_elimina_cuenta: function (cuenta) {
            var self = this;
            self.form.cuenta_empresa = cuenta;
            self.form.cuenta_empresa.id_empresa = cuenta.id_empresa;
            swal({
                title: "Eliminar Cuenta de Empresa",
                text: "¿Estás seguro que desea eliminar la cuenta: " + cuenta.tipo_cuenta_empresa.descripcion + "?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {

                self.elimina_cuenta();
            }).catch(swal.noop);

        },
        confirm_cuenta_update: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta de Empresa",
                text: "¿Estás seguro que desea actualizar la cuenta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Actualizar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {

                self.update_cuenta_empresa();
            }).catch(swal.noop);

        },
        confirm_cuenta_create: function () {
            var self = this;
            swal({
                title: "Crear Cuenta de Empresa",
                text: "¿Estás seguro que desea guardar la cuenta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Guardar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
              self.save_cuenta_empresa();
            }).catch(swal.noop);

        },
        elimina_cuenta: function () {
            var self = this;
            var data = self.form.cuenta_empresa;
            var url = App.host + '/sistema_contable/cuenta_empresa/' + self.form.cuenta_empresa.id;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'DELETE'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    Vue.set(self.data, 'empresa', data.data.empresa);
                    $('#add_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + self.form.cuenta_empresa.tipo_cuenta_empresa.descripcion + '</b> fue eliminada correctamente',
                    });

                },
                complete: function () {
                    self.guardando = false;
                }
            });


        },
        create_cuenta_empresa: function () {
            var self = this;
            self.form.cuenta_empresa_create.cuenta = '';
            self.form.cuenta_empresa_create.id_tipo_cuenta_empresa = '';
            self.form.cuenta_empresa_create.id_empresa = self.data.empresa.id_empresa;
            self.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion = '';
            self.nuevo_registro = true;
            self.validation_errors.clear('form_create_cuenta');
            $('#add_movimiento_modal').modal('show');
        },
        edit_cuenta_empresa: function (cuenta) {
            var self = this;
            self.nuevo_registro = false;
            self.form.cuenta_empresa_create.cuenta = cuenta.cuenta;
            self.form.cuenta_empresa_create.id_tipo_cuenta_empresa = cuenta.id_tipo_cuenta_empresa;
            self.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion = cuenta.tipo_cuenta_empresa.descripcion;
            self.form.cuenta_empresa_create.id = cuenta.id;
            self.form.cuenta_empresa_create.id_empresa = cuenta.id_empresa;


            $('#edit_movimiento_modal').modal('show');
        },
        update_cuenta_empresa: function (cuenta) {
            var self = this;
            var data = self.form.cuenta_empresa_create;
            var url = App.host + '/sistema_contable/cuenta_empresa/' + self.form.cuenta_empresa_create.id;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'PATCH'
                },
                beforeSend: function () {
                    self.validation_errors.clear('form_update_cuenta');
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    Vue.set(self.data, 'empresa', data.data.empresa);
                    $('#edit_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + self.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion + '</b> fue actualizada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }
        ,
        save_cuenta_empresa: function () {
            var self = this;
            var url = self.cuenta_store_url;
            var data = self.form.cuenta_empresa_create;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.validation_errors.clear('form_create_cuenta');
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    Vue.set(self.data, 'empresa', data.data.empresa);
                    $('#add_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + self.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion + '</b> fue creada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }
        ,
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'confirm_edit_cuenta') {
                this.confirm_cuenta_update();
            }
            else if (funcion == 'confirm_create_cuenta') {
                this.confirm_cuenta_create();
            }

        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        }
    },

    computed: {

        cuentas_empresa_disponibles: function () {

                var self = this;
                var result = {};
                $.each(this.tipo_cuenta_empresa, function (index, tipo_cuenta_empresa) {
                    var existe = false;
                    self.data.empresa.cuentas_empresa.forEach(function (cuenta) {
                        if(cuenta.id_tipo_cuenta_empresa == tipo_cuenta_empresa.id) {
                            existe = true;
                        }
                    });

                    if(! existe) {
                        result[index] = tipo_cuenta_empresa;
                    }
                });

                return result;
        }


    }
});