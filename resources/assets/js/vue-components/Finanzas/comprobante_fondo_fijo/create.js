Vue.component('comprobante-fondo-fijo-create', {
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
                    'id_transaccion':''
                },
                'items':[],
                'total':'',
                'subtotal':'',
            }


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
        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'cumplimiento', $('#cumplimiento').val())
        });

        $("#fecha").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'fecha', $('#fecha').val())
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
                }).on('select2:select', function () {
                    $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
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

        save_comprobante_fondo_fijo: function (){
            var self=this;
            self.form.comprobante.id_concepto=$('#id_concepto').val();
            $.ajax({
                type: 'POST',
                url: self.url_poliza_generada_update,
                data: {
                    _method: 'PATCH',
                    poliza_generada: self.data.poliza_edit
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: 'Prepóliza  <b>' + self.data.poliza_edit.transaccion_interfaz.descripcion + '</b> actualizada correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).catch(swal.noop);
                    window.location = xhr.getResponseHeader('Location');
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        add_item: function () {
           var self=this;
           self.form.items.push({
               'id_transaccion':'',
               'id_concepto':'',
               'id_material':'',
               'cantidad':'',
               'precio_unitario':'',
               'importe':''
           });
        }


    }
});
