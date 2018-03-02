Vue.component('poliza-generada-index', {
    props : ['editar_prepolizas_generadas'],
    data: function () {
        return {
        }
    },

    mounted: function() {
        var self = this;

        $("#fechas").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Cancelar',
                applyLabel: 'Aplicar'
            }
        }).val('');

        $('#prepolizas_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : true,
            "order": [
                [4, "desc"]
            ],
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/sistema_contable/poliza_generada/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "data": function ( d ) {
                    if($("#fechas").val() != '')
                        d.fechas = $("#fechas").val();
                    if($("#tipo").val() != '')
                       d.tipo = $("#tipo").val();
                   if($("#estatus").val() != '')
                       d.estatus = $("#estatus").val();
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].index = i + 1;
                        json.data[i].total = '$&nbsp;' + parseFloat(json.data[i].total).formatMoney(2, '.', ',');
                        json.data[i].cuadre = '$&nbsp; ' + parseFloat(json.data[i].cuadre).formatMoney(2, '.', ',');
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'index', 'searchable' : false, orderable : false},
                {data : 'transaccion_interfaz.descripcion', searchable : true},
                {data : 'tipo_poliza_contpaq.descripcion', searchable : true},
                {data : 'concepto', searchable : true},
                {data : 'fecha', searchable : true},
                {data : 'total', searchable: true, className : 'text-right'},
                {data : 'cuadre', searchable: true, className : 'text-right'},
                {
                    data : 'estatus_prepoliza.descripcion',
                    render : function (data, type, row) {
                        return '<span class="label" style="background-color:'+row.estatus_prepoliza.label+'">'+row.estatus_prepoliza.descripcion+'</span>';
                    },
                    searchable : true
                },
                {data : 'poliza_contpaq', searchable : true},
                {
                    data : {},
                    render : function (data, type, row) {
                        return '<a href="'+App.host + '/sistema_contable/poliza_generada/' + data.id_int_poliza +'" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>'
                        + (self.editar_prepolizas_generadas == true ? '<a href="'+App.host + '/sistema_contable/poliza_generada/' + data.id_int_poliza +'/edit'+'" title="Editar" class="btn btn-xs btn-info '+(data.estatus == 2 ? 'disabled' : '')+'"><i class="fa fa-pencil"></i></a>' : '')
                        + '<a href="'+App.host + '/sistema_contable/poliza_generada/' + data.id_int_poliza +'/historico'+'" title="Histórico" class="btn btn-xs btn-success '+(data.historicos.length > 0 ? '' : 'disabled')+'"><i class="fa fa-clock-o"></i></a>'
                    },
                    searchable : false,
                    orderable : false
                }
            ],
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

    methods: {
        consultar : function () {
            var table = $('#prepolizas_table').DataTable();
            table.ajax.reload();
        }
    }

});
