Vue.component('reclasificacion_costos-index', {
    data : function () {
        return {
            'solicitudes': [],
            'partidas': [],
            'guardando' : false
        }
    },
    computed: {},
        mounted: function () {
            var self = this;

            $(document).on('click', '.btn_abrir', function () {
                var _this = $(this),
                    partidas = _this.data('row').partidas;

                self.partidas = partidas;

                $('#solicitud_detalles_modal').modal('show');
            });

            $('#solicitudes_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering" : false,
                "searching" : false,
                "ajax": {
                    "url": App.host + '/control_costos/solicitudes_reclasificacion/paginate',
                    "type" : "GET",
                    "beforeSend" : function () {
                        self.guardando = true;
                    },
                    "complete" : function () {
                        self.guardando = false;
                    },
                    "dataSrc" : function (json) {
                        self.solicitudes = json.data;
                        return json.data;
                    }
                },
                "columns" : [
                    {data : 'motivo'},
                    {
                        data : 'fecha',
                        render : function(data, type, row) {
                            return new Date(row.created_at).dateShortFormat();
                        }
                    },
                    {
                        data : 'estatus',
                        render : function(data, type, row) {
                            return row.estatus.descripcion;
                        }
                    },
                    {
                        data : 'acciones',
                        render : function(data, type, row) {
                            return "<button type='button' title='Ver' class='btn btn-xs btn-success btn_abrir' data-row='"+ JSON.stringify(row) +"'><i class='fa fa-eye'></i></button>";
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
    directives: {},
    methods: {
        close_modal_detalles: function () {
            var self = this;

            $('#solicitud_detalles_modal').modal('hide');

            // reset partidas
            Vue.set(self.data, 'partidas', []);
        }
    }
});
