Vue.component('procuracion-asignacion-index', {
    props: ['permission', 'permission_eliminar_asignacion'],
    data : function () {
        return {
            'data' : {
            },
            'table':''
        }
    },
    mounted: function()
    {
        var self = this;
        var data = {
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : false,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": App.host + '/api/procuracion/asignacion/paginate',
                "type" : "POST",
                "headers": {
                    'Authorization': localStorage.getItem('token')
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", localStorage.getItem('token'));
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].usuario_asigna = json.data[i].usuario_asigna.nombre +" "+ json.data[i].usuario_asigna.apaterno +" "+ json.data[i].usuario_asigna.amaterno;
                        json.data[i].usuario_asignado = json.data[i].usuario_asignado.nombre +" "+ json.data[i].usuario_asignado.apaterno +" "+ json.data[i].usuario_asignado.amaterno;
                        //json.data[i].tipo_tran = ((json.data[i].transaccion.tipo_transaccion=='49')?json.data[i].transaccion.referencia.trim():json.data[i].transaccion.observaciones.trim());
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'numero_folio'},
                {data : 'transaccion.tipo_tran.Descripcion',orderable : false},
                {data : 'transaccion.numero_folio',orderable : false},
                {data : 'usuario_asigna',orderable : false},
                {data : 'created_at'},
                {data : 'usuario_asignado',orderable : false},
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

        if(self.permission) {
            if(self.permission_eliminar_asignacion) {
                data.columns.push({
                    data: {},
                    render: function (data) {
                        return '<button class=\'remove\' data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                    },
                    orderable: false
                });
            }
        }

        self.table = $('#asignacion_table').DataTable(data);
        $(document).delegate('.remove','click',function () {
            var id = $(this).data('id');
            self.confirm_eliminar(id);
        });
    },
    methods: {
        confirm_eliminar: function(id_asignacion) {
            var self = this;
            swal({
                title: "Eliminar asignacion",
                text: "¿Estás seguro/a de que deseas eliminar la asignación?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.eliminar(id_asignacion);
                }
            }).catch(swal.noop);
        },
        eliminar: function (id_asignacion) {
            var self = this;
            $.ajax({
                type: 'DELETE',
                url : App.host +'/api/procuracion/asignacion/'+ id_asignacion,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    self.table.ajax.reload( null, false );
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Asignación eliminado'
                    });
                },
                complete: function () { }
            });
        }
    }
});