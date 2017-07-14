Vue.component('cuenta-contable-index', {
    props: [
        'datos_contables',
        'cuenta_contable_url',
        'tipos_cuentas_contables'
    ],
    data: function() {
        return {
            'data' : {
                'tipos_cuentas_contables' : this.tipos_cuentas_contables
            },
            'form': {
                'tipo_cuenta_contable_edit' : {
                    'cuenta_contable' : {
                        'con_prefijo' : false
                    }
                },
            },
            'guardando' : false
        }
    },

    methods: {
        confirm_cuenta_contable: function () {
            var self = this;
            swal({
                title: "Configurar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_cuenta_contable();
            }).catch(swal.noop);
        },

        confirm_cuenta_contable_update: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.update_cuenta_contable();
            }).catch(swal.noop);
        },

        save_cuenta_contable: function () {
            var self = this;
            var url = self.cuenta_contable_url;
            var data = {
                id_int_tipo_cuenta_contable : self.form.tipo_cuenta_contable_edit.id_int_tipo_cuenta_contable,
                prefijo : self.form.tipo_cuenta_contable_edit.cuenta_contable.prefijo,
                cuenta_contable : self.form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable,
                con_prefijo : self.form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo
            };

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.validation_errors.clear('form_save_cuenta');
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> configurada correctamente'
                    });
                },
                complete: function () {
                    self.reset_form();
                    $('#modal-configurar-cuenta').modal('hide');
                    self.guardando = false;
                }
            });
        },
        update_cuenta_contable:function () {
            var self = this;
            var data = {
                con_prefijo : this.form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo,
                prefijo : this.form.tipo_cuenta_contable_edit.cuenta_contable.prefijo,
                cuenta_contable : this.form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable
            };
            var url = self.cuenta_contable_url + '/' + this.form.tipo_cuenta_contable_edit.cuenta_contable.id_int_cuenta_contable;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                     data:data,
                    _method : 'PATCH'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> actualizada correctamente'
                    });
                },
                complete: function () {
                    self.reset_form();
                    $('#modal-editar-cuenta').modal('hide');
                    self.guardando = false;
                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'save_cuenta') {
                    this.confirm_cuenta_contable();
                }else if (funcion == 'update_cuenta') {
                    this.confirm_cuenta_contable_update();
                }
            }).catch(() => {
                swal({
                     type: 'warning',
                     title: 'Advertencia',
                     text: 'Por favor corrija los errores del formulario'
                 });
            });
        },

        editar : function (item){
            Vue.set(this.form.tipo_cuenta_contable_edit, 'id_int_tipo_cuenta_contable', item.id_int_tipo_cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit, 'descripcion', item.descripcion);

            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'id_int_cuenta_contable', item.cuenta_contable.id_int_cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'cuenta_contable', item.cuenta_contable.cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'prefijo', item.cuenta_contable.prefijo);
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'con_prefijo', item.cuenta_contable.prefijo ? true : false);
        },

        configurar : function (item){
            Vue.set(this.form.tipo_cuenta_contable_edit, 'id_int_tipo_cuenta_contable', item.id_tipo_cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit, 'descripcion', item.descripcion);

            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'id_int_cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'prefijo', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'con_prefijo', false);
        },

        reset_form : function () {
            Vue.set(this.form.tipo_cuenta_contable_edit, 'id_int_tipo_cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit, 'descripcion', '');

            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'id_int_cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'prefijo', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'con_prefijo', false);
        }
    }
});