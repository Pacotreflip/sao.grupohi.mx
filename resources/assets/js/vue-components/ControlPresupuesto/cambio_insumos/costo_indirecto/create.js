Vue.component('cambio-insumos-indirecto-create', {
    props : [ 'id_tipo_orden'],
    data : function () {
        return {
            form: {
                partidas: []
            },
            id_concepto_indirecto: '',
            concepto_seleccionado:[],
            cargando : false,
            guardando : false,
            cargando_tarjetas : true
        }
    },
    mounted: function () {
        var self = this;
        $('#sel_concepto_indirecto').select2({
            width: '100%',
            ajax: {
                url: App.host + '/conceptos/getPathsCostoIndirecto',
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        descripcion:  params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data.conceptos, function (item) {
                            return {
                                text: item.filtro6+ " -> "+item.filtro7,
                                descripcion: item.filtro6,
                                id_material: item.id_concepto,
                            }
                        })
                    };
                },
                error: function (error) {
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1
        }).on('select2:select', function (e) {
            var data = e.params.data;
            data.id_elemento=data.id_concepto;
            // console.log(data);
            self.concepto_seleccionado=data;
        });

        self.cargando_tarjetas = false;
        $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
            "paging" : false,
            "ordering" : true,
            "searching" : false,
            "ajax": {
                "url": App.host + '/conceptos/getPathsConceptos',
                "type" : "POST",
                "beforeSend" : function () {
                    self.cargando = true;

                },
                "data": function ( d ) {

                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto_presupuestado = '$' + parseFloat(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                        json.data[i].cantidad_presupuestada = parseFloat(json.data[i].cantidad_presupuestada).formatMoney(2, ',', '.');
                        json.data[i].precio_unitario = '$' + parseFloat(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                        json.data[i].filtro9_sub = json.data[i].filtro9.length > 50 ? json.data[i].filtro9.substr(0, 50) + '...' : json.data[i].filtro9;
                    }
                    return json.data;
                }
            },

            "columns" : [
                {data : 'filtro1'},
                {data : 'filtro2'},
                {data : 'filtro3'},
                {data : 'filtro4'},
                {data : 'filtro5'},
                {data : 'filtro6'},
                {data : 'filtro7'},
                {data : 'filtro8'},
                {
                    data : {},
                    render : function (data) {
                        return '<span title="'+data.filtro9+'">'+data.filtro9_sub+'</span>'
                    }
                },
                {data : 'filtro10'},
                {data : 'filtro11'},
                {data : 'unidad'},
                {data : 'cantidad_presupuestada', className : 'text-right'},
                {data : 'precio_unitario', className : 'text-right'},
                {data : 'monto_presupuestado', className : 'text-right'},
                {
                    data : {},
                    render : function (data) {
                        if (self.existe(data.id_concepto)) {
                            return '<button class="btn btn-xs btn-default btn_remove_concepto" id="'+data.id_concepto+'"><i class="fa fa-minus text-red"></i></button>';
                        }
                        return '<button class="btn btn-xs btn-default btn_add_concepto" id="'+data.id_concepto+'"><i class="fa fa-plus text-green"></i></button>';
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
    methods:{
    }
});