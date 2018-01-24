Vue.component('variacion-volumen', {
    props : ['filtros', 'niveles'],
    data : function () {
        return {
            form : {
                partidas : [],

            },
            cargando : false
        }
    },

    mounted: function () {
        var self = this;
        $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : false,
            "ajax": {
                "url": App.host + '/conceptos/getPathsConceptos',
                "type" : "POST",
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "data": function ( d ) {
                    d.filtros = self.filtros;
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.')
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
                {data : 'monto_presupuestado', className : 'text-right'}
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
    },

    methods : {
        get_conceptos : function () {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        }
    }
});