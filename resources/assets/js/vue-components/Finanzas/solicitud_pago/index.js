Vue.component('solicitud-pago-index', {
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
                "url": App.host + '/api/finanzas/solicitud_pago/paginate',
                "type": "POST",
                "data": {
                    with: ['TipoTran', 'antecedente']
                },
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
                        json.data[i].transaccion_antedecente = (json.data[i].antecedente != null ? '# ' + json.data[i].antecedente.numero_folio + " - " + (json.data[i].antecedente.referencia ? json.data[i].antecedente.referencia.trim() : '---') + (json.data[i].antecedente.observaciones ? ' (' + json.data[i].antecedente.observaciones.trim() + ')' : '') : 'NINGUNA');
                        json.data[i].FechaHoraRegistro = new Date(json.data[i].FechaHoraRegistro).dateFormat();
                        json.data[i].monto = '<span class="pull-left">$</span>' + '<span class="pull-right">' + parseFloat(json.data[i].monto).formatMoney(2, '.', ',') + '</span>';
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'numero_folio'},
                {data : 'tipo_tran.Descripcion', orderable : false},
                {data : 'transaccion_antedecente', orderable : false},
                {data : 'monto'},
                {data : 'destino'},
                {data : 'FechaHoraRegistro'},
                {data : 'observaciones', orderable : false}

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

        $('#solicitudes_table').DataTable(data);
    }
});