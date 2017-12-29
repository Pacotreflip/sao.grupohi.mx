Vue.component('cierre-index', {
    data : function () {
        return {
            cierre : {
                anio : '',
                mes : ''
            },
            cierre_edit : {
                transacciones : [],
                id : '',
                anio : '',
                created_at : '',
                description : '',
                mes : '',
                registro : ''
            },
            tipos_tran : {},
            guardando : false
        }
    },

    mounted: function () {

        var self = this;
        self.getTiposTran();

        $(document).on('click', '.btn_abrir', function () {
            var id = $(this).attr('id');
            $.ajax({
                url : App.host + '/configuracion/cierre/' + id,
                type : 'GET',
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    response.transacciones = [];
                    self.cierre_edit = response;
                },
                complete : function () {
                    self.guardando = false;
                    $('#abrir_cierre_modal').modal('show');
                }
            });
        });

        $('#fecha').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm/yyyy',
            language: 'es',
        }).on('changeDate', function(selected){
            self.cierre.anio = new Date(selected.date.valueOf()).getFullYear();
            self.cierre.mes = new Date(selected.date.valueOf()).getMonth() + 1;
        });

        $('#cierres_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : false,
            "searching" : false,
            "ajax": {
                "url": App.host + '/configuracion/cierre/paginate',
                "type" : "POST",
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
                {data : 'anio'},
                {data : 'mes'},
                {data : 'registro'},
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

    methods : {
        generar_cierre : function () {
            $('#create_cierre_modal').modal('show');
        },

        save_cierre : function () {
            var self = this;

            $.ajax({
                url : App.host + '/configuracion/cierre',
                type : 'POST',
                data : self.cierre,
                beforeSend : function () {
                    self.guardando = true;
                },
                success :function () {
                    $('#cierres_table').DataTable().ajax.reload();

                    $('#create_cierre_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cierre de Periodo guardado correctamente',
                    });
                },
                complete : function () {
                    self.guardando = false;
                }
            });
        },

        getTiposTran :function () {
            var self = this;

            $.ajax({
                url : App.host + '/tipo_tran/lists',
                type : 'GET',
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    self.tipos_tran = response;
                },
                complete : function () {
                    self.guardando = false;
                }
            });
        }
    }
});