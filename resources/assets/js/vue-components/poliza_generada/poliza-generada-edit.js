Vue.component('poliza-generada-edit', {
    props: ['poliza', 'poliza_edit', 'obra', 'url_cuenta_contable_findby'],
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
                    'concepto':''
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
           return suma_haber;
        },

        suma_debe: function () {
            var suma_debe = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if(movimiento.id_tipo_movimiento_poliza == 1) {
                    suma_debe += parseFloat(movimiento.importe);
                }
            });
            return suma_debe;
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
        }
    }
});
