Vue.component('poliza-generada-edit', {
    props: ['poliza', 'poliza_edit', 'datos_contables', 'url_cuenta_contable_findby', 'url_poliza_generada_update','tipo_cuenta_contable'],
    data: function () {
        return {
            'data': {
                'poliza': this.poliza,
                'poliza_edit': this.poliza_edit
            },
            'form': {
                'movimiento' : {
                    'id_int_poliza' : this.poliza.id_int_poliza,
                    'cuenta_contable' : '',
                    'id_tipo_movimiento_poliza' : '',
                    'importe' : '',
                    'referencia':'',
                    'concepto':'',
                    'id_tipo_cuenta_contable':''
                },
            },
            'guardando': false
        }
    },

    computed: {
        cambio: function () {
            return JSON.stringify(this.data.poliza) !== JSON.stringify(this.data.poliza_edit);
        },

        suma_haber: function () {
            var suma_haber = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if(movimiento.id_tipo_movimiento_poliza == 2) {
                    suma_haber += parseFloat(movimiento.importe);
                }
            });
            return parseFloat(Math.round(suma_haber * 100) / 100).toFixed(2);
        },

        suma_debe: function () {
            var suma_debe = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if(movimiento.id_tipo_movimiento_poliza == 1) {
                    suma_debe += parseFloat(movimiento.importe);
                }
            });
            return (Math.round(suma_debe * 100) / 100).toFixed(2);
        }
    },

    methods: {
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
            this.form.movimiento =  {
                'id_int_poliza': this.poliza.id_int_poliza,
                'cuenta_contable': '',
                'id_tipo_movimiento_poliza': '',
                'importe': ''
            };
        },

        confirm_add_movimiento: function() {
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
                    attribute : 'cuenta_contable',
                    value : self.form.movimiento.cuenta_contable,
                    with : 'tipoCuentaContable'
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

        confirm_remove_movimiento: function(index) {
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

        save: function () {
            var self = this;

            Vue.set(this.data.poliza_edit,'suma_haber',this.suma_haber);
            Vue.set(this.data.poliza_edit,'suma_debe',this.suma_debe);


            $.ajax({
                type: 'POST',
                url: self.url_poliza_generada_update,
                data: {
                    _method : 'PATCH',
                    poliza_generada : self.data.poliza_edit
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: 'Póliza  <b>' +self.data.poliza_edit.tipo_poliza_contpaq.descripcion + '</b> actualizada correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    })  .catch(swal.noop);
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }
    }
});
