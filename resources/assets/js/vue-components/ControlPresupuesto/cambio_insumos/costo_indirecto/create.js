Vue.component('cambio-insumos-indirecto-create', {
    props: ['id_tipo_orden'],
    data: function () {
        return {
            form: {
                partidas: [],
                insumos_eliminados: [],
                motivo: '',
                area_solicitante: '',
                concepto_seleccionado:[],
                id_tipo_orden:this.id_tipo_orden
            },
            concepto: {
                descripcion: '',
                id_material: '',
                monto_presupuestado: '',
                precio_unitario: '',
                cantidad_presupuestada: '',
                cantidad_presupuestada_nueva: '',
                precio_unitario_nuevo: '',
                unidad: '',
                rendimiento_nuevo:'',
                id_elemento: '',
                tipo_agrupador: 6
            },
            id_material_seleccionado:0,
            material_seleccionado:[],
            guardar: false,
            id_concepto_indirecto: '',
            concepto_seleccionado: [],
            cargando: false,
            guardando: false,
            cargando_tarjetas: true,
            consultando:false,
            tipo_insumo:''
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
                        descripcion: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data.conceptos, function (item) {
                            return {
                                text:  item.filtro5 + " -> " + item.filtro6 + " -> " + item.filtro7,
                                id: item.id_concepto,
                                cantidad_presupuestada:item.cantidad_presupuestada,
                                monto_presupuestado:item.monto_presupuestado,
                                precio_unitario:item.precio_unitario,
                                id_concepto:item.id_concepto
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
            self.form.concepto_seleccionado=data;
            self.concepto_seleccionado=data;
            self.form.partidas=[];
            self.obtenerExplosion(data.id);
        });
        self.cargando_tarjetas = false;

    },
    methods: {

        obtenerExplosion: function (idConcepto) {
            var self = this;
            $.ajax({
                url: App.host + '/conceptos/' + idConcepto + '/getInsumos',
                type: 'GET',
                async: 'true',
                beforeSend: function () {
                 self.consultando=true;
                },
                success: function (response) {

                    $.each(response.conceptos.GASTOS.insumos, function (key, value) {
                        //console.log(key+"  -  "+value.descripcion);


                        self.concepto.id_material = value.id_material;
                        self.concepto.monto_presupuestado = value.monto_presupuestado;
                        self.concepto.precio_unitario = value.precio_unitario;
                        self.concepto.cantidad_presupuestada = value.cantidad_presupuestada;
                        self.concepto.descripcion = (value.descripcion).toString();
                        self.concepto.unidad = value.unidad;
                        self.concepto.rendimiento_actual=value.cantidad_presupuestada/self.concepto_seleccionado.cantidad_presupuestada;
                        self.concepto.id_elemento = value.id_concepto;
                        self.concepto.id_concepto=value.id_concepto;
                        self.form.partidas.push(self.concepto);


                    });
                    self.concepto=[];
                    self.consultando=false;
                },
                complete: function () {
                    self.consultando=false;
                }
            });

        },
        insumoEliminado: function (id_concepto) {
            return this.form.insumos_eliminados.indexOf(parseInt(id_concepto)) ? true : false;
        },
        recalcular: function (id_concepto, i, tipo) {
            var self = this;
            var cant_pres = $(".rendimiento" + id_concepto + '_' + i).val();
            var cant_concepto = self.concepto_seleccionado.cantidad_presupuestada;
            console.log(".rendimiento" + id_concepto + '_' + i);
            self.form.partidas[i].rendimiento_nuevo = cant_pres;
            var total = cant_concepto * self.form.partidas[i].rendimiento_nuevo;
            $("#r_p_" + id_concepto + '_' + i).val(total);

        },

        recalcular_monto: function (id_concepto, i, tipo) {
            var self = this;
            var cant = $(".pre_unit" + id_concepto + '_' + i).val();
            self.form.partidas[i].precio_unitario_nuevo = cant;

        },

        recalcular_cantidad: function (id_concepto, i, tipo) {
            var self = this;
            var cant_pres = $("#r_p_" + id_concepto + '_' + i).val();
            var cant_concepto =self.concepto_seleccionado.cantidad_presupuestada;
            var total = cant_pres / cant_concepto;
            $(".rendimiento" + id_concepto + '_' + i).val(total);
            self.form.partidas[i].rendimiento_nuevo = total;

        },
        agregar_insumo_nuevo: function () {
            var self = this;
            var existe=false;
            $.each(self.form.partidas, function (index, insumo) {
                if(insumo.id_material == self.material_seleccionado.id_material){

                    existe=true;
                    swal({
                        type: 'warning',
                        title: 'Advertencia',
                        text: 'Ya Existe el Insumo Seleccionado'
                    });
                }
            });
            if(!existe){
                self.form.partidas.push(self.material_seleccionado);
                $('#add_insumo_modal').modal('hide');
            }

        },
        removeRendimiento : function (id_concepto, id, tipo) {
            var self = this;
            var index = self.form.insumos_eliminados.indexOf(parseInt(id_concepto));
            if(index > -1){
                console.log('entro');
                self.form.insumos_eliminados.splice(index, 1);
                $("#c_p_"+ id_concepto+ '_' + id).prop('disabled', false);
                $("#m_p_"+ id_concepto+ '_' + id).prop('disabled', false);
                $("#r_p_"+ id_concepto+ '_' + id).prop('disabled', false);
            }else{
                self.form.insumos_eliminados.push(id_concepto);

                if (self.form.partidas[id].nuevo) {
                  self.form.partidas.splice(id, 1);

                }

                $("#c_p_"+ id_concepto+ '_' + id).prop('disabled', true);
                $("#m_p_"+ id_concepto+ '_' + id).prop('disabled', true);
                $("#r_p_"+ id_concepto+ '_' + id).prop('disabled', true);
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
                url :App.host + '/control_presupuesto/cambio_insumos_indirecto',
                type : 'POST',
                data : self.form,
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
        addInsumoTipo: function (tipo) {
            var self = this;
            var aux_tipo = tipo;
            if (tipo == 5 || tipo == 6) {
                tipo = 2;
            }
            self.tipo_insumo = tipo;

            self.guardar = true;

            $('#sel_material').select2({
                width: '100%',
                async:true,
                ajax: {
                    url: App.host + '/control_presupuesto/cambio_presupuesto/getDescripcionByTipo',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            descripcion: params.term,
                            tipo: tipo
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data.materiales, function (item) {

                                return {
                                    text: item.DescripcionPadre+" -> ["+item.numero_parte+"] "+item.descripcion,
                                    descripcion: item.descripcion,
                                    id_material: item.id_material,
                                    unidad: item.unidad,
                                    cantidad_presupuestada: 0,
                                    variacion_cantidad_presupuestada: 0,
                                    cantidad_presupuestada_nueva: 0,
                                    variacion_precio_unitario: 0,
                                    precio_unitario: 0,
                                    id: item.id_material,
                                    nuevo: true,
                                    rendimiento_actual: 0
                                }
                            })
                        };
                    },
                    success: function (data, textStatus, xhr) {
                      //  self.tipo_insumo = aux_tipo;
                    },
                    error: function (error) {
                        //self.tipo_insumo = aux_tipo;
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
                data.id_elemento = data.id_material;
                // console.log(data);
                self.guardar = false;
                self.material_seleccionado = data;
            });


            $('#add_insumo_modal').modal('show');
        }

    }
});