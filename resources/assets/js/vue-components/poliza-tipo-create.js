Vue.component('poliza-tipo-create', {
    props: ['cuentas_contables', 'tipos_movimiento'],
    data: function() {
        return {
            'form' : {
                'poliza_tipo' : {
                    'id_transaccion_interfaz' : '',
                    'movimientos' : []
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
                    width: '100%',
                    placeholder: "--SELECCIONE--"
                });
            }
        }
    },

    methods: {
        add_movimiento: function () {
            var id_cuenta_contable = $('#id_cuenta_contable').val();
            var id_tipo_movimiento = $('#id_tipo_movimiento').val();

            this.form.poliza_tipo.movimientos.push({
                id_cuenta_contable: id_cuenta_contable,
                id_tipo_movimiento: id_tipo_movimiento
            });
        },

        reset_movimiento: function () {
            $('#id_cuenta_contable').val();
            $('#id_tipo_movimiento').val();
        },

        save: function () {
            var self = this;
            var url = App.host + '/modulo_contable/poliza_tipo';
            var data = self.form.poliza_tipo;

            console.log(data);

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (response) {
                    if (response.success) {
                        window.location = response.url;
                    } else {
                        swal({
                            type: 'error',
                            title: '¡Error!',
                            text: 'Ocurrio un error'
                        });
                    }
                },
                error: function () {

                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        remove_movimiento:function (e) {
            Vue.delete(this.form.poliza_tipo.movimientos,e);
        }
    }
});