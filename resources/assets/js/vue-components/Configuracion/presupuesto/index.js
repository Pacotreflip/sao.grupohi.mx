Vue.component('configuracion-presupuesto-index', {
    data : function () {
        return {
            description:'',
            name_column: '',
            guardando : false,
            cargando : false,
            id_config: 0
        }
    },
    mounted : function () {
        var self = this;
        $(document).on('click', '.btn_edit', function () {
            var id = $(this).data('id');
            self.getConfigedit(id);
        });
        $('#filtros_nivel').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "order": [
                [1, "ASC"]
            ],
            "searching" : true,
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/config/niveles/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "dataSrc" : function (json) {
                    return json.data;
                }
            },
            "columns" : [
                {data : 'order_by', 'name' : 'Orden', 'searchable' : true},
                {data : 'name_column', 'name' : 'Filtro', 'searchable' : true},
                {data : 'description', 'name' : 'Descripción', 'searchable' : true},
                {
                    data : {},
                    render : function(data) {
                        return '<button class="btn btn-xs btn-default btn_edit" title="Editar" data-id="'+data.id+'" id="'+data.id+'"><i class="fa fa-pencil"></i></button>';
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
        getConfigedit: function (id) {
            var self = this;
            $.ajax({
                url: App.host + '/config/niveles/' + id,
                type: 'GET',
                beforeSend:function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.id_config = response[0].id;
                    self.description = response[0].description;
                    self.name_column = response[0].name_column;
                    self.validation_errors.clear('form_update_config');
                    $('#config_edit').modal('show');
                    self.validation_errors.clear('form_update_config');
                },
                complete:function () {
                    self.cargando = false;
                }
            })
        },
        update_config: function () {
            var self = this;
            var id_config = self.id_config;
            $.ajax({
                url : App.host + '/config/niveles/update/'+id_config,
                type: 'PATCH',
                data : {
                    description : self.description,
                },
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    swal({
                        type: 'success',
                        title: 'El nombre de la columna ' + response.data.name_column + ' fue registrado correctamente'
                    }).then(function() {
                        $('#filtros_nivel').DataTable().ajax.reload(null, false);
                        $('.modal').modal('hide');
                    });
                },
                complete : function () {
                    self.guardando = false;
                }
            })
        },
        confirm_update_config: function () {
            var self = this;
            swal({
                title: "Actualizar el registro",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.update_config();
                }
            });
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'update_config') {
                    this.confirm_update_config();
                }
            }).catch(() => {
                swal({
                     type: 'warning',
                     title: 'Advertencia',
                     text: 'Por favor corrija los errores del formulario'
                 });
            });
        },
    }
});