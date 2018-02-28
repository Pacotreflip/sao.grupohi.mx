Vue.component('cambio-insumos-create', {
    props : [ 'id_tipo_orden'],
    data : function () {
        return {
            form : {
                partidas : [],
                agrupadas: [],
                insumos_eliminados: [],
                motivo : '',
                area_solicitante:'',
                id_tipo_cobrabilidad : '',
                id_tipo_orden : '',
                id_tarjeta : '',
                filtro : {
                    nivel : '',
                    operador : '',
                    texto : ''
                }

            },
            tipo_insumo:0,
            id_material_seleccionado:0,
            material_seleccionado:[],
            tarjeta_actual: 0,
            cargando : false,
            guardando : false,
            guardar:true,
            filtros : [],
            id_tarjeta : '',
            tarjetas : [],
            bases_afectadas:[],
            niveles: [
                {nombre : 'Nivel 1', numero : 1},
                {nombre : 'Nivel 2', numero : 2},
                {nombre : 'Nivel 3', numero : 3},
                {nombre : 'Sector', numero : 4},
                {nombre : 'Cuadrante', numero : 5},
                {nombre : 'Especialidad', numero : 6},
                {nombre : 'Partida', numero : 7},
                {nombre : 'Sub Partida o Centa de costo', numero : 8},
                {nombre : 'Concepto', numero : 9},
                {nombre : 'Nivel 10', numero : 10},
                {nombre : 'Nivel 11', numero : 11}
            ],
            cargando_tarjetas : true
        }
    },

    computed : {
        datos : function () {
            var res = {
                id_tipo_orden: this.id_tipo_orden,
                motivo: this.form.motivo,
                area_solicitante:this.form.area_solicitante,
                agrupadas: this.form.agrupadas,
                partidas: this.form.partidas,
                insumos_eliminados:this.form.insumos_eliminados
            };
            return res;
        }
    },
    watch : {
        id_tarjeta : function () {
            var self = this;
            if(self.form.partidas.length > 0){
                swal({
                    title: 'Cambiar Tarjeta',
                    text: "Si Cambia de Tarjeta se Descartarán los Conceptos Seleccionados\n¿Desea Cambiar de Tarjeta?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Cambiar',
                    cancelButtonText: 'No, Cancelar'
                }).then((value) =>  {
                    if(value.value) {
                    self.get_conceptos();
                    self.form.partidas = [];
                    self.form.agrupadas = [];
                    self.tarjeta_actual = self.id_tarjeta;
                }else{
                    // setear valor anterior en el select2
                }
            });
            }else {
                self.get_conceptos();
                self.form.partidas = [];
                self.form.agrupadas = [];
                self.tarjeta_actual = self.id_tarjeta;
            }
        }
    },

    mounted: function () {
        var self = this;

        self.fetchTarjetas().then(() => {
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
                        d.filtros = self.filtros;
                        d.id_tarjeta = self.id_tarjeta
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
        });

        self.fetchPresupuestos();

        $(document).on('click', '.btn_add_concepto', function () {
            var id = $(this).attr('id');
            self.addConcepto(id);
        }).on('click', '.btn_remove_concepto', function() {
            var id = $(this).attr('id');
            self.removeConcepto(id);
        });


    },

    methods : {

        fetchTarjetas : function () {
            var self = this;
            return new Promise((resolve, reject) => {
                    $.ajax({
                    url : App.host + '/control_presupuesto/tarjeta/lists',
                    type : 'GET',
                    beforeSend : function () {
                        self.cargando = true;
                    },
                    success : function (response) {
                        self.tarjetas = response;
                    },
                    complete : function () {
                        self.cargando = false;
                        resolve();
                    }
                });
        });
        },

        fetchPresupuestos: function () {
            var self = this;

            var url = App.host + '/control_presupuesto/variacion_volumen/getBasesAfectadas';
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.bases_afectadas = data;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },

        get_conceptos : function () {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        },

        addConcepto : function (id) {
            var self = this;
            $.ajax({
                url : App.host + '/conceptos/' + id + '/getInsumos',
                type : 'GET',
                beforeSend : function () {
                    self.guardando = true;
                    $('#'+id).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#'+id).attr('disabled', true);
                },
                success : function (response) {
                    if(jQuery.isEmptyObject( self.form.partidas)){
                        $.each(response.conceptos.MATERIALES.insumos, function (index, partida) {
                            response.conceptos.MATERIALES.insumos[index].rendimiento_actual =   partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada
                            response.conceptos.MATERIALES.insumos[index].id_elemento =response.conceptos.MATERIALES.insumos[index].id_concepto;
                            response.conceptos.MATERIALES.insumos[index].nuevo=false;
                        });
                        $.each(response.conceptos.HERRAMIENTAYEQUIPO.insumos, function (index, partida) {
                            response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].rendimiento_actual =  partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada
                            response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].id_elemento =response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].id_concepto;
                            response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].nuevo=false;
                        });
                        $.each(response.conceptos.MANOOBRA.insumos, function (index, partida) {
                            response.conceptos.MANOOBRA.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada
                            response.conceptos.MANOOBRA.insumos[index].id_elemento =response.conceptos.MANOOBRA.insumos[index].id_concepto;
                            response.conceptos.MANOOBRA.insumos[index].nuevo=false;
                        });
                        $.each(response.conceptos.MAQUINARIA.insumos, function (index, partida) {
                            response.conceptos.MAQUINARIA.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada
                            response.conceptos.MAQUINARIA.insumos[index].id_elemento =response.conceptos.MAQUINARIA.insumos[index].id_concepto;
                            response.conceptos.MAQUINARIA.insumos[index].nuevo=false;
                        });
                        $.each(response.conceptos.SUBCONTRATOS.insumos, function (index, partida) {
                            response.conceptos.SUBCONTRATOS.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada
                            response.conceptos.SUBCONTRATOS.insumos[index].id_elemento =response.conceptos.SUBCONTRATOS.insumos[index].id_concepto;
                            response.conceptos.SUBCONTRATOS.insumos[index].nuevo=false;
                        });
                        $.each(response.conceptos.GASTOS.insumos, function (index, partida) {
                            response.conceptos.GASTOS.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada
                            response.conceptos.GASTOS.insumos[index].id_elemento =response.conceptos.GASTOS.insumos[index].id_concepto;
                            response.conceptos.GASTOS.insumos[index].nuevo=false;
                        });
                        self.form.partidas.push(response);
                        self.form.agrupadas.push(response.cobrable.id_concepto)
                        $('#'+id).html('<i class="fa fa-minus text-red"></i>');
                        $('#'+id).removeClass('btn_add_concepto');
                        $('#'+id).addClass('btn_remove_concepto');
                    }else{
                        $.each(self.form.partidas, function(index, partida) {
                            var diferencias = false;
                            if(partida.conceptos.MATERIALES.insumos.length === response.conceptos.MATERIALES.insumos.length){
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.MATERIALES.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.MATERIALES.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)){
                                    diferencias = true;
                                }
                            }else{
                                diferencias = true;
                            }
                            if(partida.conceptos.HERRAMIENTAYEQUIPO.insumos.length === response.conceptos.HERRAMIENTAYEQUIPO.insumos.length){
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.HERRAMIENTAYEQUIPO.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.HERRAMIENTAYEQUIPO.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)){
                                    diferencias = true;
                                }
                            }else{
                                diferencias = true;
                            }
                            if(partida.conceptos.MANOOBRA.insumos.length === response.conceptos.MANOOBRA.insumos.length){
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.MANOOBRA.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.MANOOBRA.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)){
                                    diferencias = true;
                                }
                            }else{
                                diferencias = true;
                            }
                            if(partida.conceptos.MAQUINARIA.insumos.length === response.conceptos.MAQUINARIA.insumos.length){
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.MAQUINARIA.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.MAQUINARIA.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)){
                                    diferencias = true;
                                }
                            }else{
                                diferencias = true;
                            }

                            if(partida.conceptos.SUBCONTRATOS.insumos.length === response.conceptos.SUBCONTRATOS.insumos.length){
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.SUBCONTRATOS.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.SUBCONTRATOS.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)){
                                    diferencias = true;
                                }
                            }else{
                                diferencias = true;
                            }

                            if(partida.conceptos.GASTOS.insumos.length === response.conceptos.GASTOS.insumos.length){
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.GASTOS.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.GASTOS.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)){
                                    diferencias = true;
                                }
                            }else{
                                diferencias = true;
                            }

                            self.cargando = false;
                            if(diferencias){
                                $('#'+id).html('<i class="fa fa-plus text-green"></i>');
                                swal({
                                    type: 'warning',
                                    title: 'Advertencia',
                                    text: 'CONCEPTOS NO AGRUPABLES'
                                });
                            }else{
                                self.form.agrupadas.push(response.cobrable.id_concepto)
                                $('#'+id).html('<i class="fa fa-minus text-red"></i>');
                                $('#'+id).removeClass('btn_add_concepto');
                                $('#'+id).addClass('btn_remove_concepto');
                            }

                        });
                    }

                },
                complete : function () {
                    self.guardando = false;
                    $('#'+id).attr('disabled', false);
                },
                error: function () {
                    $('#'+id).html('<i class="fa fa-plus text-green"></i>');
                }
            });
        },

        existe : function (id) {
            var found = this.form.partidas.find(function (partida) {
                return partida.id_concepto == id;
            });
            return found != undefined;
        },

        confirmSave: function () {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.save();
                }
            });
        },

        save : function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/cambio_insumos',
                type : 'POST',
                data : self.datos,
                beforeSend : function () {
                    self.cargando = true;
                },
                success : function (response) {

                    var lista = [];

                    // Ya existen solicitudes con las partidas seleccionadas
                    if (typeof response.repetidas != 'undefined') {

                        $.each(response.repetidas, function( key, value ) {
                            lista.push('<li class="list-group-item "><a href="'+ App.host + '/control_presupuesto/cambio_presupuesto" onclick="swal.close();">#'+ value.solicitud.numero_folio +' ' + (value.solicitud.motivo.length >= 20 ? (value.solicitud.motivo.substring(0, 30) + '...') : value.solicitud.motivo) + '</a></li>');
                        });

                        var texto = response.repetidas.length > 1 ? 'Ya existen solicitudes' : 'Ya existe una solicitud';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') +'</ul>',
                            type: "warning",
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });

                        return;
                    }

                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        //html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                        html : 'Solicitud Guardada Exitosamente.'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/cambio_insumos/' +response.id

                    });
                },
                complete : function () {
                    self.cargando = false;
                }
            })
        },

        removeConcepto : function (id) {
            //var index = this.form.agrupadas.map(function (partida) { return partida.id_concepto; }).indexOf(parseInt(id));
            var self = this;
            var ag = self.form.agrupadas;
            var index = ag.indexOf(parseInt(id));

            this.form.agrupadas.splice(index, 1);
            $('#'+id).html('<i class="fa fa-plus text-green"></i>');
            $('#'+id).addClass('btn_add_concepto');
            $('#'+id).removeClass('btn_remove_concepto');
            if(!this.form.agrupadas.length) {
                this.form.partidas = [];
                $('#conceptos_modal').modal('hide');
            }
        },

        addInsumoTipo: function (tipo) {
            var self = this;

            if(tipo==5||tipo==6){
                tipo=2;
            }

            self.guardar = true;
            $('#sel_material').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/control_presupuesto/cambio_presupuesto/getDescripcionByTipo',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            descripcion:  params.term,
                            tipo:tipo
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data.materiales, function (item) {

                                return {
                                    text: item.DescripcionPadre+" -> "+item.descripcion,
                                    descripcion: item.descripcion,
                                    id_material: item.id_material,
                                    unidad:item.unidad,
                                    cantidad_presupuestada:0,
                                    variacion_cantidad_presupuestada:0,
                                    cantidad_presupuestada_nueva:0,
                                    variacion_precio_unitario:0,
                                    precio_unitario:0,
                                    id:item.id_material,
                                    nuevo:true,
                                    rendimiento_actual:0
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
                self.guardar = false;
                data.id_elemento=data.id_material;
                self.material_seleccionado=data;
            });
            $('#add_insumo_modal').modal('show');
        },

        cancelar_add_insumo: function () {
            $('#add_insumo_modal').modal('hide');

            $('#insumos_modal').modal('show');
            $('#insumos_modal').focus()
        },

        agregar_insumo_nuevo: function () {
            var self = this;
            $.each(self.form.partidas, function( index, partida ) {
                switch (self.tipo_insumo){
                    case 1: ///agregar a materiales
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)){
                            partida.conceptos.MATERIALES.insumos.push(self.material_seleccionado);
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 2://// agergar a mano obra
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)){
                            partida.conceptos.MANOOBRA.insumos.push(self.material_seleccionado);
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 4: ////agregar a herram y equipo
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)){
                            partida.conceptos.HERRAMIENTAYEQUIPO.insumos.push(self.material_seleccionado);
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 8: ///agregar a maquinaria
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)){
                            partida.conceptos.MAQUINARIA.insumos.push(self.material_seleccionado);
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 5: ///agregar a maquinaria
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)){
                            partida.conceptos.SUBCONTRATOS.insumos.push(self.material_seleccionado);
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 6: ///agregar a maquinaria
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)){
                            partida.conceptos.GASTOS.insumos.push(self.material_seleccionado);
                        }else{
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;

                }
            });

            $('#add_insumo_modal').modal('hide');
        },

        validarInsumo: function (id_material, agrupador) {
            var self = this;
            var validador = false;
            switch (agrupador){
                case 1: ///validar materiales
                    $.each(self.form.partidas[0].conceptos.MATERIALES.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    break;
                case 2://// agergar a mano obra
                    $.each(self.form.partidas[0].conceptos.MANOOBRA.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    break;
                case 4: ////agregar a herram y equipo
                    $.each(self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    break;
                case 8: ///agregar a maquinaria
                    $.each(self.form.partidas[0].conceptos.MAQUINARIA.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    break;
                case 5: ///agregar a maquinaria
                    $.each(self.form.partidas[0].conceptos.SUBCONTRATOS.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    break;
                case 6: ///agregar a maquinaria
                    $.each(self.form.partidas[0].conceptos.GASTOS.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    break;

            }
            return validador;
        },

        removeRendimiento : function (id_concepto, id, tipo) {
            var self = this;
            var index = self.form.insumos_eliminados.indexOf(parseInt(id_concepto));
            if(index > -1){

                console.log('entro' + index + ' ' +typeof index);
                self.form.insumos_eliminados.splice(index, 1);
                $("#c_p_"+ id_concepto+ '_' + id).prop('disabled', false);
                $("#m_p_"+ id_concepto+ '_' + id).prop('disabled', false);
                $("#r_p_"+ id_concepto+ '_' + id).prop('disabled', false);

            }else {
                console.log('salio');
                $("#c_p_" + id_concepto + '_' + id).prop('disabled', true);
                $("#m_p_" + id_concepto + '_' + id).prop('disabled', true);
                $("#r_p_" + id_concepto + '_' + id).prop('disabled', true);
                switch (tipo) {
                    case 1: ///agregar a materiales
                        if (self.form.partidas[0].conceptos.MATERIALES.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.MATERIALES.insumos.splice(id, 1);
                        }else{
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }

                        break;
                    case 2://// agergar a mano obra
                        if (self.form.partidas[0].conceptos.MANOOBRA.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.MANOOBRA.insumos.splice(id, 1);
                        }else{
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                        break;
                    case 4: ////agregar a herram y equipo
                        if (self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos.splice(id, 1);
                        }else{
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                        break;
                    case 8: ///agregar a maquinaria
                        if (self.form.partidas[0].conceptos.MAQUINARIA.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.MAQUINARIA.insumos.splice(id, 1);
                        }else{
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                    case 5: ///agregar a maquinaria
                        if (self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.SUBCONTRATOS.insumos.splice(id, 1);
                        }else{
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                        break;
                }
            }
            this.recalcular(id_concepto, id);
        },

        insumoEliminado : function (id_concepto) {
            return this.form.insumos_eliminados.indexOf(parseInt(id_concepto)) ? true:false;
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_solicitud') {
                this.confirmSave();
            }
            if(funcion == 'add_filtro') {
                this.set_filtro();
            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },

        recalcular : function (id_concepto,i,tipo) {
            var self = this;
            var cant_pres = $(".rendimiento" +id_concepto+'_'  + i).val();
            var cant_concepto = self.form.partidas[0].cobrable.cantidad_presupuestada;
            switch (tipo){
                case 1: ///agregar a materiales

                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo;
                    $("#r_p_" +id_concepto+'_'  + i).val(total);
                    break;
                case 2://// agergar a mano obra
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo;
                    $("#r_p_" +id_concepto+'_'  + i).val(total);
                    break;
                case 4: ////agregar a herram y equipo
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo;
                    $("#r_p_" +id_concepto+'_'  + i).val(total);
                    break;
                case 8: ///agregar a maquinaria
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo;
                    $("#r_p_" +id_concepto+'_'  + i).val(total);
                    break;
                case 5: ///agregar a subcontratos
                    self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].rendimiento_nuevo;
                    $("#r_p_" +id_concepto+'_'  + i).val(total);
                    break;
                case 6: ///agregar a gastos
                    self.form.partidas[0].conceptos.GASTOS.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.GASTOS.insumos[i].rendimiento_nuevo;
                    $("#r_p_" +id_concepto+'_'  + i).val(total);
                    break;
            }
        },

        recalcular_monto : function (id_concepto, i,tipo) {
            var self = this;
            var cant = $(".pre_unit" +id_concepto+'_'  + i).val();
            switch (tipo){
                case 1: ///agregar a materiales
                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 2://// agergar a mano obra
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].precio_unitario_nuevo = cant;

                    break;
                case 4: ////agregar a herram y equipo
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].precio_unitario_nuevo =cant;
                    break;
                case 8: ///agregar a maquinaria
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 5: ///agregar a subcontratos
                    self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 6: ///agregar a gastos
                    self.form.partidas[0].conceptos.GASTOS.insumos[i].precio_unitario_nuevo = cant;
                    break;
            }
        },

        recalcular_cantidad : function (id_concepto, i,tipo) {
            var self = this;
            var cant_pres = $("#r_p_" +id_concepto+'_'  + i).val();
            var cant_concepto = self.form.partidas[0].cobrable.cantidad_presupuestada;
            switch (tipo){
                case 1: ///agregar a materiales
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" +id_concepto+'_'  + i).val(total);
                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo = total;
                    break;
                case 2://// agergar a mano obra
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" +id_concepto+'_'  + i).val(total);
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo = total;

                    break;
                case 4: ////agregar a herram y equipo
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" +id_concepto+'_'  + i).val(total);
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo =total;
                    break;
                case 8: ///agregar a maquinaria
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" +id_concepto+'_'  + i).val(total);
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo = total;
                    break;
                case 5: ///agregar a SUNCONTRATOS
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" +id_concepto+'_'  + i).val(total);
                    self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].rendimiento_nuevo = total;
                    break;
                case 6: ///agregar a maquinaria
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" +id_concepto+'_'  + i).val(total);
                    self.form.partidas[0].conceptos.GASTOS.insumos[i].rendimiento_nuevo = total;
                    break;
            }
        },

        set_filtro : function() {
            var nivel = this.form.filtro.nivel;
            var result = this.filtros.filter(function( filtro ) {
                return filtro.nivel == nivel;
            });

            if(result.length) {
                result[0].operadores.push(
                    {
                        sql : this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                        operador : this.operadores[this.form.filtro.operador],
                        texto : this.form.filtro.texto
                    });
            } else {
                this.filtros.push({
                    nivel : this.form.filtro.nivel,
                    operadores : [
                        {
                            sql : this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                            operador : this.operadores[this.form.filtro.operador],
                            texto : this.form.filtro.texto
                        }
                    ]
                });
            }

            this.close_modal();
        },

        close_modal : function() {
            $('#agregar_filtro_modal').modal('hide');
            Vue.set(this.form, 'filtro', {nivel : '', operador : '', texto : ''});
        },

        eliminar: function (filtro, operador) {
            Vue.delete(filtro.operadores, filtro.operadores.indexOf(operador));
            if(!filtro.operadores.length) {
                Vue.delete(this.filtros, this.filtros.indexOf(filtro));
            }
        },

        obtenerPresupuestos: function () {
            var self = this;

            var tipoOrden = self.form.id_tipo_orden;

            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/afectacion_presupuesto/getBasesAfectadas';
            $.ajax({
                type: 'POST',
                data:{
                    tipo_orden:tipoOrden
                },
                url: url,
                beforeSend: function () {
                    self.consultando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.bases_afectadas=data.data;
                },
                complete: function () {
                    self.consultando = false;

                }
            });


    }
    }
});