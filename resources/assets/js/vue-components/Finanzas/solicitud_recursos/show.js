Vue.component('solicitud-recursos-show', {

    template: require('./templates/show.html'),

    props: ['id','permission_consultar_pdf_solicitud_recursos'],

    data: function () {
        return {
            solicitud: {},
            cargando: false,
            perm_consultar_pdf_solicitud_recursos: this.permission_consultar_pdf_solicitud_recursos
        }
    },

    mounted: function () {
        let self = this;
        self.get_solicitud().then(function (data) {
            self.solicitud = data.solicitud;
        })
    },

    computed: {
        total: function () {
            let res = 0;
            this.solicitud.partidas.forEach(function (val) {
                res += (val.transaccion.monto * val.transaccion.tipo_cambio);
            });
            return res;
        }
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
                        with: ['partidas.transaccion', 'tipo', 'usuario']
                    },
                    success: function (response) {
                        self.cargando = false;
                        resolve({
                            solicitud: response
                        });
                    }
                });
            })
        }
    }
});