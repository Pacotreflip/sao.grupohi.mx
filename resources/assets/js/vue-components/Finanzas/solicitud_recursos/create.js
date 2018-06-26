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
            text: '',
            fecha_inicio: '',
            fecha_fin: ''
        }
    },

    watch: {
        group_by: function (agrupador) {
            this.grupos = _.groupBy(this.transacciones_filtradas, agrupador);
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
        fecha_inicio: function () {
            this.grupos = _.groupBy(this.transacciones_filtradas, this.group_by);
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
        },

        transacciones_filtradas: function () {
            var self = this;
            return self.transacciones.filter(function (value) {
                if(self.fecha_inicio != '' || self.fecha_fin != '') {
                    return (new Date(value.vencimiento) >= self.fecha_inicio && new Date(value.vencimiento) <= self.fecha_fin)
                }
                return true;
            });
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
        set_fechas: function(i, f) {
            var self = this;
            if (i && f) {
                var date2 = new Date();
                date2.setDate(date2.getDate() + (f + 1));
                self.fecha_inicio = date2;

                var date = new Date();
                date.setDate(date.getDate() + (i));
                self.fecha_fin = date;
            } else if (!i && f) {
                var date = new Date();
                date.setDate(date.getDate() + (f + 1));
                self.fecha_inicio = date;

                var date2 = new Date();
                date2.setDate(date2.getDay() + 3650);
                self.fecha_fin = date2;
            } else  if (i && !f) {
                var date = new Date(1);
                self.fecha_inicio = date;

                var date2 = new Date();
                date2.setDate(date2.getDate() + (i));
                self.fecha_fin = date2;
            }
        },

        getFacturas: function () {
            var self = this;
            return new Promise(function (resolve, reject) {

                $.ajax({
                    url: App.host + '/api/sistema_contable/factura_transaccion',
                    type: 'GET',
                    data: {
                        where: [['estado', '=', 1], ['saldo', '>', 0]],
                        with: ['rubros', 'contrarecibo', 'moneda', 'empresa']
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

        getSolicitudesPago: function () {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_pago',
                    type: 'GET',
                    data: {
                        with: ['rubros', 'moneda', 'empresa'],
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