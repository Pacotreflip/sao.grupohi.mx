Vue.component('solicitud-recursos-index', {
    template: require('./templates/index.html'),
    data: function () {
        return {
            cargando: false
        }
    },

    mounted: function () {
        var self = this;

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": App.host + '/api/finanzas/solicitud_recursos/paginate',
                "type": "POST",
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].total = 0;

                        json.data[i].fecha_registro = new Date(json.data[i].created_at).dateShortFormat();
                        json.data[i].usuario_registro = json.data[i].usuario.amaterno + ' ' + json.data[i].usuario.apaterno + ' ' + json.data[i].usuario.nombre;
                        json.data[i].estado = json.data[i].estado == 1 ? 'Generada' : 'Finalizada';
                        json.data[i].cantidad_transacciones = json.data[i].partidas.length ? json.data[i].partidas.length : 0;
                        $.each(json.data[i].partidas, function(index, value) {
                            json.data[i].total += value.monto;
                        });

                        json.data[i].total = '$ ' + parseFloat(json.data[i].total).formatMoney(2, '.', ',');
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'folio'},
                {data : 'fecha_registro'},
                {data : 'usuario_registro'},
                {data : 'estado'},
                {data : 'cantidad_transacciones'},
                {data : 'total'},
                {data : {}, render: function (data) {
                        return '<a href="'+App.host+'/finanzas/solicitud_recursos/'+data.id+ '" title="Ver" class="btn btn-xs btn-default"> <i class="fa fa-eye"></i></a>'
                    }}
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

        $('#solicitudes_recursos_table').DataTable(data);
    },
    methods: {
        confirmar_solicitud: function(){

            // finanzas.solicitud_recursos.create
            var self = this;

            $.ajax({
                url: App.host + '/api/finanzas/solicitud_recursos/solicitud_semana',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    if(! response) {
                        self.crear_solicitud().then(function (data) {
                            return window.location.href = App.host + "/finanzas/solicitud_recursos/" + data.solicitud.id + "/edit";
                        });
                    } else {
                        var estado = response.estado;
                        var texto = estado == 1 ? 'Ya existe una solicitud para esta semana y aún no se ha finalizado, se mostrará para editarla' : 'Ya existe una solicitud finalizada para esta semana, se creará una nueva solicitud urgente';
                        swal({
                            title: 'Crear solicitud',
                            text: texto,
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Si, Continuar',
                            cancelButtonText: 'No, Cancelar',
                        }).then(function (result) {
                            if(result.value) {
                                if(estado == 1) {
                                    return window.location.href = App.host + "/finanzas/solicitud_recursos/" + response.id + "/edit";
                                } else {
                                    self.crear_solicitud().then(function (data) {
                                        return window.location.href = App.host + "/finanzas/solicitud_recursos/" + data.solicitud.id + "/edit";
                                    });
                                }
                            }
                        });
                    }
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },

        crear_solicitud: function () {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/api/finanzas/solicitud_recursos',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': App.csrfToken,
                        'Authorization': localStorage.getItem('token')
                    },
                    success: function (response) {
                        resolve({
                           solicitud: response
                        });
                    }
                });
            })
        }
    }
});