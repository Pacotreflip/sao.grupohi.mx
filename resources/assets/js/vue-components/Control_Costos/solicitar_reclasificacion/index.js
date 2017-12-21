Vue.component('solicitar_reclasificacion-index', {
    props: ['url_solicitar_reclasificacion_index', 'max_niveles', 'filtros', 'operadores'],
    data : function () {
        return {
            'data' : {
                'condicionante': '',
                'temp_filtro': '',
                'filtros': this.filtros,
                'operadores': this.operadores,
                'agrega': {
                    'nivel': '',
                    'operador': '',
                    'texto': ''
                },
                'resultados': [],
                'niveles': []
            }
        }
    },
    computed: {},
    methods: {
        getMaxNiveles: function () {
            var self = this,
                niveles = [],
                paso = 1;

            for (paso; paso <= self.max_niveles; paso++) {
                niveles.push({numero:paso, nombre:"Nivel "+ paso});
            }

            return niveles;
        },
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

            if (self.data.condicionante.length > 0)
            {
                temp = self.data.temp_filtro;
                self.data.temp_filtro.condicionante = self.data.condicionante;
                Vue.set(self.data.filtros, self.data.filtros.indexOf(temp), self.data.temp_filtro);
            }

            self.filtros.push(self.data.agrega);

            self.close_modal_agregar();
        },
        eliminar_filtro: function (index) {
            var self = this,
                anterior_index = index - 1,
                anterior = self.data.filtros[anterior_index];

            if  (anterior_index >= 0 && anterior.condicionante != null)
            {
                var anterior = self.data.filtros[anterior_index];

                delete anterior.condicionante;

                Vue.set(self.data.filtros, anterior_index, anterior);
            }

            self.data.filtros.splice(index, 1);
        },
        reset_agregar: function () {
            var self = this;

            Vue.set(self.data, 'agrega', {
                'nivel': '',
                'operador': '',
                'texto': ''
            });

            Vue.set(self.data, 'temp_filtro', '');
            Vue.set(self.data, 'condicionante', '');
        },
        open_modal_agregar: function (condicionante, item) {
            var self = this;

            if (condicionante)
            {
                self.data.condicionante = condicionante;
                self.data.temp_filtro = item;
            }

            $('#agregar_filtro_modal').modal('show');
            $('#nivel').focus();
        },
        close_modal_agregar: function () {
            var self = this;

            $('#agregar_filtro_modal').modal('hide');
            self.reset_agregar();
        },
        buscar: function () {
            var self = this,
                str = {'data':JSON.stringify(self.data.filtros)};

            if (self.data.filtros.length == 0)
            {
                return swal({
                    type: 'warning',
                    title: 'Agrega un filtro',
                    html: 'Por favor agrega un filtro antes de buscar'
                });
            }

            // var resultados = JSON.parse('{"data":{"resultados":[{"total":"141805.0","id_concepto":5,"descripcion":"GASTOS INDIRECTOS","nivel":"000.001.002.001.","nivel_hijos":"000.001.002.001.___.","nivel_padre":"000.001.002.","id_padre":4,"tiene_hijos":8,"cargado":false,"path":"TERMINAL NAICM -> CONTROL TERMINAL NAICM -> COSTO INDIRECTO -> GASTOS INDIRECTOS"}]}}');
            // Vue.set(self.data, 'resultados', resultados.data.resultados);
            //
            // return;

            $.ajax({
                type: 'GET',
                url : self.url_solicitar_reclasificacion_index +'/find',
                data: str,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    if (data.data.resultados.length > 0)
                    {
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
                complete: function () { }
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
        confirm_solicitar: function(item) {
            var self = this;
            swal({
                title: "Solicitar reclasificación",
                text: "¿Estás seguro/a de querer solicitar esta reclasificación?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.solicitar(item);
            }).catch(swal.noop);
        },
        solicitar: function(item)
        {
            var self = this;

            $.ajax({
                type: 'POST',
                url : self.url_solicitar_reclasificacion_index,
                data: item,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {

                    var new_item = item;

                    // marcar el item como "enviado" y no dejar que se envie de nuevo
                    Vue.set(new_item, 'solicitado', 1);
                    Vue.set(self.data.resultados, self.data.resultados.indexOf(item), new_item);

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Solicitud enviada correctamente'
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }
    },
    directives: {}
});