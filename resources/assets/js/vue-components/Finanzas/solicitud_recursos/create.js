Vue.component('solicitud-recursos-create', {
    template: require('./templates/create.html'),
    data: function () {
        return {
            transacciones : [],
            cargando: false,
            guardando:false,
            grupos: [],
            group_by: '',
            title: '',
            text: ''
        }
    },


    watch: {
        group_by: function (agrupador) {
            this.grupos = _.groupBy(this.transacciones, agrupador);
            switch (agrupador) {
                case 'id_empresa':
                    this.title = 'empresa';
                    this.text = 'razon_social';
                    break;
                case 'id_rubro':
                    this.title = 'rubro';
                    this.text = 'descripcion';
                    break;
                case 'id_moneda':
                    this.title = 'moneda';
                    this.text = 'nombre';
                    break;
            }
        },
        transacciones: function (transacciones) {
            this.grupos = _.groupBy(transacciones, this.group_by);
            switch (this.group_by) {
                case 'id_empresa':
                    this.title = 'empresa';
                    this.text = 'razon_social';
                    break;
                case 'id_rubro':
                    this.title = 'rubro';
                    this.text = 'descripcion';
                    break;
                case 'id_moneda':
                    this.title = 'moneda';
                    this.text = 'nombre';
                    break;
            }
        }
    },

    computed: {
        total_solicitado: function () {
            var res = 0;
            this.transacciones.forEach(function(transaccion) {
                if(transaccion.seleccionada){
                    res += (transaccion.monto * transaccion.tipo_cambio);
                }
            });
            return res;
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
        get_transacciones: function(i, f) {
            var self = this;
            self.transacciones = [];
            var fechas = undefined;
            if (i && f) {
                fechas = [];

                var date2 = new Date();
                date2.setDate(date2.getDate() + (f + 1));
                fechas.push(date2.dateShortFormat());


                var date = new Date();
                date.setDate(date.getDate() + (i));
                fechas.push(date.dateShortFormat());


            } else if (!i && f) {
                fechas = [];

                var date = new Date();
                date.setDate(date.getDate() + (f + 1));
                fechas.push(date.dateShortFormat());

                var date = new Date();
                date.setDate(date.getDay() + 3650);
                fechas.push(date.dateShortFormat());
            } else  if (i && !f) {
                fechas = [];

                var date = new Date(1);
                fechas.push(date.dateShortFormat());

                var date = new Date();
                date.setDate(date.getDate() + (i));
                fechas.push(date.dateShortFormat());
            }

            self.getFacturas(fechas).then(function (data) {
                data.facturas.forEach(function (factura) {
                    self.transacciones.push(factura);
                });
            });

            self.getSolicitudesPago(fechas).then(function (data) {
                data.solicitudes.forEach(function (solicitud) {
                    self.transacciones.push(solicitud);
                });
            });
        },


        getFacturas: function (fechas) {
            console.log(fechas);
            var self = this;
            return new Promise(function (resolve, reject) {

                $.ajax({
                    url: App.host + '/api/sistema_contable/factura_transaccion',
                    type: 'GET',
                    data: {
                        where: [['estado', '=', 1], ['saldo', '>', 0]],
                        with: ['rubros', 'contrarecibo', 'moneda', 'empresa'],
                        betweenColumn: 'vencimiento',
                        betweenValues: fechas
                    },
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        response.forEach(function (transaccion) {
                            transaccion.rubro = transaccion.rubros[0];
                        });
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

        getSolicitudesPago: function (fechas) {
            console.log(fechas);

            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_pago',
                    type: 'GET',
                    data: {
                        with: ['rubros', 'moneda', 'empresa'],
                        where:[['saldo', '>', 0]],
                        betweenColumn: 'vencimiento',
                        betweenValues: fechas
                    },
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        response.forEach(function (transaccion) {
                            transaccion.rubro = transaccion.rubros[0];
                        });

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