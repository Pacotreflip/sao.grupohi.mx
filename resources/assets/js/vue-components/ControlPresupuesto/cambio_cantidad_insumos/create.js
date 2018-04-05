Vue.component('cambio-cantidad-insumos-create', {
    props: ['id_tipo_orden', 'tipo_filtro'],
    data: function () {
        return {
            form: {
                filtro_agrupador: {
                    id_tipo_filtro: 0,
                    id_material: 0
                },
                precios_disponibles: [],
                precios_seleccionados: [],
                id_tipo_orden:this.id_tipo_orden,
                agrupacion: []

            },
            descripcion_agrupados:'',
            cargando: false,
            consultando:false,
            guardando:false,
            row_consulta:'',
            buscando_agrupados:false,
            consultando_precio:false
        }
    },
    computed: {},
    mounted: function () {
        var self = this;


        $('#sel_material').select2({
            width: '100%',
            ajax: {
                url: App.host + '/material/getInsumosConceptos',
                dataType: 'json',
                delay: 500,
                data: function (params) {
                    return {
                        attribute: 'descripcion',
                        operator: 'like',
                        value: '%' + params.term + '%'

                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data.materiales, function (item) {
                            return {
                                text: item.descripcion,
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
            self.form.filtro_agrupador.id_material = data.id;
            self.form.precios_disponibles = [];
            self.form.agrupacion = [];
            self.form.precios_seleccionados = [];
            self.consulta_precios_material();
        });
    },
    methods: {
        cambiaPrecios:function (indexRow) {
            var self = this;
            if(self.form.agrupacion[indexRow].aplicar_todos){
                $.each( self.form.agrupacion[indexRow].items,function (index,value) {
                    if(value.agregado) {
                        value.cantidad_nueva = self.form.agrupacion[indexRow].cantidad_todos;
                    }
                });

            }
        },
        consulta_detalle_agrupador: function (indexRow) {

            var self = this;
            if(self.form.agrupacion[indexRow].items.length==0){

                self.row_consulta=indexRow;
                $.ajax({
                    type: 'POST',
                    async: true,
                    url: App.host + '/control_presupuesto/cambio_cantidad_insumos/getExplosionAgrupados',
                    data: {
                        filtro_agrupado: self.form.filtro_agrupador,
                        precio: self.form.agrupacion[indexRow].precio_unitario,
                        descripcion: self.form.agrupacion[indexRow].agrupador
                    },
                    beforeSend: function () {
                        self.consultando = true;
                    },
                    success: function (data, textStatus, xhr) {
                        self.form.agrupacion[indexRow].items=data.data;
                        self.form.agrupacion[indexRow].expandido=true;
                        self.form.agrupacion[indexRow].mostrar_detalle=true;
                        if(self.form.agrupacion[indexRow].aplicar_todos){
                            $.each( self.form.agrupacion[indexRow].items,function (index,value) {
                                value.agregado=true;
                                value.cantidad_nueva=self.form.agrupacion[indexRow].cantidad_todos;
                            });

                        }
                        self.consultando=false;
                    },
                    complete: function () {
                        self.consultando=false;
                    },

                });

            }else{

                if(self.form.agrupacion[indexRow].expandido==true){
                    self.form.agrupacion[indexRow].expandido=false;
                    $('#tr_detalle_'+indexRow).hide();
                }else{
                    self.form.agrupacion[indexRow].expandido=true;
                    $('#tr_detalle_'+indexRow).show();
                }
            }


        },
        ocultar_detalle:function (indexRow) {
            $('#tr_detalle_'+indexRow).hide();
            this.form.agrupacion[indexRow].mostrar_detalle=false;
        },
        mostrar_detalle:function (indexRow) {
            $('#tr_detalle_'+indexRow).show();
            this.form.agrupacion[indexRow].mostrar_detalle=true;
        },
        selecciona_rows:function (indexRow) {
            var self = this;


            var seleccionado = $('#checksSel' + indexRow).prop('checked');

            $.each(self.form.agrupacion[indexRow].items, function (index, value) {
                    value.agregado = seleccionado;
                    value.cantidad_nueva = self.form.agrupacion[indexRow].cantidad_todos;

            });

        },
        cambio_texto_filtro:function (str) {
            var self = this;
            self.descripcion_agrupados=str;
            self.form.agrupacion =[];
        },
        quitar_row:function (indexRow) {
            var self=this;
            var total_rows=self.form.agrupacion[indexRow].items.length;
            var agregados=0;
            $.each(self.form.agrupacion[indexRow].items,function (index,value) {
              value.agregado?agregados++:'';
            });
            total_rows==agregados?  self.form.agrupacion[indexRow].aplicar_todos=true:self.form.agrupacion[indexRow].aplicar_todos=false;

        },
        buscar_conceptos: function () {
            var self = this;
            self.form.agrupacion =[];
            $.ajax({
                url: App.host + '/control_presupuesto/cambio_cantidad_insumos/getAgrupacionFiltro',
                type: "POST",
                beforeSend: function () {
                    self.buscando_agrupados=true;
                },
                data: {
                        filtro_agrupado:self.form.filtro_agrupador,
                        precios: self.form.precios_seleccionados
                      },
                success: function (data, textStatus, xhr) {
                    self.form.agrupacion = data.data;
                    self.buscando_agrupados=false;
                },
                complete: function () {
                    self.buscando_agrupados=false;
                }
            });

        },
        consulta_precios_material: function () {
            var self = this;
            $.ajax({
                type: 'GET',
                url: App.host + '/conceptos/' + self.form.filtro_agrupador.id_material + '/getPreciosConceptos',
                beforeSend: function () {
                   self.consultando_precio=true;
                },
                success: function (data, textStatus, xhr) {
                    if (data.data.precios.length > 0) {
                        if (data.data.precios.length == 1) {
                            self.form.precios_seleccionados = data.data.precios;
                        } else {
                            self.form.precios_disponibles = data.data.precios;
                            $('#lista_precios_modal').modal("show");

                        }

                    } else {
                        swal({
                            type: 'warning',
                            title: 'Advertencia',
                            text: 'No se encontro ningun precio para el material seleccionado.'
                        });
                    }
                },
                complete: function () {
                   self.consultando_precio=false;
                }
            });
        },
        selecciona_all_precios: function () {
            var self = this;
            if ($('#select_all_price').prop('checked')) {
                self.form.precios_seleccionados = self.form.precios_disponibles;
            } else {
                self.form.precios_seleccionados = [];
            }
        },
        valida_seleccion_all: function () {
            var self = this;
            if (self.form.precios_seleccionados.length == self.form.precios_disponibles.length) {
                $('#select_all_price').prop('checked', true);
            } else {
                $('#select_all_price').prop('checked', false);
            }
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
        confirmSave: function () {
            var self = this;

            var cambios=false;
            $.each(self.form.agrupacion,function (index,value) {
                if(value.aplicar_todos){
                    cambios=true;
                }
                $.each(value.items,function (index,value) {
                    if(value.agregado){
                        cambios=true;
                    }
                });

            });

            if(cambios){

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
            });}
            else{
                    swal({
                        type: 'warning',
                        title: 'Advertencia',
                        text: 'Agregue almenos un cambio a la solicitud.'
                    });
                }
        },
        save: function () {
            var self = this;


                $.ajax({
                    url: App.host + '/control_presupuesto/cambio_cantidad_insumos/store',
                    type: 'POST',
                    data:self.form,
                    beforeSend: function () {
                        self.cargando = true;
                    },
                    success: function (response) {
                        swal({
                            type: 'success',
                            title: '¡Correcto!',
                            //html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                            html: 'Solicitud Guardada Exitosamente.'
                        }).then(function () {

                        });

                        window.location.href = App.host + '/control_presupuesto/cambio_cantidad_insumos/' +response.id
                    },
                    complete: function () {
                        self.cargando = false;
                    }
                })
            }
      }
});