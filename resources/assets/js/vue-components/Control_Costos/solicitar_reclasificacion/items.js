Vue.component('solicitar_reclasificacion-items', {
    props: ['url_solicitar_reclasificacion_index', 'id_transaccion', 'id_concepto_antiguo', 'items', 'max_niveles', 'filtros', 'operadores'],
    data : function () {
        return {
            'data' : {
                'items': this.items,
                'filtros': this.filtros,
                'operadores': this.operadores,
                'agrega': {
                    'nivel': '',
                    'operador': '',
                    'texto': ''
                },
                'resultados': [],
                'subtotal': 0,
                'subimporte': 0,
                'total_resultados': 0,
                'temp_index' : false,
                'id_concepto_antiguo' : false,
                'solicitudes' : [],
                'motivo': '',
                'fecha': moment().format('YYYY-MM-DD')
            }
        }
    },
    computed: {
        niveles : function () {
            var self = this,
                niveles = [],
                paso = 1;

            for (paso; paso <= self.max_niveles; paso++) {
                niveles.push({numero:paso, nombre:"Nivel "+ paso});
            }

            return niveles;
        },
        niveles_n : function () {
            var result = 0;
            this.data.resultados.forEach(function (t) {
                var cont = (Object.keys(t)).filter(function (t2) {
                    return t[t2] != null;
                });
                if (cont.length -2 > result) {
                    result = cont.length -2;
                }
            });

            return result;
        }
    },
    mounted: function () {
        var self = this;

        $("#Fecha").datepicker().on("changeDate",function () {
            var thisElement = $(this);

            Vue.set(self.data, 'fecha', thisElement.val());

        });
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
    methods: {
        agregar_filtro: function () {
            var self = this,
                vacios = [],
                temp = [];

            // Los campos  no puedene star vacios
            $.each(self.data.agrega, function(index, value) {
                if (value === "")
                {
                    vacios.push(index);
                }
            });

            // Manda error si están vacios
            if (vacios.length > 0)
                return swal({
                    type: 'warning',
                    title: 'Los siguientes campos no pueden estar vacios:',
                    html: '<ul class="list-group"><li class="list-group-item list-group-item-danger">' + vacios.join("<li class=\"list-group-item list-group-item-danger\">") + '</ul>'
                });

            self.data.filtros.push(self.data.agrega);
        },
        buscar: function () {
            var self = this,
                str = {'data':JSON.stringify(self.data.filtros)},
                total_resultados = 0;

            Vue.set(self.data, 'total_resultados', 0);

            if (self.data.filtros.length == 0)
            {
                return swal({
                    type: 'warning',
                    title: 'Agrega un filtro',
                    html: 'Por favor agrega un filtro antes de buscar'
                });
            }

            $.ajax({
                type: 'GET',
                url : self.url_solicitar_reclasificacion_index +'/find',
                data: str,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    if (data.data.resultados.length > 0)
                    {
                        $.each(data.data.resultados, function( key, value ) {
                            total_resultados = total_resultados + parseInt(value.total);
                        });

                        Vue.set(self.data, 'total_resultados', parseInt(total_resultados).formatMoney(2, '.', ','));
                        Vue.set(self.data, 'resultados', data.data.resultados);
                        swal({
                            type: 'success',
                            title: '',
                            html: 'Se encontraron resultados'
                        });
                    }

                    else
                    {
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'No se encontraron resultados'
                        });
                    }

                },
                complete: function () {

                }
            });

        },
        confirm_eliminar: function(index, tipo) {
            var self = this;
            swal({
                title: "Eliminar "+ tipo,
                text: "¿Estás seguro/a de que deseas eliminar este "+ tipo +"?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                if (tipo == "resultado") {
                    self.eliminar_resultado(index);
                }
                else if (tipo == "filtro") {
                    self.eliminar_filtro(index);
                }
            }).catch(swal.noop);
        },
        eliminar_resultado: function (index) {
            var self = this;

            self.data.resultados.splice(index, 1);
        },
        eliminar_filtro: function (index) {
            var self = this;

            self.data.filtros.splice(index, 1);

            if (self.data.filtros.length == 0){
                self.reset_agregar();
            }
        },
        reset_agregar: function () {
            var self = this;

            Vue.set(self.data, 'agrega', {
                'nivel': '',
                'operador': '',
                'texto': ''
            });

            self.active_item();
            Vue.set(self.data, 'resultados', []);
            Vue.set(self.data, 'filtros', []);
            Vue.set(self.data, 'total_resultados', 0);
            Vue.set(self.data, 'id_concepto_antiguo', false);
        },
        active_item: function () {
            var self = this;
        },
        open_modal_agregar: function (item, index) {
            var self = this;

            Vue.set(self.data, 'temp_index', index);
            Vue.set(self.data, 'id_concepto_antiguo', item.id_concepto);

            $('#agregar_filtro_modal').modal('show');
            $('#nivel').focus();

            self.active_item();
        },
        close_modal_agregar: function () {
            var self = this;

            $('#agregar_filtro_modal').modal('hide');

            self.reset_agregar();
        },
        aplicar: function (item) {
            var self = this;

            Vue.set(self.data.items[self.data.temp_index], 'destino_final', item['filtro'+ self.niveles_n]);
            Vue.set(self.data.items[self.data.temp_index], 'id_concepto_nuevo', item['id_concepto']);

            self.data.solicitudes.push(self.data.items[self.data.temp_index]);

            this.close_modal_agregar();
        },
        confirm_solicitar: function() {
            var self = this;

            // Se debe de haber seleccionado un nuevo concepto
            if (self.data.solicitudes.length == 0)
                return swal({
                    type: 'warning',
                    title: 'Agrega un nuevo concepto',
                    html: 'Por favor agrega un nuevo concepto antes de solicitar'
                });

            if (self.data.motivo == '')
                return swal({
                    type: 'warning',
                    title: 'Especifica un motivo',
                    html: 'Por favor especifica un motivo antes de solicitar'
                });

            swal({
                title: "Aplicar conceptos",
                text: "¿Estás seguro/a de que deseas aplicar estos conceptos?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.solicitar();
            }).catch(swal.noop);
        },
        solicitar: function () {
            var self = this;

            $.ajax({
                type: 'POST',
                url : self.url_solicitar_reclasificacion_index,
                data: {
                    'motivo' : self.data.motivo,
                    'solicitudes': self.data.solicitudes,
                    'fecha' : self.data.fecha
                },
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: '',
                        html: 'Solicitud elaborada con éxito',
                        onClose: function () {
                            window.location.href = App.host + '/control_costos/solicitudes_reclasificacion';
                        }
                    });
                },
                complete: function (data) {
                    if (typeof data.getResponseHeader('next-date') != null)
                        $('#Fecha').datepicker('update', data.getResponseHeader('next-date'));
                }
            });
        }
    }
});
