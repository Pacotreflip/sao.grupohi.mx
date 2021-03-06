Vue.component('cambio-presupuesto-create', {
    props : ['operadores'],
    data : function () {
        return {
            form : {
                id_tipo_cobrabilidad : '',
                id_tipo_orden : '',
                id_tarjeta : '',
                filtro : {
                    nivel : '',
                    operador : '',
                    texto : ''
                }
            },
            filtros : [],
            tipos_cobrabilidad : [],
            tipos_orden : [],
            tarjetas : [],
            cargando : false,
            bases_afectadas:[],
            niveles: [
                {nombre : 'Nivel 1', numero : 1},
                {nombre : 'Nivel 2', numero : 2},
                {nombre : 'Nivel 3', numero : 3},
                {nombre : 'Sector', numero : 4},
                {nombre : 'Cuadrante', numero : 5},
                {nombre : 'Especialidad', numero : 6},
                {nombre : 'Partida', numero : 7},
                {nombre : 'Sub Partida o Centa de costo', numero : 8},
                {nombre : 'Concepto', numero : 9},
                {nombre : 'Nivel 10', numero : 10},
                {nombre : 'Nivel 11', numero : 11}
            ]
        }
    },

    computed: {
        tipos_orden_filtered : function () {
            var self = this;
            return this.tipos_orden.filter(function (tipo_orden) {
                return tipo_orden.id_tipo_cobrabilidad == self.form.id_tipo_cobrabilidad;
            });
        }
    },

    mounted : function () {
        this.fetchTiposCobrabilidad();
        this.fetchTiposOrden();
        this.fetchTarjetas();
    },

    methods : {
        fetchTiposCobrabilidad: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_cobrabilidad',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                success : function (response) {
                    self.tipos_cobrabilidad = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        },

        fetchTarjetas : function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tarjeta/lists',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true;
                },
                success : function (response) {
                    self.tarjetas = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        },

        fetchTiposOrden: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_orden',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                success : function (response) {
                    self.tipos_orden = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        },
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

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'add_filtro') {
                    this.set_filtro();
                }
            }).catch(() => {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        obtenerPresupuestos: function () {
            var self = this;

            var tipoOrden = self.form.id_tipo_orden;

            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/afectacion_presupuesto/getBasesAfectadas';
            $.ajax({
                type: 'POST',
                data:{
                    tipo_orden:tipoOrden
                },
                url: url,
                beforeSend: function () {
                    self.consultando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.bases_afectadas=data.data;
                },
                complete: function () {
                    self.consultando = false;

                }
            });

        }
    }
});