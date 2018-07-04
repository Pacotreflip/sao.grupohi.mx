Vue.component('solicitud-recursos-show', {

    template: require('./templates/show.html'),

    props: ['id'],

    data: function () {
        return {
            solicitud: {},
            cargando: false
        }
    },

    mounted: function () {
        let self = this;
        self.get_solicitud().then(function (data) {
            self.solicitud = data.solicitud;
        })
    },

    methods: {
        get_solicitud: function () {
            let self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_recursos/' + self.id,
                    type: 'GET',
                    beforeSend: function() {
                        self.cargando = true;
                    },
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    data: {
                        with: 'partidas'
                    },
                    success: function (response) {
                        self.cargando = false;
                        resolve({
                            solicitud: response
                        });
                    }
                })
            })
        }
    }
});