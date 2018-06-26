Vue.component('solicitud-recursos-create', {
    template: require('./templates/create.html'),
    data: function () {
        return {
            transacciones : [],
            cargando: false,
            guardando:false
        }
    },

    mounted: function () {
        var self = this;

        self.getFacturas().then(function (data) {
            data.facturas.forEach(function (factura) {
                self.transacciones.push(factura);

            });
        });

        self.getSolicitudesPago().then(function (data) {
            data.solicitudes.forEach(function (solicitud) {
                self.transacciones.push(solicitud);
            });
        });
    },

    methods: {
        getFacturas: function () {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/sistema_contable/factura_transaccion',
                    type: 'GET',
                    data: {
                        where: [['estado', '=', 1], ['saldo', '>', 0]],
                        with: ['rubros', 'contrarecibo', 'moneda']
                    },
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        self.cargando = false;
                        resolve({
                            facturas: response
                        })
                    },
                    complete: function () {
                        self.cargando = false;
                    }
                });
            })
        },

        getSolicitudesPago: function () {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_pago',
                    type: 'GET',
                    data: {
                        with: ['rubros', 'moneda'],
                        where:[['saldo', '>', 0]]

                    },
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        self.cargando = false;
                        resolve({
                            solicitudes: response
                        });
                    },
                    complete: function () {
                        self.cargando = false;
                    }
                })
            })
        }
    }
});