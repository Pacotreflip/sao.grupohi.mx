Vue.component('cuenta-material-index', {
    props : ['material_url', 'url_store_cuenta', 'datos_contables', 'tipos_cuenta_material'],
    data : function () {
        return {
            materiales: [],
            form: {
                id_tipo_cuenta_material: '',
                tipo_material: '',
                material_edit: {},
                cuenta: '',
                material: '',
                id: '',

                id_material: ''
            },
            cargando: false
        }
    },

    directives: {
        treegrid: {
            inserted: function (el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            },
            componentUpdated:function (el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            }
        },

        select2 : {
            inserted: function (el) {
                $(el).select2({
                    width: '100%'
                })
            }
        }
    },

    computed: {
        materiales_ordenados: function () {
            return this.materiales.sort(function(a,b) {return (a.nivel > b.nivel) ? 1 : ((b.nivel > a.nivel) ? -1 : 0);} );
        }
    },

    methods: {
        fetch_materiales: function () {
            var self = this;
            $.ajax({
                type: 'GET',
                url: self.material_url + '/getFamiliasByTipo',
                data: {
                    tipo_material: self.form.tipo_material
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.materiales = data.data.materiales;
                },
                complete: function () {
                    self.cargando = false;
                }
            })
        },

        tr_class: function(material) {
            var treegrid = "treegrid-" + material.id_material;
            var treegrid_parent = material.id_padre != null ? " treegrid-parent-" + material.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function (material) {
            return material.id_padre == null || material.tiene_hijos > 0 ? "tnode-" + material.id_material : "";
        },

        get_hijos: function(material) {
            var self = this;

            $.ajax({
                type:'GET',
                url: self.material_url + '/' + material.id_material + '/getHijos',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    data.data.materiales.forEach(function (material) {
                        self.materiales.push(material);
                    });
                    material.cargado = true;
                },
                complete: function() {
                    self.cargando = false;
                    setTimeout(
                        function()
                        {
                            $('#tnode-' + material.id_material).treegrid('expandRecursive');
                        }, 500);
                }
            });
        },

        edit_cuenta: function (material) {
            this.form.material_edit = material;
            Vue.set(this.form, 'material', material.descripcion);
            Vue.set(this.form, 'id_material', material.id_material);
            if (material.cuenta_material != null) {
                Vue.set(this.form, 'cuenta', material.cuenta_material.cuenta);
                Vue.set(this.form, 'id', material.cuenta_material.id);
                Vue.set(this.form, 'id_tipo_cuenta_material', material.cuenta_material.id_tipo_cuenta_material);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id', '');
                Vue.set(this.form, 'id_tipo_cuenta_material', '');
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
            }).catch(swal.noop);
        },

        update_cuenta: function () {
            var self = this;
            var url = this.url_store_cuenta + '/' + this.form.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta,
                    id_tipo_cuenta_material: self.form.id_tipo_cuenta_material
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.form.material_edit.cuenta_material = data.data.cuenta_material;
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
            }).then(function (result) {
                if(result.value) {
                    self.save_cuenta();
                }
            }).catch(swal.noop);
        },

        save_cuenta: function () {
            var self = this;
            var url = this.url_store_cuenta;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta,
                    id_material: self.form.id_material,
                    id_tipo_cuenta_material: self.form.id_tipo_cuenta_material
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.form.material_edit.cuenta_material = data.data.cuenta_material;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        close_edit_cuenta: function () {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form, 'cuenta', '');
            Vue.set(this.form, 'material', '');
            Vue.set(this.form, 'id', '');
            Vue.set(this.form, 'id_tipo_cuenta_material', '');
            Vue.set(this.form, 'id_material', '');
        }
    }
});