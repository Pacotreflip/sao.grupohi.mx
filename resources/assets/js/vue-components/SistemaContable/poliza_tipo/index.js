Vue.component('sistemacontable-polizatipo-index', {
    props: [
        'actions_permission',
        'permission_eliminar_plantilla_prepoliza',
    ],
    data: function () {
        return {
            'data': {
                'item':''
            },
            'guardando': false,
            'peticion': false,
            'table': ''
        }
    },
    computed: {
        cuentas_disponibles: function () {

        }
    },
    mounted: function () {
        var self = this;
        $(document).delegate('.confirm_eliminar', 'click', function () {
            var id = $(this).data('id');
            self.confirm_eliminar(id);
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "order": [
                [4, "desc"]
            ],
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/api/sistema_contable/poliza_tipo/paginate',
                "type": "POST",
                "headers": {
                    'Authorization': localStorage.getItem('token')
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", localStorage.getItem('token'));
                },
                "dataSrc": function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].index = i + 1;
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                         if(json.data[i].vigencia == "Vigente") {
                             json.data[i].vigencia = "<span class=\"label label-success\">" + json.data[i].vigencia + "</span>";
                         }else if(json.data[i].vigencia == "No Vigente"){
                            json.data[i].vigencia = "<span class=\"label label-danger\">" + json.data[i].vigencia + "</span>";
                        }else{
                            json.data[i].vigencia = "<span class=\"label label-info\">" + json.data[i].vigencia + "</span>";
                        }
                        json.data[i].inicio_vigencia = new Date(json.data[i].inicio_vigencia).dateFormat();
                        json.data[i].fin_vigencia = (json.data[i].fin_vigencia)?'N/A':new Date(json.data[i].fin_vigencia).dateFormat();
                        json.data[i].userregistro = json.data[i].userregistro.nombre+" "+ json.data[i].userregistro.apaterno +" "+ json.data[i].userregistro.amaterno;
                    }
                    return json.data;
                }
            },
            "columns": [
                {data: 'index', 'searchable': false, orderable: false},
                {data: 'polizatiposao.descripcion', 'searchable': false, orderable: false},
                {data: 'num_movimientos', 'searchable': false, orderable: false},
                {data: 'userregistro', 'searchable': false, orderable: false},
                {data: 'created_at', 'searchable': false, orderable: true},
                {data: 'vigencia', 'searchable': false, orderable: false},
                {data: 'inicio_vigencia', 'searchable': false, orderable: false},
                {data: 'fin_vigencia', 'searchable': false, orderable: false}
            ],
            "language": {
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
        if (self.actions_permission) {
            var $a = {
                data: {},
                render: function (data) {
                    var html = "";
                    if (self.actions_permission) {
                        html += "";
                            html += '<a title="Ver" href="'+App.host+'/sistema_contable/poliza_tipo/'+data.id+'"><button type="button" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></button></a>';
                        if (self.permission_eliminar_plantilla_prepoliza) {
                            html += '<button title="Eliminar" type="button" class="btn btn-xs btn-danger confirm_eliminar" data-id="'+data.id+'" ><i class="fa fa-trash"></i></button>';
                        }
                    }
                    return html;
                },
                orderable: false, 'searchable': false
            };
            data.columns.push($a);
        }
        self.table = $('#tablePolizaTipo').DataTable(data);
    },
    directives: {
        datepicker: {
            inserted: function (el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        },
    },
    methods: {
        confirm_eliminar: function (id) {
            var self = this;
            swal({
                title: "¡Eliminar Plantilla!",
                text: "¿Esta seguro de que deseas eliminar la Plantilla?",
                input: 'text',
                inputPlaceholder: "Motivo de eliminación.",
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: function (inputValue) {
                    return new Promise(function (resolve) {
                        if (inputValue === "") {
                            swal.showValidationError("¡Escriba el motivo de la eliminación!");
                        }
                        resolve()
                    })
                },
                allowOutsideClick: false
            }).then(function (result) {
                if (result.value) {
                    self.eliminar(id,result.value);
                }
            });
        },
        eliminar: function (id,mensaje) {
            var self = this;
            $.ajax({
                url:  App.host + "/api/sistema_contable/poliza_tipo/" + id,
                method: 'DELETE',
                data: {motivo: mensaje},
                success: function (data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Plantilla Eliminada con éxito',
                        confirmButtonText: "Ok",
                        closeOnConfirm: true
                    }).then(function () {
                        self.table.ajax.reload( null, false );
                    });
                }
            });
        },
        validateForm: function(scope, funcion) {
            self = this;
            this.$validator.validateAll(scope).then(() => {
                if(funcion === 'confirm_guardar') {
                self.confirm_guardar_traspaso();
            } else if (funcion === 'confirm_editar') {
                self.confirm_editar();
            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        }
    }
});