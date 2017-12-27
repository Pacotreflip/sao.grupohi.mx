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
                'temp_index' : false
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
                if (cont.length -4 > result) {
                    result = cont.length -4;
                }
            });

            return result;
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
            {
                return  swal({
                    type: 'warning',
                    title: 'Los siguientes campos no pueden estar vacios:',
                    html: '<ul class="list-group"><li class="list-group-item list-group-item-danger">' + vacios.join("<li class=\"list-group-item list-group-item-danger\">") +'</ul>'
                });
            }

            self.filtros.push(self.data.agrega);

            $('#agregar_filtro_modal').modal('hide');
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
            Vue.set(self.data, 'temp_index', false);
        },
        active_item: function () {
            var self = this;

            $('.items').each(function() {
                var _this = $(this);

                _this.removeClass('bg-navy disabled');

                if (self.data.temp_index !== false && _this.hasClass('item_'+ self.data.temp_index)){
                    $('.item_'+ self.data.temp_index).removeClass('items item_'+ self.data.temp_index).addClass('bg-navy disabled items item_'+ self.data.temp_index);
                }

            });
        },
        open_modal_agregar: function (item, index) {
            var self = this;

            Vue.set(self.data, 'temp_index', index);

            $('#agregar_filtro_modal').modal('show');
            $('#nivel').focus();

            self.active_item();
        },
        close_modal_agregar: function () {
            var self = this;

            $('#agregar_filtro_modal').modal('hide');

            Vue.set(self.data, 'temp_index', false);
            self.reset_agregar();
        },
        confirm_solicitar: function(item) {
            var self = this,
                tipo = item['filtro'+ self.max_niveles];

            swal({
                title: "Aplicar "+ tipo,
                text: "¿Estás seguro/a de que deseas aplicar el concepto "+ tipo +"?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.solicitar(item.id_concepto);
            }).catch(swal.noop);
        },
        solicitar: function (id_concepto) {
            var self = this;
            $.ajax({
                type: 'GET',
                url : self.url_solicitar_reclasificacion_index +'/store',
                data: {
                    'id_concepto_nuevo' : id_concepto,
                    'id_concepto_antiguo': self.id_concepto_antiguo
                },
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
        }
    },
    directives: {}
});
