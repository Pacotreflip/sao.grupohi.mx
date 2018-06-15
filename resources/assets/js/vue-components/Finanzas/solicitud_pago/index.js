Vue.component('solicitud-pago-index', {
    template: require('./templates/index.html'),
    data: function () {
        return {
            solicitudes: [],
            cargando: false
        }
    },

    mounted: function () {
        var self = this;
        this.getSolicitudes().then(function (data) {
            self.solicitudes = data;
            self.cargando = false;
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : false,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": App.host + '/finanzas/solicitud_pago/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto = '<span class="pull-left">$</span>' + '<span class="pull-right">' + parseFloat(json.data[i].monto).formatMoney(2, '.', ',') + '</span>';
                        json.data[i].FechaHoraRegistro = new Date(json.data[i].FechaHoraRegistro).dateFormat();
                    }
                    return json.data;
                }
            },


            "columns" : [
                {data : 'numero_folio'},
                {data : 'tipo_tran.TipoTransaccion'},
                {data : 'monto', className : 'text-right'},
                {data : 'fecha'},
                {data : 'referencia'},
                {data : 'FechaHoraRegistro'},
                {
                    data : {},
                    render : function(data) {
                        return (self.consultar_comprobante_fondo_fijo ? '<a href="'+App.host+'/finanzas/comprobante_fondo_fijo/'+data.id_transaccion+'" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>' : '') +
                            (self.editar_comprobante_fondo_fijo ? '<a href="'+App.host+'/finanzas/comprobante_fondo_fijo/'+data.id_transaccion+'/edit'+'" title="Editar" class="btn btn-xs btn-info"> <i class="fa fa-pencil"></i></a>' : '') +
                            (self.eliminar_comprobante_fondo_fijo ? '<button title="Eliminar" type="button" class="btn btn-xs btn-danger btn_delete" id="'+data.id_transaccion+'"><i class="fa fa-trash"></i></button>' : '');
                    },
                    orderable : false
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
        };

        $('#comprobantes_table').DataTable(data);
    },

    methods: {
        getSolicitudes: function () {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_pago',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        resolve(response);
                    }
                })
            });
        }
    }
});