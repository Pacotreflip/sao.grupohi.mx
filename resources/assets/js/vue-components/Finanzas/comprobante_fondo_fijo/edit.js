Vue.component('comprobante-fondo-fijo-edit', {
    props: ['url_comprobante_fondo_fijo_update','url_comprobante_fondo_fijo_show','comprobante_items','comprobante'],

    data: function () {
        return {
            'form': {
                'comprobante':this.comprobante,
                'items':this.comprobante_items,
                'total':'',
                'subtotal':'',
                'iva':0.0,
                'cambio_iva':false
            },
            current_item : {},
            guardando : false
        }
    },

    computed:{

        total: function () {
           var self=this;
            var total=0;
            if(this.form.items) {
               this.form.items.forEach(function (item) {
                   total+=(item.cantidad * item.precio_unitario);
               });
           }
            var calculo=self.form.iva/100;
           if(self.form.iva>0){
               total=(total*calculo)+total;
           }

           self.form.total=total;
           return parseFloat(total).formatMoney(2,'.',',');
        },
        subtotal: function () {
            var self=this;
            var total=0;
            if(this.form.items) {
                this.form.items.forEach(function (item) {
                    total+=(item.cantidad * item.precio_unitario);
                });
            }
            return parseFloat(total).formatMoney(2,'.',',');
        }

        },

    mounted: function () {
        var self = this;

        $('#id_concepto').val(self.form.comprobante.id_concepto);
        $.each( self.form.items, function( key, item ) {
            $('#I'+(key+1)).val(item.id_material);
            $('#L'+(key+1)).text(item.unidad);


        });

        $('#concepto_select').on('select2:select', function () {
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


        // JsTree Configuration
        var jstreeConf = {
            'core' : {
                'multiple': false,
                'data': {
                    "url": function(node) {
                        if(node.id === "#") {
                            return App.host + '/conceptos/' + $('#id_concepto').val() + '/jstree';
                        }
                        return App.host + '/conceptos/' + node.id + '/jstree';
                    },
                    "data": function (node) {
                        return {
                            "id" : node.id
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
                'material' : {
                    'icon': 'fa fa-briefcase'
                },
                'opened' : {
                    'icon': 'fa fa-folder-open-o text-success'
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
        });

        // On hide the BS modal, get the selected node and destroy the jstree
        $('#myModal').on('shown.bs.modal', function (e) {
            $('#jstree').jstree(jstreeConf);
        }).on('hidden.bs.modal', function (e) {
            var jstree = $('#jstree').jstree(true);
            var node = jstree.get_selected(true)[0];

            if (node) {
                self.current_item.id_concepto = node.id;
                self.current_item.destino = node.text;
            }
            jstree.destroy();
        });
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
                title: "Actualizar Comprobante de Fondo Fijo",
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
               'gastos_varios':''
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

        habilitaIva:function () {
            var self = this;
            if( self.form.cambio_iva){
                self.form.iva=0.0;
                self.form.cambio_iva=false;
            }
            else{
                self.form.cambio_iva=true;
            }


        },
        save_comprobante_fondo_fijo: function () {
            var self = this;
            var url = this.url_comprobante_fondo_fijo_update;
            var data = self.form;
            data['_method']='PATCH';

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
                        html: 'Comprobante de Fondo Fijo actualizado correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).catch(swal.noop);
                    window.location = self.url_comprobante_fondo_fijo_show;

                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }


    }
});
