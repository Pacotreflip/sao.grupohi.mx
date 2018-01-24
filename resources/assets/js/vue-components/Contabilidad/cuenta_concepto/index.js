Vue.component('cuenta-concepto-index', {
    props: ['conceptos','url_concepto_get_by', 'datos_contables', 'url_store_cuenta'],
    data: function () {
        return {
            'data': {
                'conceptos' : this.conceptos,

            },
            'form': {
                'concepto_edit' : {},
                'cuenta' : '',
                'concepto' : '',
                'id' : '',
                'id_concepto' : ''
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
                        url: App.host +'/sistema_contable/concepto/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.data.conceptos, function (item) {
                                    return {
                                        text:item.descripcion,
                                        id: item.id_concepto
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
                    $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
                });
            }
        }
    },

    computed: {
        conceptos_ordenados: function () {
            return this.data.conceptos.sort(function(a,b) {return (a.nivel > b.nivel) ? 1 : ((b.nivel > a.nivel) ? -1 : 0);} );
        }
    },

    methods: {
        tr_class: function(concepto) {
            var treegrid = "treegrid-" + concepto.id_concepto;
            var treegrid_parent = concepto.id_padre != null && concepto.id_concepto != parseInt($('#id_concepto').val()) ?  " treegrid-parent-" + concepto.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function (concepto) {
            return concepto.id_padre == null || concepto.tiene_hijos > 0 ? "tnode-" + concepto.id_concepto : "";
        },

        get_hijos: function(concepto) {
            var self = this;

            $.ajax({
                type:'GET',
                url: self.url_concepto_get_by,
                data:{
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos,
                    with : 'cuentaConcepto'
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    data.data.conceptos.forEach(function (concepto) {
                        self.data.conceptos.push(concepto);
                    });
                    concepto.cargado = true;
                },
                complete: function() {
                    self.cargando = false;
                    setTimeout(
                        function()
                        {
                            $('#tnode-' + concepto.id_concepto).treegrid('expand');
                        }, 500);
                }
            });
        },

        edit_cuenta: function (concepto) {
            this.form.concepto_edit = concepto;
            Vue.set(this.form, 'concepto', concepto.descripcion);
            Vue.set(this.form, 'id_concepto', concepto.id_concepto);
            if (concepto.cuenta_concepto != null) {
                Vue.set(this.form, 'cuenta', concepto.cuenta_concepto.cuenta);
                Vue.set(this.form, 'id', concepto.cuenta_concepto.id);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id', '');
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
            }).then(function(result) {
                if(result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function () {
            var self = this;
            var url = this.url_store_cuenta + '/' + this.form.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta
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
                        self.form.concepto_edit.cuenta_concepto = data.data.cuenta_concepto;
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
            });
        },

        save_cuenta: function () {
            var self = this;
            var url = this.url_store_cuenta;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta,
                    id_concepto: self.form.id_concepto
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
                        self.form.concepto_edit.cuenta_concepto = data.data.cuenta_concepto;
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
            Vue.set(this.form, 'cuenta', '');
            Vue.set(this.form, 'concepto', '');
            Vue.set(this.form, 'id', '');
            Vue.set(this.form, 'id_concepto', '');
        },

        buscar_nodos:function () {
            var id_concepto = $('#id_concepto').val();

            var self = this;
            var url = App.host+'/sistema_contable/concepto/findBy';
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    attribute : 'id_concepto',
                    operator : '=',
                    value : id_concepto,
                    with: 'cuentaConcepto'
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.conceptos = [];
                    if (data.data.concepto != null) {
                        self.data.conceptos.push(data.data.concepto);
                    }
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        }
    }
});
