Vue.component('concepto-extraordinario-show', {
    props: ['solicitud', 'partidas'],
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