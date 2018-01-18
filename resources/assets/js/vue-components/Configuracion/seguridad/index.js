Vue.component('configuracion-seguridad-index', {
    data : function () {
        return {
            permisos : [],
            permisos_alta : [],
            role : {
                name : '',
                description : '',
                display_name : ''
            },
            guardando : false,
            cargando : false
        }
    },

    computed : {
        nombre_corto : function () {
            return this.role.display_name.replace(new RegExp(" ", 'g'), '_').toLowerCase();

        }
    },

    mounted: function () {
        var self = this;
        this.getPermisos();

        $('#edit_role_modal').on('shown.bs.modal', function () {
            $('#nombre_edit').focus();
        })

        $('#create_role_modal').on('shown.bs.modal', function () {
            $('#nombre').focus();
        })

        $(document).on('click', '.btn_edit', function () {
            var id = $(this).attr('id');
            self.getRole(id);
        });

        $('#roles_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "order": [
                [2, "desc"]
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
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                    }
                    return json.data;
                }
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
                            html += perm.display_name+ '<br>';
                        });
                        return html;
                    },
                    orderable : false
                },
                {
                    data : {},
                    render : function(data) {
                        return '<button class="btn btn-xs btn-default btn_edit" title="Editar" id="'+data.id+'"><i class="fa fa-pencil"></i></button>';
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
                    self.permisos_alta = [];
                    self.role.perms.forEach(function(perm) {
                        self.permisos_alta.push(perm.id)
                    })
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

        updateRol : function () {
            var self = this;
            $.ajax({
                url : App.host + '/configuracion/seguridad/role/' + self.role.id,
                type : 'POST',
                data : {
                    _method: 'PATCH',
                    display_name : self.role.display_name,
                    description : self.role.description,
                    permissions : self.permisos_alta
                },
                beforeSend : function () {
                    self.guardando = true
                },
                success : function (response) {
                    $('.modal').modal('hide');
                    self.closeModal();
                    $('#roles_table').DataTable().ajax.reload(null, false);
                    swal({
                        type: 'success',
                        title: 'Rol ' + response.display_name + ' actualizado correctamente'
                    });
                },
                complete : function (response) {
                    self.guardando = false;
                }
            })
        },

        asignado : function (permiso) {
            var found = this.role.perms.find(function(element) {
                return element.id == permiso.id;
            });
            return found != undefined;
        },

        closeModal: function () {
            this.permisos_alta = []
            this.role = {
                name : '',
                description : '',
                display_name : ''
            }
        },

        saveRol: function() {
            var self = this;
            $.ajax({
                url : App.host + '/configuracion/seguridad/role',
                type: 'POST',
                data : {
                    name : self.nombre_corto,
                    display_name : self.role.display_name,
                    description : self.role.description,
                    permissions : self.permisos_alta
                },
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    $('.modal').modal('hide');
                    self.closeModal();
                    $('#roles_table').DataTable().ajax.reload(null, false);

                    swal({
                        type: 'success',
                        title: 'Rol ' + response.display_name + ' registrado correctamente'
                    });
                },
                complete : function () {
                    self.guardando = false;
                }
            })
        }
    }
});