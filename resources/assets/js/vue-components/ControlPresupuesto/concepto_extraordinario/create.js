Vue.component('concepto-extraordinario-create', {
    props : ['unidades', 'tipos_extraordinarios', 'tarjetas', 'catalogo', 'id_tipo_orden'],
    data:function () {
        return {
            form:{
                id_origen_extraordinario:'',
                motivo:'',
                area_solicitante:'',
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
                    self.form.extraordinario= data.data;
                    self.mostrar_tabla = true;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },

        validacion_opciones:function () {
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
            var validador = false;
            var id_material = self.material_seleccionado.id_material;
            switch (self.agrupador){
                case 1: ///validar materiales
                    $.each(self.form.extraordinario.MATERIALES.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    if(!validador){
                        self.form.extraordinario.MATERIALES.insumos.push(self.material_seleccionado);
                    }else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'Ya Existe el Insumo Seleccionado'
                        });
                    }
                        break;
                case 2://// agergar a mano obra
                    $.each(self.form.extraordinario.MANOOBRA.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    if(!validador){
                        self.form.extraordinario.MANOOBRA.insumos.push(self.material_seleccionado);
                    }else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'Ya Existe el Insumo Seleccionado'
                        });
                    }

                    break;
                case 4: ////agregar a herram y equipo
                    $.each(self.form.extraordinario.HERRAMIENTAYEQUIPO.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    if(!validador){
                        self.form.extraordinario.HERRAMIENTAYEQUIPO.insumos.push(self.material_seleccionado);
                    }else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'Ya Existe el Insumo Seleccionado'
                        });
                    }
                    break;
                case 8: ///agregar a maquinaria
                    $.each(self.form.extraordinario.MAQUINARIA.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    if(!validador){
                        self.form.extraordinario.MAQUINARIA.insumos.push(self.material_seleccionado);
                    }else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'Ya Existe el Insumo Seleccionado'
                        });
                    }
                    break;
                case 5: ///agregar a subcontratos
                    $.each(self.form.extraordinario.SUBCONTRATOS.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    if(!validador){
                        self.form.extraordinario.SUBCONTRATOS.insumos.push(self.material_seleccionado);
                    }else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'Ya Existe el Insumo Seleccionado'
                        });
                    }
                    break;
                case 6: ///agregar a gastos
                    $.each(self.form.extraordinario.GASTOS.insumos, function (index, insumo) {
                        if(insumo.id_material == id_material){
                            validador =  true;
                        }
                    });
                    if(!validador){
                        self.form.extraordinario.GASTOS.insumos.push(self.material_seleccionado);
                    }else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'Ya Existe el Insumo Seleccionado'
                        });
                    }
                    break;
            }
            $('#add_insumo_modal').modal('hide');
            //return validador;
        }
    }

});