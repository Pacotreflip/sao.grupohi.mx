Vue.component('poliza-tipo-create', {
    props: ['cuentas_contables'],
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
            },
            'guardando' : false
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
            var id_cuenta_contable = $('#id_cuenta_contable').val();
            var id_tipo_movimiento = $('#id_tipo_movimiento').val();

            Vue.set(this.form.movimiento, 'id_cuenta_contable', id_cuenta_contable);
            Vue.set(this.form.movimiento, 'id_tipo_movimiento', id_tipo_movimiento);

            this.form.poliza_tipo.movimientos.push(this.form.movimiento);
        },

        reset_movimiento: function () {
            Vue.set(this.form.movimiento, 'id_cuenta_contable', '');
            Vue.set(this.form.movimiento, 'id_tipo_movimiento', '');
        },

        save: function () {
            var self = this;
            var url = App.host + '/modulo_contable/poliza_tipo';
            $.ajax({
                type: 'POST',
                url: url,
                data: self.form.poliza_tipo,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function () {

                },
                error: function () {

                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        get_cuenta_contable_by_id: function (id) {
            var url = App.host + '/modulo_contable/cuenta_contable/' + id;
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    return response;
                }
            });
        }

    }
});