Vue.component('cierre-index', {
    data : function () {
        return {
            cierre : {
                anio : '',
                mes : ''
            },
            cierre_edit : {
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

        $(document).on('click', '.btn_open', function () {
            var id = $(this).attr('id');
            self.open(id);
        });
        $(document).on('click', '.btn_close', function () {
            var id = $(this).attr('id');
            self.close(id);
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
                    data : {},
                    render : function(data) {
                        return '<span class="label" style="background-color: ' + (data.abierto == true ? 'rgb(243, 156, 18)' : 'rgb(0, 166, 90)') + '">' + (data.abierto == true ? 'Abierto' : 'Cerrado') + '</span>'
                    }
                },
                {
                    data : {},
                    render : function(data) {
                        return  '<div class="btn-group">' +
                                  '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">' +
                                    '<span class="caret"></span>' +
                                  '</button>' +
                                  '<ul class="dropdown-menu">' +
                                    '<li>' +
                                      '<a href="#" id="'+ data.id +'" class="btn_'+(data.abierto == true ? 'close' : 'open')+'">' + (data.abierto == true ? 'Cerrar ' : 'Abrir ') + '<?php echo (Auth::id()) ?></a>' +
                                    '</li>' +
                                  '</ul>' +
                                '</div>';
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

        open : function (id_cierre) {
            var self = this;

            swal({
                title: 'Abrir Periodo',
                text : 'Escriba el motivo de la apertura del Periodo : ',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Abrir',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (motivo) => {
                    return new Promise((resolve) => {
                        $.ajax({
                            'url' : App.host + '/configuracion/cierre/' + id_cierre + '/open',
                            'type' : 'POST',
                            'data' : {
                                '_method' : 'PATCH',
                                'motivo' : motivo
                            },
                            beforeSend : function () {
                                self.guardando = true;
                            },
                            success : function (response) {
                                $('#cierres_table').DataTable().ajax.reload(null, false);
                                swal({
                                    type : 'success',
                                    title : 'Periodo abierto correctamente',
                                    html: '<p>Año : <b>' + response.anio + '</b> ' + 'Mes : <b>'+ parseInt(response.mes).getMes() +'</b></p>'
                                });
                            },
                            complete : function () {
                                self.guardando = false;
                            }
                        })
                    })
                },
                allowOutsideClick: () => !swal.isLoading()
            }).then((result) => {
            }).catch(swal.noop)
        },

        close: function (id_cierre) {
            var self = this;
            swal({
                title: '¿Deseas volver a cerrar el periodo seleccionado?',
                text: "No se podrán realizar transacciones para el periodo seleccionado",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Cerrar',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {

                $.ajax({
                    url : App.host + '/configuracion/cierre/' + id_cierre + '/close',
                    type : 'POST',
                    data : {
                        _method : 'PATCH'
                    },
                    beforeSend: function () {
                        self.guardando = true;
                    },
                    success: function (response) {
                        $('#cierres_table').DataTable().ajax.reload(null, false);
                        swal({
                            type: 'success',
                            title: 'Periodo Cerrado Correctamente',
                            html: '<p>Año : <b>' + response.anio + '</b> ' + 'Mes : <b>'+ parseInt(response.mes).getMes() +'</b></p>'
                        })
                    },
                    complete: function () {
                        self.guardando = false;
                    }
                })

            }).catch(swal.noop);
        }
    }
});