Vue.component('kardex-material-index', {
    props: ['materiales'],
    data: function() {
        return {
            'data' : {
                'items': [],
                'materiales':''
            },
            'form' : {
                'material': {
                    'id_material': '',
                    'nivel': '',
                    'descripcion': '',
                    'unidad': '',
                    'n_padre':'',
                    'd_padre':'',
                    'usuario_registro':''
                },
                'totales':{
                    'entrada_material':'',
                    'entrada_valor':'',
                    'salida_material':'',
                    'salida_valor':'',
                    'existencia':''
                }
            },
            valor: -1,
            'cargando': false
        }
    },
    directives:{
        select2: {

            inserted: function (el){

                $(el).select2({
                    width:'100%',
                    ajax: {
                        url: App.host +'/sistema_contable/kardex_material/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function (params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },

                        processResults: function (data) {


                            return {

                                results: $.map(data.data.materiales, function (item) {
                                    return {
                                        text:item.descripcion,
                                        id: item.id_material
                                    }
                                })
                            };
                        },
                        error: function(error) {

                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    $('#material_select').val($('#material_select option:selected').data().data.id);
                });
            }
        }
    },
    methods :{

        datos: function () {
            var self = this;
            var material = self.valor;
            var url = App.host + '/sistema_contable/kardex_material/';
            var ematerial = 0;
            var evalor = 0;
            var smaterial = 0;
            var svalor = 0;
            // Consulta de datos de kardex por material
            if(self.valor>=0) {
                url = url + material;
                $.ajax({
                    type: 'GET',
                    url: url,
                    beforeSend: function () {
                        self.cargando=true;
                    },
                    success: function (response) {

                        material=response.data.material;
                        // Asignación de datos para vista de detalle
                        self.form.material.id_material = material.id_material;
                        self.form.material.nivel = material.nivel;
                        self.form.material.n_padre = self.form.material.nivel.substr(0, 4);
                        self.form.material.descripcion = material.descripcion;
                        self.form.material.unidad = material.unidad;
                        self.form.material.d_padre = response.data.padre.descripcion;
                        self.form.material.usuario_registro=material.UsuarioRegistro;

                        self.data.items = response.data.items;

                        response.data.items.forEach(function (item) {
                            if (item.transaccion.tipo_transaccion == 33) {
                                ematerial += parseFloat(item.cantidad);
                                evalor += parseFloat(item.precio_unitario);
                            }
                            if (item.transaccion.tipo_transaccion == 34) {
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
                    },
                    complete: function () {
                        self.cargando=false;
                    }
                });
            }else{
                self.form.material.id_material = '';
                self.form.material.nivel = '';
                self.form.material.n_padre = '';
                self.form.material.descripcion ='';
                self.form.material.unidad = '';
                self.form.material.d_padre = '';
                self.form.totales.existencia = '';
                self.form.totales.entrada_material = '';
                self.form.totales.entrada_valor = '';
                self.form.totales.salida_material='';
                self.form.totales.salida_valor = '';
                self.form.totales.existencia = '';
            }
        }
    },

});