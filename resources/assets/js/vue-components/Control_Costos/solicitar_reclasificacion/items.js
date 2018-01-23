Vue.component('solicitar_reclasificacion-items', {
    props: ['url_solicitar_reclasificacion_index', 'id_transaccion', 'id_concepto_antiguo', 'items', 'max_niveles', 'filtros', 'operadores', 'solicitar_reclasificacion', 'consultar_reclasificacion', 'autorizar_reclasificacion'],
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
                'fecha': moment().format('YYYY-MM-DD'),
                'solicitud': {},
                'show_pdf': false,
                'editando': false,
                'rechazando': false,
                'rechazo_motivo': ''
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

        $(document).on('click', '.mostrar_solicitud', function () {
            var _this = $(this);

            $.ajax({
                type: 'GET',
                url : App.host + '/control_costos/solicitar_reclasificacion/single/'+ _this.data('id'),
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    if (data.solicitud)
                    {
                        Vue.set(self.data, 'solicitud', data.solicitud);
                        $('#solicitud_detalles_modal').modal('show');
                    }

                    else
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'No existe la solicitud'
                        });
                },
                complete: function () {
                }
            });
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

            self.data.agrega = {
                'nivel': '',
                'operador': '',
                'texto': ''
            };
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
            }).then(function (result) {
                if(result.value) {
                    if (tipo == "resultado") {
                        self.eliminar_resultado(index);
                    }
                    else if (tipo == "filtro") {
                        self.eliminar_filtro(index);
                    }
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
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if(result.value) {
                    self.solicitar();
                }
            }).catch(swal.noop);
        },
        solicitar: function () {
            var self = this,
                temp_fecha = self.data.fecha;

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

                    var repetidas = [],
                        lista = [];

                    // Ya existe al menos una partida registrada
                    if (typeof data.repetidas == 'object')
                    {
                        $.each(data.repetidas, function( key, value ) {
                            repetidas.push(value.id);
                            lista.push('<li class="list-group-item "><a href="#" onclick="swal.close();" class="mostrar_solicitud" data-id="'+ value.id +'">#'+ value.id +' ' + (value.motivo.length >= 20 ? (value.motivo.substring(0, 30) + '...') : value.motivo) + '</a></li>');
                        });

                        var texto = data.repetidas.length > 1 ? 'Ya existen solicitudes pendientes de autorización' : 'Ya existe una solicitud pendiente de autorización';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') +'</ul>',
                            type: "warning",
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });

                        return;
                    }

                    else
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

                    if (data.status == 400)
                    {
                        $('#Fecha').datepicker('update', data.getResponseHeader('next-date'));
                        Vue.set(self.data, 'fecha', data.getResponseHeader('next-date'));
                    }

                    else
                    {
                        $('#Fecha').datepicker('update', temp_fecha);
                        Vue.set(self.data, 'fecha', temp_fecha);
                    }
                }
            });
        },
        ver_lista: function (items) {
            window.location.href = App.host + '/control_costos/solicitudes_reclasificacion?repetidas='+ JSON.stringify(items);
        },
        pdf: function (id) {
            var self = this,
                url = App.host + '/control_costos/solicitudes_reclasificacion/generarpdf?item='+ id;

            self.data.show_pdf = url;
        },
        html_decode: function(input){
            var e = document.createElement('div');
            e.innerHTML = input;

            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        },
        close_modal_detalles: function () {
            var self = this;

            $('#solicitud_detalles_modal').modal('hide');

            // reset partidas
            self.data.editando = false;
            self.data.rechazando = false;
            self.data.rechazo_motivo = '';
            self.data.show_pdf = false;
        },
        allow_editar: function () {
            var self = this;

            self.data.editando = self.data.solicitud;
        },
        confirm: function(tipo) {
            var self = this;

            // Manda error si no hay una solicitud para aprobar/rechazar
            if (self.data.editando.length > 0)
                return  swal({
                    type: 'warning',
                    title: 'Error',
                    text: 'La solicitud está vacía'
                });

            // Al rechazar debe de haber un motivo
            if (tipo == 'rechazar' && self.data.rechazo_motivo == '')
                return  swal({
                    type: 'warning',
                    title: 'Error',
                    text: 'Debes de especificar un motivo para rechazar'
                });

            swal({
                title: tipo.mayusculaPrimerLetra(),
                text: "¿Estás seguro/a de que deseas "+ tipo +" esta solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if(result.value) {
                    if (tipo == "aprobar") {
                        self.aprobar();
                    }
                    else if (tipo == "rechazar") {
                        self.rechazar();
                    }
                }
            }).catch(swal.noop);
        },
        aprobar: function () {
            var self = this,
                str = {'data':JSON.stringify(self.data.editando), 'tipo': 'aprobar'};

            $.ajax({
                type: 'POST',
                url : App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    if (data.resultado)
                        swal({
                            type: 'success',
                            title: '',
                            html: 'La solicitud fué autorizada'
                        });

                    else
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'La operación no pudo concretarse'
                        });

                    self.close_modal_detalles();
                },
                complete: function () {
                }
            });
        },
        rechazar: function () {
            var self = this,
                str = {'data':JSON.stringify(self.data.editando), 'tipo': 'rechazar', 'motivo': self.data.rechazo_motivo};

            $.ajax({
                type: 'POST',
                url : App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    if (data.resultado)
                        swal({
                            type: 'success',
                            title: '',
                            html: 'La solicitud fué rechazada'
                        });

                    else
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'La operación no pudo concretarse'
                        });

                    self.close_modal_detalles();
                },
                complete: function () {
                }
            });
        },
        rechazar_motivo: function () {

            var self = this;

            self.data.rechazando = true;
        },
        cancelar_rechazo: function () {
            var self = this;

            self.data.rechazando = false;
            self.data.rechazo_motivo = '';
        }
    }
});
