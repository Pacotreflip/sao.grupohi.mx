Vue.component('poliza-generada-edit', {
    props: ['poliza', 'poliza_edit', 'datos_contables', 'url_cuenta_contable_findby', 'url_poliza_generada_update', 'tipo_cuenta_contable', 'cuentas_contables'],
    data: function () {
        return {
            'data': {
                'poliza': this.poliza,
                'poliza_edit': this.poliza_edit,
                'cuentas_contables': this.cuentas_contables,
                'movimientos': '',
                'empresa': ''
            },
            'form': {
                'movimiento': {
                    'id_int_poliza': this.poliza.id_int_poliza,
                    'cuenta_contable': '',
                    'id_tipo_movimiento_poliza': '',
                    'importe': '',
                    'referencia': '',
                    'concepto': '',
                    'id_tipo_cuenta_contable': ''
                },
                'movimiento_cuenta': {
                    'id_int_poliza_movimiento': '',
                    'cuenta': ''
                }
            },
            'guardando': false
        }
    },

    computed: {
        color:function () {
         if(this.data.poliza.cuadrado){
             return "bg-gray"
         }
         else{
             return "bg-red";
         }
        }
        ,
        cambio: function () {
            return JSON.stringify(this.data.poliza) !== JSON.stringify(this.data.poliza_edit);
        },

        suma_haber: function () {
            var suma_haber = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if (movimiento.id_tipo_movimiento_poliza == 2) {
                    suma_haber += parseFloat(movimiento.importe);
                }
            });
            return parseFloat(Math.round(suma_haber * 100) / 100).toFixed(2);
        },

        suma_debe: function () {
            var suma_debe = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if (movimiento.id_tipo_movimiento_poliza == 1) {
                    suma_debe += parseFloat(movimiento.importe);
                }
            });
            return (Math.round(suma_debe * 100) / 100).toFixed(2);
        }
    },

    methods: {

        obtener_numero_cuenta: function (idTipoCuenta) {
            var self = this;
            this.data.cuentas_contables.forEach(function (cuenta) {
                if (cuenta.id_int_tipo_cuenta_contable == idTipoCuenta) {
                    self.form.movimiento.cuenta_contable = cuenta.cuenta_contable;
                }
            });
            if (self.form.movimiento.cuenta_contable == 'NULL') {
                self.form.movimiento.cuenta_contable = '';
            }
        },

        show_add_movimiento: function () {
            this.validation_errors.clear('form_add_movimiento');
            $('#add_movimiento_modal').modal('show');
            this.validation_errors.clear('form_add_movimiento');
        },

       validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'confirm_add_movimiento') {
                this.confirm_add_movimiento();
            } else  if (funcion == 'confirm_save') {
                this.confirm_save();
            }
           else  if (funcion == 'confirm_save_cuenta') {
               this.confirm_save_cuenta();
           }

       }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },

        close_add_movimiento: function () {
            $('#add_movimiento_modal').modal('hide');
            this.form.movimiento = {
                'id_int_poliza': this.poliza.id_int_poliza,
                'cuenta_contable': '',
                'id_tipo_movimiento_poliza': '',
                'importe': ''
            };
        },

        confirm_add_movimiento: function () {
            var self = this;
            swal({
                title: "Agregar Movimiento",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.add_movimiento();
            }).catch(swal.noop);
        },

        add_movimiento: function () {
            var self = this;
            var url = this.url_cuenta_contable_findby;
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    attribute: 'cuenta_contable',
                    value: self.form.movimiento.cuenta_contable,
                    with: 'tipoCuentaContable'
                },
                success: function (data, textStatus, xhr) {
                    if (data.data.cuenta_contable) {
                        self.form.movimiento.id_tipo_cuenta_contable = data.data.cuenta_contable.id_int_tipo_cuenta_contable;
                        self.form.movimiento.id_cuenta_contable = data.data.cuenta_contable.id_int_cuenta_contable;
                        self.form.movimiento.descripcion_cuenta_contable = data.data.cuenta_contable.tipo_cuenta_contable.descripcion;

                    }
                },
                complete: function () {
                    self.data.poliza_edit.poliza_movimientos.push(self.form.movimiento);
                    self.close_add_movimiento();
                }
            });
        },

        confirm_remove_movimiento: function (index) {
            var self = this;
            swal({
                title: "Quitar Movimiento",
                text: "¿Estás seguro de que deseas quitar el movimiento de la Póliza?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.remove_movimiento(index);
            }).catch(swal.noop);
        },

        remove_movimiento: function (index) {
            Vue.delete(this.data.poliza_edit.poliza_movimientos, index);
        },

        confirm_save: function () {
            var self = this;
            swal({
                title: "Guardar Cambios de la Póliza",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },
        confirm_save_cuenta: function () {
            var self = this;
            swal({
                title: "Guardar Cambios de las cuentas faltantes",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_cuenta();
            }).catch(swal.noop);
        },

        save: function () {
            var self = this;

            Vue.set(this.data.poliza_edit, 'suma_haber', this.suma_haber);
            Vue.set(this.data.poliza_edit, 'suma_debe', this.suma_debe);


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
                        html: 'Póliza  <b>' + self.data.poliza_edit.transaccion_interfaz.descripcion + '</b> actualizada correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    }).catch(swal.noop);
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        ingresarCuenta: function (idPoliza) {
            var self = this;
            $.ajax({
                type: 'GET',
                url: App.host + "/sistema_contable/poliza_movimientos/" + idPoliza,
                data: {
                    id_poliza: idPoliza
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.movimientos = data.data.movimientos;

                    if (self.data.movimientos.length > 0) {
                        self.data.empresa = self.data.movimientos[0].empresa_cadeco;
                        $('#add_cuenta_modal').modal('show');
                    }
                    else{
                        swal('Las cuentas están completas.');
                    }

                },
                complete: function () {
                    self.guardando = false;
                }
            });


        },
        save_cuenta: function () {
            var self = this;
            $.ajax({
                type: 'POST',
                url: App.host + "/sistema_contable/poliza_movimientos/"+self.data.poliza.id_int_poliza,
                data: {
                    _method: 'PATCH',
                    data:self.data.movimientos,
                    validar:true
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                   if(data.data.cambio){
                        var datos="";
                       for (var i = 0; i <data.data.cambio.length; i++) {
                           data.data.cambio[i];
                           datos+="<tr><td>"+data.data.cambio[i].tipo_cuenta_empresa.descripcion+"</td>";
                           datos+="<td>"+data.data.cambio[i].cuenta+"</td>";
                           datos+="<td>"+data.data.cambio[i].nuevo+"</td></tr>";
                       }
                       swal({
                               title: "Advertencia",
                               html: "El numero de cuenta que trata de ingresar no corresponde al actual" +
                               "<table class='table table-striped small'>" +
                               "   <thead>" +
                               "   <tr>" +
                               "       <th style='text-align: center'>Tipo de Cuenta Contable</th>" +
                               "       <th style='text-align: center'>Actual</th>" +
                               "       <th style='text-align: center'>Nuevo</th>" +
                               "   </tr>" +
                               "   </thead>" +
                               "   <tbody>" +datos
                               +"   </tbody>" +
                               "</table>" +
                               "<b>¿Deseas reemplazar la cuenta contable?</b><br>",
                               type: "warning",
                               showCancelButton: true,
                               cancelButtonText: 'No, Cancelar',
                               confirmButtonText: 'Si, Continuar',
                           }
                       ).then(function (){

                           $.ajax({
                               type: 'POST',
                               url: App.host + "/sistema_contable/poliza_movimientos/"+self.data.poliza.id_int_poliza,
                               data: {
                                   _method: 'PATCH',
                                   data:self.data.movimientos,
                                   validar:false
                               },
                               beforeSend: function () {
                                   self.guardando = true;
                               },
                               success: function (data, textStatus, xhr) {
                                self.data.poliza=data.data.poliza;
                                   swal({
                                       title: '¡Correcto!',
                                       html: 'Las cuentas se configurarón exitosamente',
                                       type: 'success',
                                       confirmButtonText: "Ok",
                                       closeOnConfirm: false
                                   }).then(function () {
                                   }).catch(swal.noop);
                                   window.location.reload(true);
                                   $('#add_cuenta_modal').modal('hide');
                                   },
                               complete: function () {
                                   self.guardando = false;
                               }
                           });

                       }).catch(swal.noop);

                   }else{

                       swal({
                           title: '¡Correcto!',
                           html: 'Las cuentas se configurarón exitosamente',
                           type: 'success',
                           confirmButtonText: "Ok",
                           closeOnConfirm: false
                       }).then(function () {
                       }).catch(swal.noop);
                       $('#add_cuenta_modal').modal('hide');
                       window.location.reload(true);
                   }

                },
                complete: function () {
                    self.guardando = false;
                }
            });


        },

        close_cuenta_modal: function () {
            $('#add_cuenta_modal').modal('hide');
        }
    }
});
