Vue.component('poliza-generada-edit', {
    props: ['poliza'],
    data: function () {
        return {
            data: {
                'poliza': this.poliza
            },
            'form': {},
            'guardando': false
        }
    }

});
