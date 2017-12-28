Vue.component('cierre-index', {
    data : function () {
        return {
            cierre : {
                anio : '',
                mes : '',
                transacciones : []
            },
            cargando : false
        }
    },

    mounted: function () {

        var self = this;

        $('#cierres_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : false,
            "searching" : false,
            "ajax": {
                "url": App.host + '/configuracion/cierre/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].anio = json.data[i].fecha.split('-')[0];
                        json.data[i].mes = parseInt(json.data[i].fecha.split('-')[1]).getMes();
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].registro = json.data[i].user_registro.nombre + ' ' + json.data[i].user_registro.apaterno + ' ' + json.data[i].user_registro.amaterno;
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'anio'},
                {data : 'mes'},
                {data : 'registro'},
                {data : 'created_at'},
                {
                    data : 'id',
                    render : function(data) {
                        return '<a href="'+data+'">Abrir</a>';
                    }
                }
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
        generar_cierre : function () {
            $('#create_cierre_modal').modal('show');
        }
    }
});