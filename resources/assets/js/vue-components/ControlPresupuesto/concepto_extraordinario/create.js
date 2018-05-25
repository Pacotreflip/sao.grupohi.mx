Vue.component('concepto-extraordinario-create', {
    props : ['unidades', 'tipos_extraordinarios', 'tarjetas', 'catalogo', 'id_tipo_orden'],
    data:function () {
        return {
            form:{
                id_origen_extraordinario:'',

                extraordinario: {}
            },
            tipos_costos:[
                {id:'1', descripcion:'Costo Directo'},
                {id:'2', descripcion:'Costo Indirecto'}
            ],
            id_opcion:'',
            cargando:false,
            mostrar_tabla:false,

            agrupador:'',
            tipo_insumo:'',
            guardar: false,
            id_material_seleccionado:'',
            material_seleccionado:[]
        }
    },

    watch : {
        id_opcion : function () {
            this.validacion_opciones(2);
        }
    },
    methods: {
        getExtraordinario: function () {
            var self = this;
            $.ajax({
                type: 'GET',
                url: App.host + '/control_presupuesto/conceptos_extraordinarios/' + self.form.id_origen_extraordinario + '/extraordinario/' + self.id_opcion,
                beforeSend: function () {
                    self.cargando = true;
                    self.mostrar_tabla = false;
                },
                success: function (data, textStatus, xhr) {
                    if (self.form.id_origen_extraordinario == 1) {
                        self.rendimiento_tarjeta(data.data)
                    } else {
                        console.log(self.form.id_origen_extraordinario);
                        self.reformato_rendimientos(data.data);
                    }
                },
                complete: function () {
                    self.cargando = false;
                    self.mostrar_tabla = true;
                }
            });
        },

        rendimiento_tarjeta:function (data) {
            var self = this;
            $.each(data.MATERIALES.insumos, function (index, partida) {
                data.MATERIALES.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.MATERIALES.insumos[index].monto_presupuestado =   partida.precio_unitario * data.MATERIALES.insumos[index].cantidad_presupuestada;
            });
            $.each(data.MANOOBRA.insumos, function (index, partida) {
                data.MANOOBRA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.MANOOBRA.insumos[index].monto_presupuestado =   partida.precio_unitario * data.MANOOBRA.insumos[index].cantidad_presupuestada;
            });
            $.each(data.HERRAMIENTAYEQUIPO.insumos, function (index, partida) {
                data.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.HERRAMIENTAYEQUIPO.insumos[index].monto_presupuestado =   partida.precio_unitario * data.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada;
            });
            $.each(data.MAQUINARIA.insumos, function (index, partida) {
                data.MAQUINARIA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.MAQUINARIA.insumos[index].monto_presupuestado =   partida.precio_unitario * data.MAQUINARIA.insumos[index].cantidad_presupuestada;
            });
            $.each(data.SUBCONTRATOS.insumos, function (index, partida) {
                data.SUBCONTRATOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.SUBCONTRATOS.insumos[index].monto_presupuestado =   partida.precio_unitario * data.SUBCONTRATOS.insumos[index].cantidad_presupuestada;
            });
            $.each(data.GASTOS.insumos, function (index, partida) {
                data.GASTOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada / data.cantidad_presupuestada).formatMoney(6,'.','');
                data.GASTOS.insumos[index].monto_presupuestado =   partida.precio_unitario * data.GASTOS.insumos[index].cantidad_presupuestada;
            });
            self.form.extraordinario = data;
        },

        reformato_rendimientos:function (data) {
            var self = this;
            $.each(data.MATERIALES.insumos, function (index, partida) {
                data.MATERIALES.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.MANOOBRA.insumos, function (index, partida) {
                data.MANOOBRA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.HERRAMIENTAYEQUIPO.insumos, function (index, partida) {
                data.HERRAMIENTAYEQUIPO.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.MAQUINARIA.insumos, function (index, partida) {
                data.MAQUINARIA.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.',',');
            });
            $.each(data.SUBCONTRATOS.insumos, function (index, partida) {
                data.SUBCONTRATOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            $.each(data.GASTOS.insumos, function (index, partida) {
                data.GASTOS.insumos[index].cantidad_presupuestada =   parseFloat(partida.cantidad_presupuestada).formatMoney(6,'.','');
            });
            self.form.extraordinario = data;
        },

        validacion_opciones:function (tipo) {
            var self = this;
            if(self.mostrar_tabla){
                swal({
                    title: 'Cambiar Opciones',
                    text: "¿Desea cambiar de extraordinario, puede perder la información modificada?",
                    type: 'warning',
                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Cambiar',
                    cancelButtonText: 'No, Cancelar'
                }).then(function(result) {
                    if(result.value){
                        self.id_opcion = '';
                        self.form.id_origen_extraordinario='';
                        self.mostrar_tabla = false;
                    }
                });
            }
        },

        addInsumoTipo: function (tipo) {
            var self = this;

            self.agrupador = tipo;

            if(tipo==5||tipo==6){
                tipo=2;
            }
            self.tipo_insumo=tipo;

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
                                    text: item.DescripcionPadre+" -> ["+item.numero_parte+"] "+item.descripcion,
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

        agregar_insumo_nuevo: function () {
            var self = this;
            $.each(self.form.partidas, function( index, partida ) {
                switch (self.agrupador){
                    case 1: ///agregar a materiales
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.agrupador)){
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
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.agrupador)){
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
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.agrupador)){
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
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.agrupador)){
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
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.agrupador)){
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
                        if(!self.validarInsumo(self.material_seleccionado.id_material, self.agrupador)){
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
        }

    }
});