Vue.component('cuenta-contable-create', {
    props: ['cuentas_tipo','obra_cuenta'],
    data: function() {
        return {
            guardando : false
        }
    },

    methods: {
        confirm_datos_obra: function (e) {
            e.preventDefault();
            console.log($('#form_datos_obra').serialize());
        }
    }
});