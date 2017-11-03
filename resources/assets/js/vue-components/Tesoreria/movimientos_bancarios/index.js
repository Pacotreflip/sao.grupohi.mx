Vue.component('movimientos_bancarios-index', {
    props: ['url_movimientos_bancarios_index', 'cuentas', 'tipos'],
    data : function () {
        return {
            'data' : {
                'cuentas': this.cuentas,
                'tipos': this.tipos
            },
            'form' : {
                'id_tipo_movimiento' : '',
                'estatus' : '',
                'id_cuenta': '',
                'impuesto': '',
                'importe': '',
                'observaciones': ''
            },
            'traspaso_edit': {
                'id_tipo_movimiento' : '',
                'estatus' : '',
                'id_cuenta': '',
                'impuesto': '',
                'importe': '',
                'observaciones': ''
            },
            'guardando' : false
        }
    },
    computed: {
    },
    mounted: function()
    {
        var self = this;
    },
    directives: {},
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