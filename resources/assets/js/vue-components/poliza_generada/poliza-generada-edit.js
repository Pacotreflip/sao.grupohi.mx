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
        }
    },

    methods: {
        show_add_movimiento: function () {
            this.form.movimiento =  {
                'id_int_poliza': this.poliza.id_int_poliza,
                'cuenta_contable': '',
                'id_tipo_movimiento_poliza': '',
                'importe': ''
            };

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
        }
    }
});
