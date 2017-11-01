Vue.component('traspaso-cuentas-index', {
    props: ['url_traspaso_cuentas_index', 'cuentas', 'traspasos', 'monedas'],
    data : function () {
        return {
            'data' : {},
            'form' : {},
            'traspaso_edit': {},
            'guardando' : false
        }
    },
    computed: {
        cuentas_disponibles: function () {
            var self = this;
            return this.cuentas.filter(function (cuenta) {
                return cuenta.id_cuenta != self.form.id_cuenta_origen;
            });
        }
    },
    mounted: function()
    {
        var self = this;
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
    },
    methods: {
        datos_cuenta: function (id) {
            return this.cuentas[id];
        },
        confirm_guardar: function() {
            var self = this;
        },
        guardar: function () {
            var self = this;
        },
        validateForm: function(scope, funcion) {
        },
    }
});