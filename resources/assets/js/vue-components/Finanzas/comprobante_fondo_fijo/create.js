Vue.component('comprobante-fondo-fijo-create', {
    props: ['url_comprobante_fondo_fijo_create'],

    data: function () {
        return {
            'form': {
                'comprobante': {
                    'id_referente': '',
                    'referencia': '',
                    'cumplimiento': '',
                    'fecha':'',
                    'id_naturaleza': '',
                    'id_concepto':'',
                    'id_transaccion':'',
                    'observaciones':''
                },
                'items':[],
                'total':'',
                'subtotal':'',
                'iva':'',
                'cambio_iva':false
            },
            current_item : {},
            guardando : false
        }
    },

    computed:{

        total: function () {

            var self=this;
            var impuesto=0;
            if(self.form.iva>0){
                impuesto=parseFloat(self.form.iva);
            }

            var subtotal=parseFloat(this.subtotal);
            var total=impuesto+subtotal;
            self.form.total=total;

            return total;
        },
        subtotal: function () {
            var self=this;
            var total=0;

            if(self.form.comprobante.id_naturaleza==0){
                if(this.form.items) {
                    this.form.items.forEach(function (item) {
                        total+=parseFloat(item.importe);
                    });
                }
            }else{
                if(this.form.items) {
                    this.form.items.forEach(function (item) {
                        total+=parseFloat(item.cantidad * item.precio_unitario);
                    });
                }
            }

            return parseFloat(total);
        }

    },

    mounted: function () {
        var self = this;
        var jstree = "";
        var jstree2 = "";
        var auxiliar=0;

        $('#concepto_select').on('select2:select', function () {


            if(auxiliar==1){
                jstree.destroy();
                jstree2.destroy();
            }
            carga_arbol();
            $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
            self.form.comprobante.id_concepto = $('#concepto_select option:selected').data().data.id;
            $.each( self.form.items, function( key, item ) {
                item.destino='';

            });

        });

        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'cumplimiento', $('#cumplimiento').val())
        });

        $("#fecha").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'fecha', $('#fecha').val())
        });

        function carga_arbol() {
            // JsTree Configuration
            auxiliar=1;
            var jstreeConf = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function (node) {

                            var conceptos = "";
                            var materiales = "";

                            if (node.id === "#") {
                                return App.host + '/conceptos/' + $('#id_concepto').val() + '/jstree';
                            }

                            return App.host + '/conceptos/' + node.id + '/jstree';
                        },
                        "data": function (node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'default': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'medible': {
                        'icon': 'fa fa-file-text'
                    },
                    'material': {
                        'icon': 'fa fa-briefcase'
                    },
                    'opened': {
                        'icon': 'fa fa-folder-open-o text-success'
                    },
                    'inactivo': {
                        'icon': 'fa fa-exclamation-triangle'
                    }
                },
                'plugins': ['types']
            };

            $('#jstree').on("after_open.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
                estilos_nodos();
            });


            /////////Arbol Materiales

            // JsTree Configuration
            var jstreeConfM = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function (node) {
                            if (node.id === "#") {
                                return App.host + '/almacen/jstree';
                            }
                            return App.host + '/almacen/' + node.id + '/jstree';
                        },
                        "data": function (node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'folder': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'almacen': {
                        'icon': 'fa fa-briefcase'
                    },
                    'inactivo': {
                        'icon': 'fa fa-exclamation-triangle'
                    }

                },
                'plugins': ['types']
            };

            $('#jstreeM').on("select_node.jstree", function (e, data) {
                var jstreeD = $('#jstree').jstree(true);
                var node = jstreeD.get_selected(true)[0];
                $('#jstree').jstree(true).deselect_node(node);
                if (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo') {
                    $('#jstreeM').jstree(true).deselect_node(data.node);
                }

            });

            $('#jstree').on("select_node.jstree", function (e, data) {

                var jstreeM = $('#jstreeM').jstree(true);
                var node = jstreeM.get_selected(true)[0];
                $('#jstreeM').jstree(true).deselect_node(node);

                if (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo') {
                    $('#jstree').jstree(true).deselect_node(data.node);
                }
            });

            $('#jstreeM').on("after_open.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
                estilos_nodos();
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
            });

            $('#jstreeM').on("loaded.jstree", function (e, data) {
                estilos_nodos();
            });

            $('#jstree').on("loaded.jstree", function (e, data) {
                estilos_nodos();
            });

            // On hide the BS modal, get the selected node and destroy the jstree
            $('#myModal').on('shown.bs.modal', function (e) {
                $('#jstreeM').jstree(jstreeConfM);
                $('#jstree').jstree(jstreeConf);
            }).on('hidden.bs.modal', function (e) {

                jstree = $('#jstree').jstree(true);
                var node = jstree.get_selected(true)[0];
                jstree2 = $('#jstreeM').jstree(true);
                var node2 = jstree2.get_selected(true)[0];

                if (node) {
                    self.current_item.id_concepto = node.id;
                    self.current_item.tipo_concepto = "";
                    self.current_item.destino = node.text;
                } else {


                    self.current_item.id_concepto = "";
                    self.current_item.tipo_concepto = "";
                    self.current_item.destino = "";

                    if (node2) {
                        if (node2.type == 'almacen')
                            self.current_item.id_concepto = node2.id;
                        self.current_item.tipo_concepto = node2.type;
                        self.current_item.destino = node2.text;
                    }
                }

            });

        }
        function estilos_nodos() {
            $(".fa-folder-o").parent( "a" ).css( "color", "gray" );
            $(".fa-folder-o").parent( "a" ).css( "cursor", "not-allowed" );
            $(".fa-folder-open-o").parent( "a" ).css( "color", "gray" );
            $(".fa-folder-open-o").parent( "a" ).css( "cursor", "not-allowed" );
            $(".fa-exclamation-triangle").parent( "a" ).css( "color", "gray" );
            $(".fa-exclamation-triangle").parent( "a" ).css( "text-decoration", "line-through" );
            $(".fa-exclamation-triangle").parent( "a" ).css( "cursor", "not-allowed" );

        }

    },

    directives: {
        datepicker: {
            inserted: function (el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        },
        select2: {
            inserted: function (el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/concepto/getBy',
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
                                        text: item.path,
                                        id: item.id_concepto
                                    }
                                })
                            };
                        },
                        error: function (error) {

                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                });
            }
        },
        select_material: {

            inserted: function (el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/finanzas/material/getBy',
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
                                results: $.map(data.data.materiales, function (item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id_material,
                                        unidad:item.unidad
                                    }
                                })
                            };
                        },
                        error: function (error) {

                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    var id=el.id;


                    $('#I'+id).val($('#'+id+' option:selected').data().data.id);
                    $('#L'+id).text($('#'+id+' option:selected').data().data.unidad);
                    $('#UL'+id).text($('#'+id+' option:selected').data().data.unidad);

                    $('#btn'+id).click();

                });
            }
        }
    },
    methods: {

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'confirm_save_fondo') {
                this.confirm_add_movimiento();
            }

        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        }
        ,

        confirm_add_movimiento: function () {
            var self = this;
            swal({
                title: "Guardar Comprobante de Fondo Fijo",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_comprobante_fondo_fijo();
            }).catch(swal.noop);
        },

        add_item: function () {
            var self=this;
            self.form.items.push({
                'id_transaccion':'',
                'id_concepto':'',
                'id_material':'',
                'cantidad':'',
                'precio_unitario':'',
                'importe':'',
                'destino':'',
                'unidad':'',
                'gastos_varios':'',
                'tipo_concepto':''
            });
        },

        item_material:function (id,item) {
            var idELemnt=id+1;
            this.current_item = item;
            this.current_item.id_material =  $('#I'+idELemnt).val();
        }
        ,

        curent_item:function (item) {
            this.current_item = item;
        }
        ,
        confirm_remove_item: function (index) {
            var self = this;
            swal({
                title: "Quitar Item",
                text: "¿Estás seguro de que deseas quitar el Item del comprobante?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.remove_item(index);
            }).catch(swal.noop);
        },
        remove_item:function (index) {
            Vue.delete(this.form.items, index);
        },
        habilitaIva:function () {
            var self = this;
            self.form.iva=self.subtotal*.16;

        },
        save_comprobante_fondo_fijo: function () {
            var self = this;
            var url = this.url_comprobante_fondo_fijo_create;
            var data = self.form;
            console.log(url);
            $.ajax({
                type: 'POST',
                url:url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: 'Comprobante de Fondo Fijo guardado correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).catch(swal.noop);
                    window.location = App.host+"/finanzas/comprobante_fondo_fijo/"+data.data.comprobante.id_transaccion;

                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }


    }
});
