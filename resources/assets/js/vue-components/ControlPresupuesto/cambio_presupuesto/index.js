Vue.component('cambio-presupuesto-index', {
    data: function () {
        return {
            data :'',
            show_pdf: ''
        }
    },

    mounted: function () {
        var self=this;

        $(document).on('click', '.mostrar_pdf', function () {
            var _this = $(this),
                id = _this.data('pdf_id');

            self.show_pdf = App.host + '/control_presupuesto/cambio_presupuesto/'+ id +'/pdf';
            $('#pdf_modal').modal('show');
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "ajax": {
                "url": App.host + '/control_presupuesto/cambio_presupuesto/paginate',
                "type": "POST",
                "beforeSend": function () {
                   // self.guardando = true;
                },
                "complete": function () {
                    //self.guardando = false;
                },
                "dataSrc": function (json) {


                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].registro = json.data[i].user_registro.nombre + ' ' + json.data[i].user_registro.apaterno + ' ' + json.data[i].user_registro.amaterno;
                    }

                    return json.data;
                }
            },
            "columns": [
                {data: 'tipo_orden.descripcion'},
                {data: 'created_at'},
                {data: 'registro', orderable: false},
                {data: 'estatus.descripcion'},
                {
                    data: {},
                    render: function(data, type, row, meta) {
                        var  button='<span class="label" ></span><button class="btn btn-xs btn-info mostrar_pdf" data-pdf_id="'+ row.id +'" title="Formato"><i class="fa fa-file-pdf-o"></i></button>';
                            button='<a title="Ver" href="'+App.host+'/control_presupuesto/cambio_presupuesto/'+data.id+'">';
                        button+='<button title="Ver" type="button" class="btn btn-xs btn-default" >';
                        button+='<i class="fa fa-eye"></i>';
                        button+='   </button>';
                        button+='  </a>';
                       return button;
                    },
                    orderable: false
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


        $('#cierres_table').DataTable(data);
    }

});