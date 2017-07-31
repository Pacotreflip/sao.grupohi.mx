Vue.component('revaluacion-create', {
    props: ['facturas'],
    data : function() {
        return {
            data: {
                facturas: this.facturas
            },
            guardando : false
        }
    },
    methods: {

    }
});