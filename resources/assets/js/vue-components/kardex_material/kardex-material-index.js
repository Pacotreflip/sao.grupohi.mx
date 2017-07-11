Vue.component('kardex-material-index', {
    props: ['materiales'],
    data: function() {
        return {
            'data' : {
                'items': []
            },
            'form' : {
                'material': {
                    'id_material': '',
                    'nivel': '',
                    'descripcion': '',
                    'unidad': '',
                    'n_padre':'',
                    'd_padre':''
                },
                'totales':{
                    'entrada_material':'',
                    'entrada_valor':'',
                    'salida_material':'',
                    'salida_valor':'',
                    'existencia':''
                }
            },
            valor: -1
        }
    },
    methods :{
        datos: function () {
            var self = this;
            var material = self.materiales[self.valor];
            var url = App.host + '/sistema_contable/kardex_material/';
            var ematerial = 0;
            var evalor = 0;
            var smaterial = 0;
            var svalor = 0;

                url = url + material.id_material;

                // Consulta de datos de kardex por material

                $.ajax({
                    type: 'GET',
                    url: url,
                    beforeSend: function () {
                    },
                    success: function (response) {
                        // Asignación de datos para vista de detalle
                        self.form.material.id_material = material.id_material;
                        self.form.material.nivel =material.nivel;
                        self.form.material.n_padre = self.form.material.nivel.substr(0, 4);
                        self.form.material.descripcion = material.descripcion;
                        self.form.material.unidad = material.unidad;
                        self.form.material.d_padre = material.d_padre[0].descripcion;

                        self.data.items = response;

                        response.forEach(function (item) {
                            if(item.transaccion.tipo_transaccion == 33){
                                ematerial += parseFloat(item.cantidad);
                                evalor += parseFloat(item.precio_unitario);
                            }
                            if(item.transaccion.tipo_transaccion == 34){
                                smaterial += parseFloat(item.cantidad);
                                svalor += parseFloat(item.precio_unitario);
                            }
                        });
                        // Asignacion de valores totales de Transacciones
                        self.form.totales.entrada_material = ematerial;
                        self.form.totales.entrada_valor = evalor;
                        self.form.totales.salida_material = smaterial;
                        self.form.totales.salida_valor = svalor;
                        self.form.totales.existencia = ematerial - smaterial;
                    }
                });

        }
    },

});