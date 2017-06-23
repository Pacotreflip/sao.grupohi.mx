Vue.component('poliza-generada-edit', {
    props: ['poliza', 'poliza_edit'],
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
                    'importe' : ''
                }
            },
            'guardando': false
        }
    },

    computed: {
        cambio: function () {
            return JSON.stringify(this.data.poliza) !== JSON.stringify(this.data.poliza_edit);
        },

        sumas: function () {
            var suma_haber = 0;
            var suma_debe = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if(movimiento.id_tipo_movimiento_poliza == 1) {
                    suma_debe += parseFloat(movimiento.importe);
                } else if (movimiento.id_tipo_movimiento_poliza == 2) {
                    suma_haber += parseFloat(movimiento.importe);
                }
            });
            Vue.set(this.data.poliza_edit, 'suma_debe', suma_debe);
            Vue.set(this.data.poliza_edit, 'suma_haber', suma_haber);
        }
    },

    methods: {
        show_add_movimiento: function () {
            $('#add_movimiento_modal').modal('show');
            this.$validator.clean();
        },

        validateForm: function() {
            this.$validator.validateAll().then(() => {
                this.add_movimiento();
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

        update_sumas: function () {

        }
    }
});
