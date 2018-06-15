Vue.component('solicitud-pago-index', {
    data: function () {
        return {
            solicitudes: [],
            cargando: false
        }
    },

    mounted: function () {
        this.getSolicitudes().then(function (data) {
            this.solicitudes = data;
            this.cargando = false;
        });
    },

    methods: {
        getSolicitudes: function () {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_pago',
                    type: 'GET',
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        resolve(response);
                    }
                })
            });
        }
    }
});