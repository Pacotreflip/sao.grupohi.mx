Vue.component('configuracion-seguridad-index', {
    data : function () {
        return {
            permisos : [],
            role : {},
            guardando : false,
            cargando : false
        }
    },

    mounted: function () {
        var self = this;
        this.getPermisos();

        $(document).on('click', '.btn_edit', function () {
            var id = $(this).attr('id');
            self.getRole(id);
        });

        $('#roles_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "order": [
                [0, "desc"]
            ],
            "searching" : false,
            "ajax": {
                "url": App.host + '/configuracion/seguridad/role/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "dataSrc" : 'data'
            },
            "columns" : [
                {data : 'display_name', 'name' : 'Nombre'},
                {data : 'description'},
                {data : 'created_at'},
                {
                    data : {},
                    render : function (data) {
                        var html = '';
                        data.perms.forEach(function (perm) {
                            html += '<a href="#">'+perm.display_name+'</a>' + '<br>';
                        });
                        return html;
                    },
                    orderable : false
                },
                {
                    data : {},
                    render : function(data) {
                        return '<button class="btn btn-xs btn-default btn_edit" id="'+data.id+'"><i class="fa fa-pencil"></i></button>';
                    },

                    orderable : false
                }            ],
            "language" : {
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
        getRole: function (id) {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/seguridad/role/' + id,
                type: 'GET',
                beforeSend:function () {
                  self.cargando = true;
                },
                success: function (response) {
                    self.role = response;
                    $('#edit_role_modal').modal('show');
                },
                complete:function () {
                    self.cargando = false;
                }
            })
        },

        getPermisos: function () {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/seguridad/permission',
                type: 'GET',
                beforeSend:function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.permisos = response;
                },
                complete:function () {
                    self.cargando = false;
                }
            })
        },

        asignado : function (permiso) {
            var found = this.role.perms.find(function(element) {
                return element.id == permiso.id;
            });
            return found != undefined;
        }
    }
});