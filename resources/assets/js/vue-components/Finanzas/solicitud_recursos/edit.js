Vue.component('solicitud-recursos-edit', {
    template: require('./templates/edit.html'),
    props: ['id'],
    data: function () {
        return {
            transacciones : [],
            cargando: false,
            guardando:false,
            grupos: [],
            group_by: 'id_empresa',
            title: '',
            text: '',
            fecha_inicio: '',
            fecha_fin: '',
            posterior: false,
            filtro: ''
        }
    },

    watch: {
        group_by: {
            handler: function (){
                this.agrupados(this.group_by);
            },
            immediate: true
        },
        fecha_inicio: function () {
            this.agrupados(this.group_by);
        }
    },

    directives: {
        datepicker: {
            inserted: function (el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
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
                self.agrupados(self.group_by);
            });
        });
    },

    methods: {
        set_fechas: function (i, f, id) {
            var self = this;

            var element = $('#' + id);

            if (element.hasClass('active')) {
                element.removeClass('active');

                self.fecha_inicio = new Date(1);
                self.fecha_fin = new Date();
                self.fecha_fin.setDate(self.fecha_fin.getDay() + 3650);
                self.filtro = '';
            } else if (i && f) {
                self.filtro = id;

                var date2 = new Date();
                date2.setDate(date2.getDate() + (f + 1));
                self.fecha_inicio = date2;

                var date = new Date();
                date.setDate(date.getDate() + (i));
                self.fecha_fin = date;
            } else if (!i && f) {
                self.filtro = id;

                var date = new Date();
                date.setDate(date.getDate() + (f + 1));
                self.fecha_inicio = date;

                var date2 = new Date();
                date2.setDate(date2.getDay() + 3650);
                self.fecha_fin = date2;
            } else if (i && !f) {
                self.filtro = id;

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
                        where: [['saldo', '>', 0]]
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
        },

        agrupados: function (agrupador) {
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

        set_fecha_modal: function (e) {
            let self = this;
            if (self.posterior) {
                self.fecha_inicio = new Date($('#vencimiento').val());
                self.fecha_fin = new Date();
                self.fecha_fin.setDate(self.fecha_fin.getDay() + 3650);
            } else {
                self.fecha_inicio = new Date(1);
                self.fecha_fin = new Date($('#vencimiento').val());
            }
            $('#vencimiento').val('');
            self.filtro = '';
            $('#vencimientoModal').modal('hide');
        },

        toggle: function (value) {
            this.group_by = value;
            let element = $('#' + this.group_by);
            if (element.hasClass('active')) {
                element.removeClass('active');

                this.group_by = '';
                this.text = '';
                this.title = '';
            }
        },
        agregar: function (transaccion) {
            if (transaccion)
            $.ajax({
                url: App.host + '/api/finanzas/solicitud_recursos/sync_partida/',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                data: {
                    id_transaccion: transaccion.id_transaccion
                }
            })
        },
        confirm_finalizar: function () {
            let self = this;

            swal({
                title: '¿Está seguro de finalizar?',
                text: "Si finaliza la captura de esta solicitud de recursos no podrá agregar más transacciones",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Finalizar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.finalizar();
                }
            });
        },

        finalizar: function () {
            let self = this;
            $.ajax({
                url: App.host + '/api/finanzas/solicitud_recursos/' + self.id + '/finalizar',
                type: 'POST',
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function () {
                    swal({
                        title: '¡Correcto!',
                        text: 'Solicitud finalizada correctamente',
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        return window.location.href = App.host + "/finanzas/solicitud_recursos";
                    }).catch(swal.noop);
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }
    }
});
