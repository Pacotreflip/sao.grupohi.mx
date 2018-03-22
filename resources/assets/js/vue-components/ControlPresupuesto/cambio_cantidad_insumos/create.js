Vue.component('cambio-cantidad-insumos-create', {
    props:['id_tipo_orden','tipo_filtro'],
    data: function () {
        return {
            form: {
                filtro_agrupador:{
                    id_tipo_filtro:0,
                    id_material:0

                },
                precios_disponibles:[],
                precios_seleccionados:[],
                agrupacion:[]


            },
            cargando:false

        }
    },

    computed: {},

    mounted: function () {



          $('.details-control').html('<h1>uno</h1>');
            $('.shown .details-control').html('<h1>dos</h1>');


        var self=this;
        $('#sel_material').select2({
            width: '100%',
            ajax: {
                url: App.host + '/material/getInsumos',
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        attribute:'descripcion',
                        operator:'like',
                        value:'%'+params.term+'%'

                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data.materiales, function (item) {
                            return {
                                text:item.descripcion,
                                descripcion: item.descripcion,
                                id: item.id_material

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
            self.form.filtro_agrupador.id_material=data.id;
            self.form.precios_disponibles=[];
            self.form.precios_seleccionados=[];
            self.consulta_precios_material();
        });
    },

    methods: {

        consulta_detalle_agrupador:function(){
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                '<td>Full name:</td>'+
                '<td>a</td>'+
                '</tr>'+
                '<tr>'+
                '<td>Extension number:</td>'+
                '<td>a</td>'+
                '</tr>'+
                '<tr>'+
                '<td>Extra info:</td>'+
                '<td>And any further details here (images etc)...</td>'+
                '</tr>'+
                '</table>';
        }
        ,

        buscar_conceptos:function () {
            var self=this;

            var table = $('#agrupadores_table').DataTable({
                "processing": true,
                "serverSide": true,
                "paging" : false,
                "ordering" : false,
                "searching" : false,
                "destroy": true,
                "ajax": {
                    "url": App.host + '/control_presupuesto/cambio_cantidad_insumos/getAgrupacionFiltro',
                    "type" : "POST",
                    "beforeSend" : function () {
                        self.cargando = true;
                    },
                    "data": function ( d ) {
                         d.filtro_agrupado=self.form.filtro_agrupador;
                         d.precios=self.form.precios_seleccionados;

                    },
                    "complete" : function () {
                        self.cargando = false;
                    },
                    "dataSrc" : function (json) {
                        for (var i = 0; i < json.data.length; i++) {
                            json.data[i].agrupador =json.data[i].agrupador;
                            json.data[i].precio = '$' + parseFloat(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                            json.data[i].cantidad = json.data[i].cantidad;
                            json.data[i].index=i;

                        }
                        return json.data;
                    }
                },
                "columns" : [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '',
                        render : function (data) {

                             return '<button class="btn btn-xs btn-default btn_expandir" id="'+data.index+'"><i class="fa fa-plus text-green"></i></button>';

                        }
                    },
                    {data : 'agrupador'},
                    {data : 'precio'},
                    {data : 'cantidad'},
                                       {
                        data : {},
                        render : function (data) {

                            return '<input type="checkbox">';
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

            $('#agrupadores_table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                 alert(row.index());
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( self.consulta_detalle_agrupador(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        },
        consulta_precios_material:function () {
            var self=this;
            $.ajax({
                type:'GET',
                url: App.host + '/conceptos/'+self.form.filtro_agrupador.id_material+'/getPreciosConceptos',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                 if(data.data.precios.length>0){
                     if(data.data.precios.length==1){
                         self.form.precios_seleccionados=data.data.precios;
                     }else{
                         self.form.precios_disponibles=data.data.precios;
                         $('#lista_precios_modal').modal("show");

                     }

                 }else{
                     swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'No se encontro ningun precio para el material seleccionado.'
                     });
                 }
                },
                complete: function() {

                }
            });
        },
        selecciona_all_precios:function () {
            var self=this;
            if( $('#select_all_price').prop('checked') ) {
                self.form.precios_seleccionados=self.form.precios_disponibles;
            }else{
                self.form.precios_seleccionados=[];
            }
        },
        valida_seleccion_all:function () {
            var self=this;
            if( self.form.precios_seleccionados.length==self.form.precios_disponibles.length){
                $('#select_all_price').prop('checked',true);
            }else{
                $('#select_all_price').prop('checked',false);
            }
        }
    }
});