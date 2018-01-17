Vue.component('cuenta-costo-index', {
    props: ['costos','url_costo_get_by', 'url_costo_find_by', 'datos_contables', 'url_cuenta_costo_index'],
    data: function () {
        return {
            'data': {
                'costos' : this.costos,

            },
            'form': {
                'costo_edit' : {},
                'cuenta' : '',
                'costo' : '',
                'id_cuenta_costo' : '',
                'id_costo' : ''
            },
            'cargando': false,
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
                    saveState: true
                });
            }
        },
        select2: {
            inserted: function (el){

                $(el).select2({
                    width:'100%',
                    ajax: {
                        url: App.host + '/sistema_contable/costo/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%',
                                with: 'cuentaCosto'
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.data.costos, function (item) {
                                    return {
                                        text:item.descripcion,
                                        id: item.id_costo
                                    }
                                })
                            };
                        },
                        error: function(error) {

                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    $('#id_costo').val($('#costo_select option:selected').data().data.id);
                });
            }
        }
    },

    computed: {
        costos_ordenados: function () {
            return this.data.costos.sort(function(a,b) {return (a.nivel > b.nivel) ? 1 : ((b.nivel > a.nivel) ? -1 : 0);} );
        }
    },

    methods: {
        tr_class: function(costo) {
            var treegrid = "treegrid-" + costo.id_costo;
            var treegrid_parent = costo.id_padre != null && costo.id_costo != parseInt($('#id_costo').val()) ?  " treegrid-parent-" + costo.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function (costo) {
            return costo.id_padre == null || costo.tiene_hijos > 0 ? "tnode-" + costo.id_costo : "";
        },

        get_hijos: function(costo) {
            var self = this;

            $.ajax({
                type:'GET',
                url: self.url_costo_get_by,
                data:{
                    attribute: 'nivel',
                    operator: 'like',
                    value: costo.nivel_hijos,
                    with: 'cuentaCosto'
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    data.data.costos.forEach(function (costo) {
                        self.data.costos.push(costo);
                    });
                    costo.cargado = true;
                },
                complete: function() {
                    self.cargando = false;
                    setTimeout(
                        function()
                        {
                            $('#tnode-' + costo.id_costo).treegrid('expand');
                        }, 500);
                }
            });
        },

        edit_cuenta: function (costo) {
            this.form.costo_edit = costo;
            Vue.set(this.form, 'costo', costo.descripcion);
            Vue.set(this.form, 'id_costo', costo.id_costo);
            if (costo.cuenta_costo != null) {
                Vue.set(this.form, 'cuenta', costo.cuenta_costo.cuenta);
                Vue.set(this.form, 'id_cuenta_costo', costo.cuenta_costo.id_cuenta_costo);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id_cuenta_costo', '');
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
            var url = this.url_cuenta_costo_index + '/' + this.form.id_cuenta_costo;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    data: self.form
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.form.costo_edit.cuenta_costo = data.data.cuenta_costo;
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
            var url = this.url_cuenta_costo_index;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta,
                    id_costo: self.form.id_costo
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.form.costo_edit.cuenta_costo = data.data.cuenta_costo;
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
        confirm_delete_cuenta: function (id_cuenta_costo) {
            var self = this;
            swal({
                title: "Eliminar Cuenta Contable",
                text: "¿Estás seguro que desea eliminar la cuenta contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.delete_cuenta(id_cuenta_costo);
                }
            }).catch(swal.noop);
        },
        delete_cuenta: function (id_cuenta_costo) {
            var self = this,
                url = this.url_cuenta_costo_index + '/' + id_cuenta_costo;

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _method: 'DELETE'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.costos.forEach(function (costo, i) {

                        if (costo.cuenta_costo == null){
                            return;
                        }

                        if (id_cuenta_costo == costo.cuenta_costo.id_cuenta_costo) {
                            Vue.set(costo, 'cuenta_costo', null);
                            Vue.set(self.data.costos, i, costo);
                            return;
                        }
                    });

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        text: 'Cuenta Contable eliminada correctamente'
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
            Vue.set(this.form, 'costo', '');
            Vue.set(this.form, 'id_cuenta_costo', '');
            Vue.set(this.form, 'id_costo', '');
        },

        buscar_nodos:function () {
            var self = this;
            var url = self.url_costo_find_by,
                id_costo = $('#id_costo').val();

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    attribute : 'id_costo',
                    value : id_costo,
                    with: 'cuentaCosto'
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (result) {
                    self.data.costos = [];
                    if (result.data.costo != null) {
                        self.data.costos.push(result.data.costo);
                    }
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        }
    }
});
