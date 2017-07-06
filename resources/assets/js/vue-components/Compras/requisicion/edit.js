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
                    'unidad': ''
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
        }
    },
    methods:{
        show_add_item: function () {
            this.validation_errors.clear('form_add_item');
            $('#add_item_modal').modal('show');
            this.validation_errors.clear('form_add_item');
        },
        show_edit_item: function (item) {
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
        save_item: function () {

        }
        ,
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'save') {
                    this.confirm_save();
                }else if(funcion=='save_item'){
                    this.confirm_save_item();
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
