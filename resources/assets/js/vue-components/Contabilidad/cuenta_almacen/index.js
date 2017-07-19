Vue.component('cuenta-almacen-index', {
    props: ['datos_contables', 'url_cuenta_almacen_store', 'almacenes'],
    data: function() {
        return {
            'data' : {
                'almacenes' : this.almacenes,
                'almacen_edit': {}
            },
            'form': {
                'cuenta_almacen': {
                    'id': '',
                    'id_almacen': '',
                    'cuenta' : ''
                }
            },
            'guardando' : false
        }
    },
    methods:{
        editar:function (almacen){
            this.data.almacen_edit = almacen;
            Vue.set(this.form.cuenta_almacen, 'id_almacen', almacen.id_almacen);
            if(almacen.cuenta_almacen != null){
                Vue.set(this.form.cuenta_almacen, 'cuenta', almacen.cuenta_almacen.cuenta);
                Vue.set(this.form.cuenta_almacen, 'id', almacen.cuenta_almacen.id);
            }else{
                Vue.set(this.form.cuenta_almacen, 'cuenta', '');
                Vue.set(this.form.cuenta_almacen, 'id', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(result => {
                if (result) {
                    if(funcion == 'confirm_save_cuenta') {
                        this.confirm_save_cuenta();
                    } else if (funcion == 'confirm_update_cuenta') {
                        this.confirm_update_cuenta();
                    }
                } else {
                    swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
                }
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
        },

        update_cuenta: function () {
            var self = this;
            var url = this.url_cuenta_almacen_store + '/' + this.form.cuenta_almacen.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta_almacen.cuenta
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.almacen_edit.cuenta_almacen = data.data.cuenta_almacen;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente',
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
            }).then(function () {
                self.save_cuenta();
            }).catch(swal.noop);
        },

        save_cuenta: function () {
            var self = this;
            var url = this.url_cuenta_almacen_store;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta_almacen.cuenta,
                    id_almacen: self.form.cuenta_almacen.id_almacen
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.almacen_edit.cuenta_almacen = data.data.cuenta_almacen;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        close_edit_cuenta: function () {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form.cuenta_almacen, 'cuenta', '');
            Vue.set(this.form.cuenta_almacen, 'id', '');
            Vue.set(this.form.cuenta_almacen, 'id_almacen', '');
        }

    }
});
