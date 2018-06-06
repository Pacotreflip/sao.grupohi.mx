Vue.component('comprobante-fondo-fijo-index',{
    props : ['consultar_comprobante_fondo_fijo', 'editar_comprobante_fondo_fijo', 'eliminar_comprobante_fondo_fijo'],
    data : function () {
        return {

        }
    },

    mounted: function () {
        var self = this;

        $(document).on('click', '.btn_delete', function () {
            var id = $(this).attr('id');
            self.delete_comprobante(id);
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : false,
            "order": [
                [5, "desc"]
            ],
            "ajax": {
                "url": App.host + '/finanzas/comprobante_fondo_fijo/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto = '<span class="pull-left">$</span>' + '<span class="pull-right">' + parseFloat(json.data[i].monto).formatMoney(2, '.', ',') + '</span>';
                        json.data[i].fecha = new Date(json.data[i].fecha).dateFormat();
                        json.data[i].FechaHoraRegistro = new Date(json.data[i].FechaHoraRegistro).dateFormat();
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'numero_folio'},
                {data : 'FondoFijo'},
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

    methods : {
        delete_comprobante : function(id) {
            var url = App.host + "/finanzas/comprobante_fondo_fijo/" + id;

            swal({
                title: "Eliminar Comprobante de Fondo Fijo",
                text: "¿Estás seguro que desea eliminar el comprobante de fondo fijo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value ) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function (data, textStatus, xhr) {
                            swal({
                                type: "success",
                                title: '¡Correcto!',
                                text: 'Comprobante de Fondo Fijo Eliminado con éxito'
                            });
                        },
                        complete: function () {
                            $('#comprobantes_table').DataTable().ajax.reload();

                        }
                    });
                }
            });
        }
    }
});