Vue.component('concepto-extraordinario-create', {
    props : ['unidades', 'tipos_extraordinarios', 'tarjetas', 'catalogo', 'id_tipo_orden','url_concepto_get_by', 'conceptos'],
    data:function () {
        return {
            'data': {
                'conceptos' : this.conceptos
            },
            form:{
                path_base:'',
                id_concepto_base:'',
                nivel_base:'',
                tiene_hijos_base:'',
                id_tipo_orden:this.id_tipo_orden,
                id_origen_extraordinario:'',
                id_opcion:'',
                motivo:'',
                area_solicitante:'',
                extraordinario: {}
            },
            tipos_costos:[
                {id:'1', descripcion:'Costo Directo'},
                {id:'2', descripcion:'Costo Indirecto'}
            ],

            cargando:false,
            mostrar_tabla:false,

            agrupador:'',
            tipo_insumo:'',
            guardar: false,
            id_material_seleccionado:'',
            material_seleccionado:[]
        }
    },

    directives: {
        treegrid: {
            inserted: function (el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            },
            componentUpdated: function (el) {
                $(el).treegrid({
                    saveState: true
                });
            }
        }
    },

    computed: {
        conceptos_ordenados: function () {
            return this.data.conceptos.sort(function(a,b) {return (a.nivel > b.nivel) ? 1 : ((b.nivel > a.nivel) ? -1 : 0);} );
        }
    },

    methods: {
        recalcular_insumo:function (id_insumo, agrupador) {
            var self = this;
            var c_presup = 0;
            var p_unitario = 0;
            switch (agrupador){
                case 1: ///agregar a materiales
                    c_presup = $(".c_p_mat_" + id_insumo).val();
                    p_unitario = $(".p_u_mat_" + id_insumo).val();
                    self.form.extraordinario.MATERIALES.insumos[id_insumo].cantidad_presupuestada  = c_presup;
                    self.form.extraordinario.MATERIALES.insumos[id_insumo].precio_unitario  = p_unitario;
                    self.form.extraordinario.MATERIALES.insumos[id_insumo].monto_presupuestado  = p_unitario * c_presup;
                    self.recalcular_agrupadores(self.form.extraordinario.MATERIALES);
                    break;
                case 2://// agergar a mano obra
                    c_presup = $(".c_p_mdo_" + id_insumo).val();
                    p_unitario = $(".p_u_mdo_" + id_insumo).val();
                    self.form.extraordinario.MANOOBRA.insumos[id_insumo].cantidad_presupuestada  = c_presup;
                    self.form.extraordinario.MANOOBRA.insumos[id_insumo].precio_unitario  = p_unitario;
                    self.form.extraordinario.MANOOBRA.insumos[id_insumo].monto_presupuestado  = p_unitario * c_presup;
                    self.recalcular_agrupadores(self.form.extraordinario.MANOOBRA);
                    break;
                case 4: ////agregar a herram y equipo
                    c_presup = $(".c_p_hye_" + id_insumo).val();
                    p_unitario = $(".p_u_hye_" + id_insumo).val();
                    console.log(c_presup , p_unitario );
                    self.form.extraordinario.HERRAMIENTAYEQUIPO.insumos[id_insumo].cantidad_presupuestada  = c_presup;
                    self.form.extraordinario.HERRAMIENTAYEQUIPO.insumos[id_insumo].precio_unitario  = p_unitario;
                    self.form.extraordinario.HERRAMIENTAYEQUIPO.insumos[id_insumo].monto_presupuestado  = p_unitario * c_presup;
                    self.recalcular_agrupadores(self.form.extraordinario.HERRAMIENTAYEQUIPO);
                    break;
                case 8: ///agregar a maquinaria
                    c_presup = $(".c_p_maq_" + id_insumo).val();
                    p_unitario = $(".p_u_maq_" + id_insumo).val();
                    self.form.extraordinario.MAQUINARIA.insumos[id_insumo].cantidad_presupuestada  = c_presup;
                    self.form.extraordinario.MAQUINARIA.insumos[id_insumo].precio_unitario  = p_unitario;
                    self.form.extraordinario.MAQUINARIA.insumos[id_insumo].monto_presupuestado  = p_unitario * c_presup;
                    self.recalcular_agrupadores(self.form.extraordinario.MAQUINARIA);
                    break;
                case 5: ///agregar a subcontratos
                    c_presup = $(".c_p_sub_" + id_insumo).val();
                    p_unitario = $(".p_u_sub_" + id_insumo).val();
                    self.form.extraordinario.SUBCONTRATOS.insumos[id_insumo].cantidad_presupuestada  = c_presup;
                    self.form.extraordinario.SUBCONTRATOS.insumos[id_insumo].precio_unitario  = p_unitario;
                    self.form.extraordinario.SUBCONTRATOS.insumos[id_insumo].monto_presupuestado  = p_unitario * c_presup;
                    self.recalcular_agrupadores(self.form.extraordinario.SUBCONTRATOS);
                    break;
                case 6: ///agregar a gastos
                    c_presup = $(".m_p_gas_" + id_insumo).val();
                    self.form.extraordinario.GASTOS.insumos[id_insumo].cantidad_presupuestada  = c_presup;
                    self.form.extraordinario.GASTOS.insumos[id_insumo].precio_unitario  = 1;
                    self.form.extraordinario.GASTOS.insumos[id_insumo].monto_presupuestado  = c_presup;
                    self.recalcular_gastos(self.form.extraordinario.GASTOS);
                    break;
            }
        },

        recalcular_gastos:function (agrupador) {
            var monto = 0;
            $.each(agrupador.insumos, function (index, partida) {
                monto += parseFloat(partida.monto_presupuestado);
            });
            agrupador.monto_presupuestado = monto;
            this.form.extraordinario.precio_unitario = 0;
            this.form.extraordinario.cantidad_presupuestada = 0;
            this.form.extraordinario.monto_presupuestado = monto;
        },

        recalcular_agrupadores: function (agrupador) {
            var monto = 0;
            var monto_agrupadores = 0;
            $.each(agrupador.insumos, function (index, partida) {
                monto += parseFloat(partida.monto_presupuestado);
            });
            agrupador.monto_presupuestado = monto;
            monto_agrupadores += parseFloat(this.form.extraordinario.MATERIALES.monto_presupuestado);
            monto_agrupadores += parseFloat(this.form.extraordinario.MANOOBRA.monto_presupuestado);
            monto_agrupadores += parseFloat(this.form.extraordinario.HERRAMIENTAYEQUIPO.monto_presupuestado);
            monto_agrupadores += parseFloat(this.form.extraordinario.MAQUINARIA.monto_presupuestado);
            monto_agrupadores += parseFloat(this.form.extraordinario.SUBCONTRATOS.monto_presupuestado);
            monto_agrupadores += parseFloat(this.form.extraordinario.GASTOS.monto_presupuestado);
            this.form.extraordinario.precio_unitario = monto_agrupadores;
            this.recalcular_concepto();
        },

        recalcular_concepto: function () {
            var self = this;
            self.form.extraordinario.monto_presupuestado = parseFloat(self.form.extraordinario.cantidad_presupuestada) * parseFloat(self.form.extraordinario.precio_unitario);
        },

        guardar_extraordinario: function () {
            var self = this;

            $.ajax({
                url : App.host + '/control_presupuesto/conceptos_extraordinarios/store',
                type : 'POST',
                data : self.form,
                beforeSend : function () {
                    self.cargando = true;
                },
                success : function (response) {
                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>',
                        html : 'Solicitud Guardada Exitosamente.'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/conceptos_extraordinarios/' +response.id
                    });
                },
                complete : function () {
                    self.cargando = false;
                }
            })
        },

        getExtraordinario: function () {
            var self = this;
            $.ajax({
                type: 'GET',
                url: App.host + '/control_presupuesto/conceptos_extraordinarios/' + self.form.id_origen_extraordinario + '/extraordinario/' + self.form.id_opcion,
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
                        self.form.id_opcion = '';
                        self.form.id_origen_extraordinario='';
                        self.form.extraordinario = {};
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
                    }
                    break;
            }
            if(validador) {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Ya Existe el Insumo Seleccionado'
                });
            }
            $('#add_insumo_modal').modal('hide');
            //return validador;
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
                    self.guardar_extraordinario();
                }
            });
        },

        confirmacion_ruta: function(concepto){
            var self = this;
            swal({
                title: 'Confirmar Ruta de Extraordinario',
                html: "El Extraordinario se guardará en la siguiente ruta del presupuesto </br>" + concepto.path+ "</br> ¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.form.id_concepto_base = concepto.id_concepto;
                    self.form.nivel_base = concepto.nivel;
                    self.form.path_base = concepto.path;
                    self.form.tiene_hijos_base = concepto.tiene_hijos;
                    $('#seleccion_concepto_modal').modal('hide');

                }
            });
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

        tr_class: function(concepto) {
            var treegrid = "treegrid-" + concepto.id_concepto;
            var treegrid_parent = concepto.id_padre != null && concepto.id_concepto != parseInt($('#id_concepto').val()) ?  " treegrid-parent-" + concepto.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function (concepto) {
            return concepto.id_padre == null || concepto.tiene_hijos > 0 ? "tnode-" + concepto.id_concepto : "";
        },

        get_hijos: function(concepto) {
            var self = this;
            $.ajax({
                type:'GET',
                url: self.url_concepto_get_by,
                data:{
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos,
                    with : 'cuentaConcepto'
                },
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (data, textStatus, xhr) {
                    data.data.conceptos.forEach(function (concepto) {
                        self.data.conceptos.push(concepto);
                    });
                    concepto.cargado = true;
                },
                complete: function() {
                    self.cargando = false;
                    setTimeout(
                        function()
                        {
                            $('#tnode-' + concepto.id_concepto).treegrid('expand');
                        }, 500);
                }
            });
        }

    }
});