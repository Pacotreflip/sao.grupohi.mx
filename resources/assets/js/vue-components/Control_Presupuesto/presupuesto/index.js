Vue.component('control_presupuesto-index', {
    props: ['max_niveles', 'operadores'],
    data : function () {
        return {
            conceptos : [],
            filtros : [],
            form : {
                filtro : {
                    nivel : '',
                    operador : '',
                    texto : ''
                }
            }
        }
    },
    computed : {
        niveles: function () {
            var niveles = [], paso = 1;
            for (paso; paso <= this.max_niveles; paso++) {
                niveles.push({numero: paso, nombre: "Nivel " + paso});
            }
            return niveles;
        }
    },
    methods: {
        set_filtro : function() {
            var nivel = this.form.filtro.nivel;
            var result = this.filtros.filter(function( filtro ) {
                return filtro.nivel == nivel;
            });

            if(result.length) {
                result[0].operadores.push(
                    {
                        sql : this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                        operador : this.operadores[this.form.filtro.operador],
                        texto : this.form.filtro.texto
                    });
            } else {
                this.filtros.push({
                    nivel : this.form.filtro.nivel,
                    operadores : [
                        {
                            sql : this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                            operador : this.operadores[this.form.filtro.operador],
                            texto : this.form.filtro.texto
                        }
                    ]
                });
            }

            this.close_modal();
        },

        close_modal : function() {
            $('#agregar_filtro_modal').modal('hide');
            Vue.set(this.form, 'filtro', {nivel : '', operador : '', texto : ''});
        },

        eliminar: function (filtro, operador) {
            Vue.delete(filtro.operadores, filtro.operadores.indexOf(operador));
            if(!filtro.operadores.length) {
                Vue.delete(this.filtros, this.filtros.indexOf(filtro));
            }
        },

        getConceptos : function () {
            var slf = this;
             $.ajax({
                 url : App.host + '/conceptos/getPaths',
                 dataType : 'json',
                 data : {
                     filtros : slf.filtros
                 },
                 beforeSend: function () {

                 },
                 success: function (response) {
                     console.log(response);
                     slf.conceptos = response.conceptos;
                 },
                 error: function (error) {
                     alert(error.responseText);
                 }
             })
        }
    }
});



/*Vue.component('control_presupuesto-index', {
    props: ['max_niveles', 'operadores'],
    data : function () {
        return {
            'data' : {
                'condicionante': '',
                'temp_filtro': '',
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
    methods: {
        getMaxNiveles: function () {
            var self = this,
                niveles = [],
                paso = 1;

            for (paso; paso <= self.max_niveles; paso++) {
                niveles.push({numero: paso, nombre: "Nivel " + paso});
            }

            return niveles;
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

        reset_agregar: function () {
            var self = this;

            Vue.set(self.data, 'agrega', {
                'nivel': '',
                'operador': '',
                'texto': ''
            });

            Vue.set(self.data, 'temp_filtro', '');
            Vue.set(self.data, 'condicionante', '');
        }
    }
});*/


