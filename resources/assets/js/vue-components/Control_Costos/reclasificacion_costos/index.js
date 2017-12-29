Vue.component('reclasificacion_costos-index', {
    data : function () {
        return {
            'solicitudes': [],
            'guardando' : false
        }
    },
    computed: {},
        mounted: function () {

            var self = this;

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


                        for (var i = 0; i < json.data.length; i++) {
                            json.data[i].mes = parseInt(json.data[i].mes).getMes();
                            json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                            json.data[i].registro = json.data[i].user_registro.nombre + ' ' + json.data[i].user_registro.apaterno + ' ' + json.data[i].user_registro.amaterno;
                        }
                        return json.data;
                    }
                },
                "columns" : [
                    {data : 'item.material.descripcion'},
                    {data : 'conceptoOriginal.descripcion'},
                    {data : 'conceptoNuevo.descripcion'},
                    {data : 'created_at'},
                    {
                        data : 'id',
                        render : function(data) {
                            return '<button class="btn btn-xs btn_abrir" id="'+data+'"><i class="fa fa-unlock"></i></button> ';
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
        getSol
    }
});
