Vue.component('requisicion-edit', {

    props: ['url_requisicion', 'requisicion', 'materiales','departamentos_responsables', 'tipos_requisiciones'],

    data: function() {
        return {
            form : {
                requisicion: {
                    id_departamento: this.requisicion.transaccion_ext.id_departamento,
                    id_tipo_requisicion: this.requisicion.transaccion_ext.id_tipo_requisicion,
                    observaciones: this.requisicion.observaciones
                },
                item: {
                    'id_transaccion' : this.requisicion.id_transaccion,
                    'id_material': '',
                    'observaciones': '',
                    'cantidad': '',
                    'unidad': this.unidad,
                    'id_item':''
                }
            },
            data: {
                items: this.requisicion.items,
                guardando : false
            }
        }
    },
    computed: {
        materiales_list: function () {
            var result = {};
            this.materiales.forEach(function (material) {
                result[material.id_material] = material.descripcion;
            });

            return result;
        },
        materiales_unidad_list: function () {
            var result = {};
            this.materiales.forEach(function (material) {
                result[material.id_material] = material.unidad;
            });

            return result;
        },
        unidad: function () {
         this.form.item.unidad=this.materiales_unidad_list[this.form.item.id_material];
           return this.materiales_unidad_list[this.form.item.id_material];

        }
    }
    ,
    methods:{
        show_add_item: function () {

            $('#add_item_modal').removeAttr('tabindex');
            this.validation_errors.clear('form_add_item');
            $('#add_item_modal').modal('show');
            this.validation_errors.clear('form_add_item');

        },

        confirm_remove_item: function (item) {
            var self = this;
            swal({
                title: "Eliminar Partida",
                text: "¿Estás seguro de que deseas eliminar la partida?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.remove_item(item);
            }).catch(swal.noop);
        },

        remove_item:function (item) {
            var self = this;
            var url = App.host + '/item/' + item.id_item;
            var index = this.data.items.indexOf(item);

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'DELETE'
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        text: "Partida eliminada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                    Vue.delete(self.data.items, index);
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        show_edit_item: function (item) {
            this.form.item['index']= this.data.items.indexOf(item);
            this.form.item.id_material=item.id_material;
            this.form.item.observaciones=item.item_ext.observaciones;
            this.form.item.unidad=item.unidad;
            this.form.item.cantidad=item.cantidad;
            this.form.item.id_item=item.id_item;
            $('#edit_item_modal').removeAttr('tabindex');
            this.validation_errors.clear('form_edit_item');
            $('#edit_item_modal').modal('show');
            this.validation_errors.clear('form_edit_item');
        },

        close_add_item: function () {
            $('#add_item_modal').modal('hide');
            $('#edit_item_modal').modal('hide');
            this.form.item=  {
                'id_transaccion' : this.requisicion.id_transaccion,
                'id_material': '',
                'observaciones': '',
                'cantidad': '',
                'unidad': ''
            };
        },

        confirm_save: function () {
            var self = this;
            swal({
                title: "Actualizar Requisición",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },

        save: function () {
            var self = this;
            var url = this.url_requisicion;
            var data = this.form;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        text: "Requisición actualizada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            })
        },
        confirm_update_item: function () {
            var self = this;
            swal({
                title: "Actualizar Partida",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.update_item();
            }).catch(swal.noop);
        },
        confirm_save_item: function () {
            var self = this;
            swal({
                title: "Guardar Partida",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_item();
            }).catch(swal.noop);
        },
        confirm_update_requisicion: function () {
            var self = this;
            swal({
                title: "Actualizar Requisicion",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.update_requisicion();
            }).catch(swal.noop);
        },

        save_item: function () {
            var self = this;
            var url = App.host + '/item';
            var data = this.form.item;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.items.push(data.data.item);
                    $('#add_item_modal').modal('hide');
                    swal({
                        title: '¡Correcto!',
                        text: "Partida guardada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            })
        }
        ,

       update_item: function () {

           var self = this;
           var url = App.host + '/item/' + self.form.item.id_item;
           var data = this.form.item;
           data['_method']='PATCH';
           $.ajax({
               type: 'POST',
               url: url,
               data: data ,
               beforeSend: function () {
                   self.guardando = true;
               },
               success: function (data, textStatus, xhr) {
                   self.data.items[self.form.item.index]=data.data.item;
                   $('#edit_item_modal').modal('hide');
                   self.form.item=  {
                       'id_transaccion' : self.requisicion.id_transaccion,
                       'id_material': '',
                       'observaciones': '',
                       'cantidad': '',
                       'unidad': ''
                   };
                   swal({
                       title: '¡Correcto!',
                       text: "Partida actualizada correctamente.",
                       type: "success",
                       confirmButtonText: "Ok"
                   });


               },
               complete: function () {
                   self.guardando = false;
               }
           });
        },
        update_requisicion: function () {

            var self = this;
            var url = App.host + '/compras/requisicion/' + self.form.item.id_transaccion;
            var data = this.form.requisicion;
            data['_method']='patch';
            $.ajax({
                type: 'POST',
                url: url,
                data: data ,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        text: "Requisición actualizada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    }).then(function () {
                        window.location = App.host + '/compras/requisicion/' + self.form.item.id_transaccion+ '/edit';
                    })  .catch(swal.noop);
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'save') {
                    this.confirm_save();
                }else if(funcion=='save_item'){
                    this.confirm_save_item();
               }
            else if(funcion=='edit_item'){
                this.confirm_update_item();
            }
            else if(funcion=='update_requisicion'){
                this.confirm_update_requisicion();
            }

            }).catch(() => {
                swal({
                     type: 'warning',
                     title: 'Advertencia',
                     text: 'Por favor corrija los errores del formulario'
                 });
            });
        }
    }
});
