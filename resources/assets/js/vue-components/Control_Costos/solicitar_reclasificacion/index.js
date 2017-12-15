Vue.component('solicitar_reclasificacion-index', {
    props: ['url_solicitar_reclasificacion_index', 'max_niveles', 'filtros', 'operadores'],
    data : function () {
        return {
            'data' : {
                'filtros': this.filtros,
                'operadores': this.operadores,
                'agrega': {
                    'nivel': '',
                    'operador': '',
                    'texto': ''
                },
                'resultados': []
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
            var self = this;

            self.filtros.push(self.data.agrega);

            self.close_modal_agregar();
        },
        eliminar_filtro: function (item) {
            var self = this;

            self.data.filtros.splice(self.data.filtros.indexOf(item), 1);
        },
        reset_agregar: function () {
            var self = this;

            Vue.set(self.data, 'agrega', {
                'nivel': '',
                'operador': '',
                'texto': ''
            });
        },
        open_modal_agregar: function () {
            $('#agregar_filtro_modal').modal('show');
            $('#nivel').focus();
        },
        close_modal_agregar: function () {
            var self = this;

            $('#agregar_filtro_modal').modal('hide');
            self.reset_agregar();
        },
        buscar: function () {
            var self = this;

            if (self.data.filtros.length == 0)
            {
                return swal({
                    type: 'warning',
                    title: 'Agrega un filtro',
                    html: 'Por favor agrega un filtro antes de buscar'
                });
            }
console.log(self.data.filtros);
            $.ajax({
                type: 'GET',
                url : self.url_solicitar_reclasificacion_index +'/find',
                data: self.data.filtros,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
console.log(data.data.resultados);
                    Vue.set(self.data, 'resultados', data.data.resultados);
                    swal({
                        type: 'success',
                        title: '',
                        html: 'Se encontraron resultados'
                    });
                },
                complete: function () { }
            });

        }
    },
    directives: {}
});
