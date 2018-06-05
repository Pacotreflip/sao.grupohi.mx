Vue.component('concepto-extraordinario-show', {
    props: ['solicitud'],
    data: function () {
        return{
            form: {
                solicitud: this.solicitud

            },
            rechazando:false,
            autorizando:false
        }
    }
});