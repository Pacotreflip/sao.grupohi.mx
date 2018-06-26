Vue.component('solicitud-recursos-index', {
    template: require('./templates/index.html'),
    data: function () {
        return {
            cargando: false
        }
    },

    mounted: function () {
        var self = this;

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": App.host + '/api/finanzas/solicitud_recursos/paginate',
                "type": "POST",
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].fecha_registro = new Date(json.data[i].created_at).dateShortFormat();
                        json.data[i].usuario_registro = json.data[i].usuario.amaterno + ' ' + json.data[i].usuario.apaterno + ' ' + json.data[i].usuario.nombre;
                        json.data[i].cantidad_transacciones = json.data[i].partidas.length;
                        $.each(json.data[i].partidas, function(index, value) {
                            json.data[i].total += value.monto;
                        });
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'folio'},
                {data : 'fecha_registro'},
                {data : 'usuario_registro'},
                {data : 'FechaHoraRegistro'},
                {data : 'total'},
                {data : 'total'}
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
        };

        $('#solicitudes_recursos_table').DataTable(data);
    }
});