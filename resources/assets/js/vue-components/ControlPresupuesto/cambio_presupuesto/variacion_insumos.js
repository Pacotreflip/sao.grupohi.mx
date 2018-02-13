Vue.component('variacion-insumos', {
    props : ['filtros', 'niveles', 'id_tipo_orden', 'id_tarjeta','tarjetas'],
    data : function () {
        return {
            form : {
                partidas : [],
                agrupadas: [],
                motivo : ''
            },
            tipo_insumo:0,
            id_material_seleccionado:0,
            material_seleccionado:[],
            cargando : false,
            guardando : false
        }
    },

    computed : {
        datos : function () {
            var res = {
                id_tipo_orden: this.id_tipo_orden,
                motivo: this.form.motivo,
                agrupadas: this.form.agrupadas,
                partidas: this.form.partidas
            };
            return res;
        }
    },
    watch : {
        id_tarjeta : function () {
            this.get_conceptos();
            this.form.partidas = []
        }
    },

    mounted: function () {
        var self = this;

        $('#tarjetas_select').on('select2:select', function () {
            self.get_conceptos();
        });

        $(document).on('click', '.btn_add_concepto', function () {
            var id = $(this).attr('id');
            self.addConcepto(id);
        }).on('click', '.btn_remove_concepto', function() {
            var id = $(this).attr('id');
            self.removeConcepto(id);
        });

        $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
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
                        json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                        json.data[i].cantidad_presupuestada = parseInt(json.data[i].cantidad_presupuestada).formatMoney(2, ',', '.');
                        json.data[i].precio_unitario = '$' + parseInt(json.data[i].precio_unitario).formatMoney(2, ',', '.');
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
                        return '<span title="'+data.filtro9+'">'+data.filtro9.substr(0, 55)+'</span>'
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

    methods : {
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
                        self.form.partidas.push(response);
                        self.form.agrupadas.push(response.cobrable.id_concepto)
                    }else{
                        $.each(self.form.partidas, function(index, partida) {
                            if(partida.conceptos.MATERIALES.insumos.length === response.conceptos.MATERIALES.insumos.length){
                                $.each(partida.conceptos.MATERIALES.insumos, function (index, insumo) {
                                    var temp1 = Math.round(insumo.rendimiento_actual)
                                    var temp2 = Math.round(response.conceptos.MATERIALES.insumos[index].cantidad_presupuestada / response.cobrable.cantidad_presupuestada)
                                    if(temp1 != temp2){
                                        alert('MATERIALES diferente' + temp1 + ' - ' + temp2);
                                    }
                                });
                            }else{
                                alert('Concepto Diferente');
                            }
                            if(partida.conceptos.HERRAMIENTAYEQUIPO.insumos.length === response.conceptos.HERRAMIENTAYEQUIPO.insumos.length){
                                $.each(partida.conceptos.HERRAMIENTAYEQUIPO.insumos, function (index, insumo) {
                                    var temp1 = Math.round(insumo.rendimiento_actual )
                                    var temp2 = Math.round(response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada / response.cobrable.cantidad_presupuestada)
                                    if(temp1 != temp2){
                                        alert('HERRAMIENTAYEQUIPO diferente' + temp1 + ' - ' + temp2);
                                    }
                                });
                                //alert(partida.conceptos.HERRAMIENTAYEQUIPO.insumos.length);
                            }else{
                                alert('HERRAMIENTAYEQUIPO Diferente');
                            }
                            if(partida.conceptos.MANOOBRA.insumos.length === response.conceptos.MANOOBRA.insumos.length){
                                $.each(partida.conceptos.MANOOBRA.insumos, function (index, insumo) {
                                    var temp1 = Math.round(insumo.rendimiento_actual)
                                    var temp2 = Math.round(response.conceptos.MANOOBRA.insumos[index].cantidad_presupuestada / response.cobrable.cantidad_presupuestada)
                                    if(temp1 != temp2){
                                        alert('MANOOBRA diferente' + temp1 + ' - ' + temp2);
                                    }
                                });
                                //alert(partida.conceptos.MANOOBRA.insumos.length);
                            }else{
                                alert('MANOOBRA Diferente');
                            }
                            if(partida.conceptos.MAQUINARIA.insumos.length === response.conceptos.MAQUINARIA.insumos.length){
                                $.each(partida.conceptos.MAQUINARIA.insumos, function (index, insumo) {
                                    var temp1 = Math.round(insumo.rendimiento_actual)
                                    var temp2 = Math.round(response.conceptos.MAQUINARIA.insumos[index].cantidad_presupuestada / response.cobrable.cantidad_presupuestada)
                                    if(temp1 != temp2){
                                        alert('MAQUINARIA diferente' + temp1 + ' - ' + temp2);
                                    }
                                });
                                //alert(partida.conceptos.MAQUINARIA.insumos.length);
                            }else{
                                alert('MAQUINARIA Diferente');
                            }
                            self.form.agrupadas.push(response.cobrable.id_concepto)

                        });
                    }

                    $('#'+id).html('<i class="fa fa-minus text-red"></i>');
                    $('#'+id).removeClass('btn_add_concepto');
                    $('#'+id).addClass('btn_remove_concepto');
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
                url : App.host + '/control_presupuesto/cambio_presupuesto',
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
                        $('#conceptos_modal').modal('hide');
                        $('#insumos_modal').modal('hide');
                        self.form.partidas = [];
                        self.$emit('reset-filtros');
                        Vue.set(self.form, 'motivo', '');
                        $('#conceptos_table').DataTable().ajax.reload();

                    });
                },
                complete : function () {
                    self.cargando = false;
                }
            })
        },

        removeConcepto : function (id) {
            //var index = this.form.agrupadas.map(function (partida) { return partida.id_concepto; }).indexOf(parseInt(id));
            var index = this.form.agrupadas.indexOf(id);
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
            self.tipo_insumo=tipo;
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
                data.id_elemento=data.id_material;
               // console.log(data);
                self.material_seleccionado=data;
            });
            $('#add_insumo_modal').modal('show');
        }
        ,
        cancelar_add_insumo: function () {
            $('#add_insumo_modal').modal('hide');
        },
        agregar_insumo_nuevo: function () {
            var self = this;
            $.each(self.form.partidas, function( index, partida ) {
                switch (self.tipo_insumo){
                    case 1: ///agregar a materiales
                        partida.conceptos.MATERIALES.insumos.push(self.material_seleccionado);
                        break;
                    case 2://// agergar a mano obra
                        partida.conceptos.MANOOBRA.insumos.push(self.material_seleccionado);
                        break;
                    case 4: ////agregar a herram y equipo
                        partida.conceptos.HERRAMIENTAYEQUIPO.insumos.push(self.material_seleccionado);
                        break;
                    case 8: ///agregar a maquinaria
                        partida.conceptos.MAQUINARIA.insumos.push(self.material_seleccionado);
                        break;

                }
            });

            $('#add_insumo_modal').modal('hide');
        }
        ,

        removeRendimiento : function (id_concepto, id, tipo) {
            var self = this;
            var valor = 0.0;
            $("#c_p_"+ id_concepto+ '_' + id).val(valor).prop('disabled', true);
            $("#m_p_"+ id_concepto+ '_' + id).prop('disabled', true);
            switch (tipo){
                case 1: ///agregar a materiales
                    self.form.partidas[0].conceptos.MATERIALES.insumos[id].rendimiento_nuevo = valor;
                    break;
                case 2://// agergar a mano obra
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[id].rendimiento_nuevo = valor;
                    break;
                case 4: ////agregar a herram y equipo
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[id].rendimiento_nuevo = valor;
                    break;
                case 8: ///agregar a maquinaria
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[id].rendimiento_nuevo = valor;
                    break;
            }
            this.recalcular(id_concepto, id);
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_solicitud') {
                this.confirmSave();
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
            var cant_pres = $("#c_p_" +id_concepto+'_' + i).val();
            switch (tipo){
                case 1: ///agregar a materiales
                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo = cant_pres;
                    break;
                case 2://// agergar a mano obra
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo = cant_pres;
                    break;
                case 4: ////agregar a herram y equipo
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo = cant_pres;
                    break;
                case 8: ///agregar a maquinaria
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo = cant_pres;
                    break;
            }
        },

        recalcular_monto : function (id_concepto, i,tipo) {
            var self = this;
            var cant = $("#m_p_" +id_concepto+'_'  + i).val();
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
            }
        }
    }
});