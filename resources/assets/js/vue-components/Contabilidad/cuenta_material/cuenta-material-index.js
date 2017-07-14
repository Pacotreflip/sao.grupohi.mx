Vue.component('cuenta-material-index', {
    props: ['datos_contables', 'url_cuenta_material_store', 'familia'],
    data: function() {
        return {
            'data' : {
                'familia': this.familia,
                'items': [],
                'cuenta_material_edit': {}
            },
            'form': {
                'cuenta_material': {
                    'id': '',
                    'cuenta': '',
                    'id_tipo_cuenta_material' : 0,
                    'id_material':''
                }
            },
            valor: '0',
            guardando : false

        }
    },
    methods:{
        cambio: function () {
            var self = this;
            var id = self.valor;
            if(id != 0){
                var urla = App.host + '/sistema_contable/cuenta_material/';
                $.ajax({
                    type: 'GET',
                    url: urla + id,

                    success: function(response) {
                        self.data.items = response;
                    }
                });
            }
        },

        edit: function (item) {
            var urle = App.host + '/sistema_contable/cuenta_material/'+item.tipo_material+'/material/'+item.nivel;
            window.location = urle;
        },

        editar:function (material){
            this.data.cuenta_material_edit = material;
            Vue.set(this.form.cuenta_material, 'id_material', material.id_material);
            if(material.cuenta_material != null){
                Vue.set(this.form.cuenta_material, 'cuenta', material.cuenta_material.cuenta);
                Vue.set(this.form.cuenta_material, 'id', material.cuenta_material.id);
                Vue.set(this.form.cuenta_material, 'id_tipo_cuenta_material', material.cuenta_material.id_tipo_cuenta_material);
            }else{
                Vue.set(this.form.cuenta_material, 'cuenta', '');
                Vue.set(this.form.cuenta_material, 'id', '');
                Vue.set(this.form.cuenta_material, 'id_tipo_cuenta_material',0);
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'confirm_save_cuenta' && this.form.cuenta_material.id_tipo_cuenta_material != 0 ) {
                this.confirm_save_cuenta();
            } else if (funcion == 'confirm_update_cuenta' && this.form.cuenta_material.id_tipo_cuenta_material != 0) {
                this.confirm_update_cuenta();
            }else{
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor seleccione un Tipo Cuenta de Material.'
                });
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
        },

        update_cuenta: function () {
            var self = this;
            var url = this.url_cuenta_material_store + '/' + this.form.cuenta_material.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta_material.cuenta,
                    id_tipo_cuenta_material: self.form.cuenta_material.id_tipo_cuenta_material
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.cuenta_material_edit.cuenta_material = data.data.cuenta_material;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Material actualizada correctamente',
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
                title: "Registrar Cuenta de Material",
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
            var url = this.url_cuenta_material_store;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta_material.cuenta,
                    id_almacen: self.form.cuenta_material.id_almacen,
                    id_tipo_cuenta_material: self.form.cuenta_material.id_tipo_cuenta_material,
                    id_material: self.form.cuenta_material.id_material

                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.cuenta_material_edit.cuent_material = data.data.cuenta_material;
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
            Vue.set(this.form.cuenta_material, 'cuenta', '');
            Vue.set(this.form.cuenta_material, 'id', '');
            Vue.set(this.form.cuenta_material, 'id_material', '');
            Vue.set(this.form.cuenta_material, 'id_tipo_cuenta_material', 0);
        }
    }

});
