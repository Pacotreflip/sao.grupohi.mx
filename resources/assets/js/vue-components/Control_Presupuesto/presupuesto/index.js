Vue.component('control_presupuesto-index', {
    props: ['max_niveles', 'operadores'],
    data : function () {
        return {
            conceptos : [],
            filtros : [],
            baseDatos:'',
            porcentaje:0,
            form : {
                filtro : {
                    nivel : '',
                    operador : '',
                    texto : ''
                }
            },
            cargando : false
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
    mounted: function () {
        var self = this;
       var table= $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
            destroy: true,
            "ordering" : false,
            "ajax": {
                "url": App.host + '/conceptos/getPaths',
                "type" : "POST",
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "data": function ( d ) {
                    d.filtros = self.filtros;
                    d.baseDatos = self.baseDatos;
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].cantidad_presupuestada=Number(json.data[i].cantidad_presupuestada);
                        json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.')
                        json.data[i].monto_venta ='$' +parseInt(Number( json.data[i].monto*(Number("1."+self.porcentaje)))).formatMoney(2, ',', '.')
                        json.data[i].monto = '$' + parseInt(json.data[i].monto).formatMoney(2, ',', '.')
                        json.data[i].precio_unitario_venta ='$' +parseInt(Number( json.data[i].precio_unitario)*(Number("1."+self.porcentaje))).formatMoney(2, ',', '.')
                        json.data[i].precio_unitario = '$' + parseInt(json.data[i].precio_unitario).formatMoney(2, ',', '.')

                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'filtro1'},
                {data : 'filtro2'},
                {data : 'filtro3'},
                {data : 'filtro4'},
                {data : 'filtro5'},
                {data : 'filtro6'},
                {data : 'filtro7'},
                {data : 'filtro8'},
                {data : 'filtro9'},
                {data : 'filtro10'},
                {data : 'filtro11'},
                {data : 'unidad'},
                {data : 'cantidad_presupuestada', className : 'text-right'},
                {data : 'precio_unitario', className : 'text-right'},
                {data : 'precio_unitario_venta', className : 'text-right'},
                {data : 'monto', className : 'text-right'},
                {data : 'monto_venta', className : 'text-right'}

            ],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        table.column( 14 ).visible( false );
        table.column( 16 ).visible( false );

    },
    methods: {
        crearFiltro:function () {
            var self = this;
            var table=$('#conceptos_table').DataTable({
                "processing": true,
                "serverSide": true,
                destroy: true,
                "ordering" : false,
                "ajax": {
                    "url": App.host + '/control_presupuesto/conceptos/getPaths',
                    "type" : "POST",
                    "beforeSend" : function () {
                        self.cargando = true;
                    },
                    "data": function ( d ) {
                        d.filtros = self.filtros;
                        d.baseDatos = self.baseDatos;
                    },
                    "complete" : function () {
                        self.cargando = false;
                    },
                    "dataSrc" : function (json) {
                        for (var i = 0; i < json.data.length; i++) {
                            json.data[i].cantidad_presupuestada=Number(json.data[i].cantidad_presupuestada);
                            json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.')
                            json.data[i].monto_venta ='$' +parseInt(Number( json.data[i].monto*(Number("1."+self.porcentaje)))).formatMoney(2, ',', '.')
                            json.data[i].monto = '$' + parseInt(json.data[i].monto).formatMoney(2, ',', '.')
                            json.data[i].precio_unitario_venta ='$' +parseInt(Number( json.data[i].precio_unitario)*(Number("1."+self.porcentaje))).formatMoney(2, ',', '.')
                            json.data[i].precio_unitario = '$' + parseInt(json.data[i].precio_unitario).formatMoney(2, ',', '.')

                        }
                        return json.data;
                    }
                },
                "columns" : [
                    {data : 'filtro1'},
                    {data : 'filtro2'},
                    {data : 'filtro3'},
                    {data : 'filtro4'},
                    {data : 'filtro5'},
                    {data : 'filtro6'},
                    {data : 'filtro7'},
                    {data : 'filtro8'},
                    {data : 'filtro9'},
                    {data : 'filtro10'},
                    {data : 'filtro11'},
                    {data : 'unidad'},
                    {data : 'cantidad_presupuestada', className : 'text-right'},
                    {data : 'precio_unitario', className : 'text-right'},
                    {data : 'precio_unitario_venta', className : 'text-right'},
                    {data : 'monto', className : 'text-right'},
                    {data : 'monto_venta', className : 'text-right'}
                ],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
            if(self.baseDatos!=1){
                      self.porcentaje=0;
                table.column( 14 ).visible( false );
                table.column( 16 ).visible( false );
            }
        }
        ,
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

            if(! this.filtros.length) {
                var table = $('#conceptos_table').DataTable();
                table.ajax.reload();
            }
        },

        get_conceptos : function () {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        }
    }
});