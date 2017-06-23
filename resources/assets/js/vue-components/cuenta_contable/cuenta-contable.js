Vue.component('cuenta-contable', {
    props: [
        'obra',
        'obra_update_url',
        'cuenta_update_url',
        'cuenta_store_url',
        'tipos_cuentas_contables',
        'cuentas_contables'
    ],
    data: function() {
        return {
            'data' : {
                'obra': this.obra,
                'tipos_cuentas_contables' : this.tipos_cuentas_contables,
                'tipos_cuentas_contables_update' : this.tipos_cuentas_contables_update,
                'cuentas_contables' : this.cuentas_contables
            },
            'form': {
                'cuenta_contable': {
                    'id_int_tipo_cuenta_contable': '',
                    'prefijo': '',
                    'cuenta_contable': '',
                    'con_prefijo':false
                },
                'cuenta_contable_update': {
                    'id_int_cuenta_contable':'',
                    'id_int_tipo_cuenta_contable': '',
                    'prefijo': '',
                    'cuenta_contable': '',
                    'con_prefijo':false
                },

            },
            'guardando' : false
        }
    },
    computed:{
        tipos_cuentas_contables_disponibles: function () {
            var self = this;
            var result = {};
            $.each(this.data.tipos_cuentas_contables, function (index, tipo_cuenta_contable) {
                var existe = false;
                self.data.cuentas_contables.forEach(function (cuenta_contable) {
                    if(cuenta_contable.id_int_tipo_cuenta_contable == index) {
                        existe = true;
                    }
                });

                if(! existe) {
                    result[index] = tipo_cuenta_contable;
                }
            });

            return result;
        },
        tipos_cuentas_contables_update:function () {
            var self = this;
            var result = {};
            $.each(this.data.tipos_cuentas_contables, function (index, tipo_cuenta_contable) {
                var existe = false;
                self.data.cuentas_contables.forEach(function (cuenta_contable) {
                    if(cuenta_contable.id_int_tipo_cuenta_contable == index&&index!=self.form.cuenta_contable_update.id_int_tipo_cuenta_contable) {
                        existe = true;
                    }
                });

                if(! existe) {
                    result[index] = tipo_cuenta_contable;
                }
            });

            return result;
        }
    }
    ,

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
                    BDContPaq : self.data.obra.BDContPaq,
                    FormatoCuenta : self.data.obra.FormatoCuenta,
                    NumobraContPaq : self.data.obra.NumobraContPaq,
                    _method : 'PATCH'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.obra = data.data.obra;
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos de la Obra <b>' +self.data.obra.nombre + '</b> actualizados correctamente',
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
                self.save_cuenta_contable();
            }).catch(swal.noop);
        },
        confirm_cuenta_contable_update: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta",
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
                    Vue.set(self.data, 'cuentas_contables', data.data.cuentas_contables);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> configurada correctamente'
                    });
                    self.reset_form();
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        update_cuenta_contable:function () {
            var self = this;
            var data = self.form.cuenta_contable_update;
            var url=App.host+'/modulo_contable/cuenta_contable/'+data.id_cuenta_contable;
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
                    Vue.set(self.data, 'cuentas_contables', data.data.cuentas_contables);
                    $('#closeModal').click();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos de la cuenta <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> actualizados correctamente',
                    });
                    self.reset_form();
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_datos_obra') {
                    this.confirm_datos_obra();
                } else if (funcion == 'save_datos_cuenta') {
                    this.confirm_cuenta_contable();
                }
                  else if (funcion == 'save_datos_cuenta_update') {
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
        editar:function (e){
            Vue.set(this.form.cuenta_contable_update, 'id_int_tipo_cuenta_contable',e.id_int_tipo_cuenta_contable);
            Vue.set(this.form.cuenta_contable_update, 'id_int_cuenta_contable',e.id_int_cuenta_contable);
            Vue.set(this.form.cuenta_contable_update, 'cuenta_contable', e.cuenta_contable);
            Vue.set(this.form.cuenta_contable_update, 'con_prefijo', e.prefijo?true:false);
        },

        reset_form: function () {
            Vue.set(this.form.cuenta_contable, 'id_int_tipo_cuenta_contable', '');
            Vue.set(this.form.cuenta_contable, 'prefijo', '');
            Vue.set(this.form.cuenta_contable, 'cuenta_contable', '');
            Vue.set(this.form.cuenta_contable, 'con_prefijo', false);

            Vue.set(this.form.cuenta_contable_update, 'id_int_tipo_cuenta_contable', '');
            Vue.set(this.form.cuenta_contable_update, 'prefijo', '');
            Vue.set(this.form.cuenta_contable_update, 'cuenta_contable', '');
            Vue.set(this.form.cuenta_contable_update, 'con_prefijo', false);
        }
    }
});