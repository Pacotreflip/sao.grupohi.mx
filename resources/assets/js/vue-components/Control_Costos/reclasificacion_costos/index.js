Vue.component('reclasificacion_costos-index', {
    data : function () {
        return {
            'solicitudes': [],
            'partidas': [],
            'guardando' : false,
            'editando': false,
            'item': {'id': 0, 'created_at': '', 'estatus_desc': '', 'estatus_string': {}, 'estatus': {}},
            'rechazando': false,
            'rechazo_motivo': '',
            'dataTable': false,
            'show_pdf': false
        }
    },
    computed: {},
        mounted: function () {
            var self = this;

            $(document).on('click', '.btn_abrir', function () {
                var _this = $(this),
                    editando = !!parseInt(_this.data('editando')),
                    item = self.solicitudes[_this.data('row')],
                    partidas = item.partidas;

                item.estatus_desc = item.estatus_string.descripcion;
                self.partidas = partidas;
                self.item = item;

                if (editando){
                    self.editando = item;
                }

                $('#solicitud_detalles_modal').modal('show');
            });

            self.dataTable = $('#solicitudes_table').DataTable({
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
                    {
                        data : {},
                        render : function(data, type, row, meta) {
                            return  meta.row + 1;
                        }
                    },
                    {
                        data : 'id',
                        render : function(data, type, row) {
                            return '#'+ row.id;
                        }
                    },
                    {
                        data : 'fecha',
                        render : function(data, type, row) {
                            return new Date(row.fecha ? row.fecha : row.created_at).dateShortFormat();
                        }
                    },
                    {
                        data : 'motivo',
                        render : function(data, type, row) {
                            return row.motivo.replace(/'/g, "\\'");
                        }
                    },
                    {
                        data : 'estatusString',
                        render : function(data, type, row) {
                            var _estatus = '';

                            if (row.estatus_string.estatus == 2)
                                _estatus = '<span class="label bg-green">'+ row.estatus_string.descripcion +'</span> ';

                            else if (row.estatus_string.estatus == -1)
                                _estatus = '<span class="label bg-red">'+ row.estatus_string.descripcion +'</span> ';

                            else
                                _estatus = '<span class="label bg-blue">'+ row.estatus_string.descripcion +'</span> ';

                            return _estatus;
                        }
                    },
                    {
                        data : 'acciones',
                        render : function(data, type, row, meta) {
                            var _return = "<button type='button' title='Ver' class='btn btn-xs btn-success btn_abrir' data-row='"+ meta.row +"' data-editando='0'><i class='fa fa-eye'></i></button>";

                            // Muestra el botón de editar si la solicitud aún no está autorizada/rechazada
                            if (row.estatus_string.id == 1)
                            {
                                _return = _return +" <button type='button' title='Editar' class='btn btn-xs btn-info btn_abrir' data-row='"+ meta.row +"' data-editando='1'><i class='fa fa-pencil'></i></button>";
                            }

                            return _return;
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
            self.partidas = [];
            self.editando = false;
            self.rechazando = false;
            self.rechazo_motivo = '';
            self.show_pdf = false;
        },
        confirm: function(tipo) {
            var self = this;

            // Manda error si no hay una solicitud para aprobar/rechazar
            if (self.editando.length > 0)
                return  swal({
                    type: 'warning',
                    title: 'Error',
                    text: 'La solicitud está vacía'
                });

            // Al rechazar debe de haber un motivo
            if (tipo == 'rechazar' && self.rechazo_motivo == '')
                return  swal({
                    type: 'warning',
                    title: 'Error',
                    text: 'Debes de especificar un motivo para rechazar'
                });

            swal({
                title: tipo.mayusculaPrimerLetra(),
                text: "¿Estás seguro/a de que deseas "+ tipo +" esta solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                if (tipo == "aprobar") {
                    self.aprobar();
                }
                else if (tipo == "rechazar") {
                    self.rechazar();
                }
            }).catch(swal.noop);
        },
        aprobar: function () {
            var self = this,
                str = {'data':JSON.stringify(self.editando), 'tipo': 'aprobar'};

            $.ajax({
                type: 'POST',
                url : App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                  if (data.resultado)
                      self.dataTable.ajax.reload(function (){
                          swal({
                              type: 'success',
                              title: '',
                              html: 'La solicitud fué autorizada'
                          });
                      });

                  else
                      swal({
                          type: 'warning',
                          title: '',
                          html: 'La operación no pudo concretarse'
                      });

                  self.close_modal_detalles();
                },
                complete: function () {
                }
            });
        },
        rechazar: function () {
            var self = this,
                str = {'data':JSON.stringify(self.editando), 'tipo': 'rechazar', 'motivo': self.rechazo_motivo};

            $.ajax({
                type: 'POST',
                url : App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    if (data.resultado)
                        self.dataTable.ajax.reload(function (){
                            swal({
                                type: 'success',
                                title: '',
                                html: 'La solicitud fué rechazada'
                            });
                        });

                    else
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'La operación no pudo concretarse'
                        });

                    self.close_modal_detalles();
                },
                complete: function () {
                }
            });
        },
        rechazar_motivo: function () {

            var self = this;

            self.rechazando = true;
        },
        cancelar_rechazo: function () {
            var self = this;

            self.rechazando = false;
            self.rechazo_motivo = '';
        },
        pdf: function (id) {
            var self = this,
                url = App.host + '/control_costos/solicitudes_reclasificacion/generarpdf?item='+ id;

            self.show_pdf = url;
        },
        html_decode: function(input){
            var e = document.createElement('div');
            e.innerHTML = input;

            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        }
    }
});
