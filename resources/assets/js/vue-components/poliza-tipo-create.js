Vue.component('poliza-tipo-create', {
    data: function() {
        return {
            'form' : {
                'poliza_tipo' : {
                    'id_transaccion_interfaz' : '',
                    'movimientos' : []
                },
                'movimiento' : {
                    'id_cuenta_contable' : '',
                    'id_tipo_movimiento' : ''
                },
                'errors' : []
            }
        }
    },

    directives: {
        select2: {
            inserted: function (el) {
                $(el).select2({
                    width: '100%'
                });
            }
        }
    },

    methods: {
        add_movimiento: function () {
            this.form.poliza_tipo.movimientos.push(this.form.movimiento);
        },

        reset_movimiento: function () {
            Vue.set(this.form.movimiento, 'id_cuenta_contable', '');
            Vue.set(this.form.movimiento, 'id_tipo_movimiento', '');
        }
    }
});