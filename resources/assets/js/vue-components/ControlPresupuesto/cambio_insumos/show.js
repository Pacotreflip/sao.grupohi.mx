Vue.component('cambio-insumos-show', {
    props: ['solicitud','presupuestos',  'conceptos_agrupados','total_proforma_agrupados'],
    data: function () {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: ''
            },
            clasificacion : [],
            cargando: false,
            rechazando:false,
            autorizando:false,
            consultando:false,
            consultandoImportes:false,

            partidas:[],
            importes:[],
            partida_id:0
        }
    },
    mounted: function () {
        var self = this;

        $(function() {
            $(document).on('click', '.mostrar_pdf', function () {
                var _this = $(this),
                    id = _this.data('pdf_id'),
                    url = App.host + '/control_presupuesto/cambio_insumos/'+ id +'/pdf';

                $('#formatoPDF').attr('src', url).hide();
                $('#spin_iframe').show();

                $('#pdf_modal').modal('show');

                $('#pdf_modal .modal-body').css({height: '550px'});
                document.getElementById('formatoPDF').onload = function() {
                    $('#formatoPDF').show();
                    $('#spin_iframe').hide();
                }
            });
        });
    },
    computed: {},

    methods: {

        confirm_autorizar_solicitud: function () {
            var self = this;
            var id = self.form.solicitud.id;
            swal({
                title: "Autorizar la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud? <br> <div id='detalle_sol_cop'></div>",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if (result.value) {
                    self.autorizar_solicitud(id);
                }
            });

            $("#detalles_impactos").clone().appendTo("#detalle_sol_cop");

        },

        confirm_rechazar_solicitud: function () {
            var self = this;
            var id = self.form.solicitud.id;

            swal({
                title: 'Rechazar Solicitud',
                text: 'Motivo del rechazo',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Rechazar ',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: false,
                preConfirm: function preConfirm(motivo) {
                    return new Promise(function (resolve) {
                        if (motivo.length === 0) {
                            swal.showValidationError('Por favor escriba un motivo para rechazar la solicitud.');
                        }
                        resolve();
                    });
                },
                allowOutsideClick: function allowOutsideClick() {
                    !swal.isLoading();
                }
            }).then(function (result) {
                if (result.value) {
                    self.rechazar_solicitud(id,result.value);
                }
            });



        },

        autorizar_solicitud: function (id) {
            $('#btn_rechazar').prop('disabled',true);
            $('#btn_autorizar').prop('disabled',true);
            var self = this;
            var url = App.host + '/control_presupuesto/cambio_insumos/'+id+'/autorizar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden
                },
                beforeSend: function () {
                    self.autorizando = true;
                   },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud autorizada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                    });
                     window.location.reload(true);
                },
                complete: function () {
                    self.autorizando = false;
                    }
            });

        },

        rechazar_solicitud: function (id,motivo) {
            $('#btn_rechazar').prop('disabled',true);
            $('#btn_autorizar').prop('disabled',true);

            var self = this;
            var url = App.host + '/control_presupuesto/cambio_insumos/'+id+'/rechazar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_solicitud_cambio: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    motivo:motivo
                },
                beforeSend: function () {
                    self.rechazando = true;

                },
                success: function (data, textStatus, xhr) {

                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud rechazada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                    });
                    window.location.reload(true);
                },
                complete: function () {
                    self.rechazando = false;
                }
            });
        },

        mostrarDetalleInsumos :function (index) {
            var self = this;
            var agrupado=self.conceptos_agrupados[index];
            $('#divDetalle').fadeOut();
            var url = App.host + '/control_presupuesto/cambio_presupuesto_partida/getClasificacionInsumos';
            $.ajax({
                type: 'POST',
                data:{
                    id_concepto:agrupado.id_concepto,
                    id_solicitud_cambio:agrupado.id_solicitud_cambio
                },
                url: url,
                beforeSend: function () {
                    self.consultando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.clasificacion=data.data;
                    $.each( data.data, function( key, value ) {
                        switch(value.id_tipo){
                            case 1:
                                value.monto_original= agrupado.concepto.materiales_monto_original;
                                value.variacion=agrupado.concepto.materiales_variacion;
                                break;
                            case 2:
                                value.monto_original= agrupado.concepto.mano_obra_monto_original;
                                value.variacion=agrupado.concepto.mano_obra_variacion;
                                break;
                            case 4:
                                value.monto_original= agrupado.concepto.herramienta_monto_original;
                                value.variacion=agrupado.concepto.herramienta_variacion;
                                break;
                            case 8:
                                value.monto_original= agrupado.concepto.maquinaria_monto_original;
                                value.variacion=agrupado.concepto.maquinaria_variacion;
                                break;
                            case 5:
                                value.monto_original= agrupado.concepto.subcontratos_monto_original;
                                value.variacion=agrupado.concepto.subcontratos_variacion;
                                break;
                            case 6:
                                value.monto_original= agrupado.concepto.gastos_monto_original;
                                value.variacion=agrupado.concepto.gastos_variacion;
                                break;

                        }
                        value.monto_nuevo= parseFloat(value.monto_original)+ parseFloat(value.variacion);
                    });


                    $('#divDetalle').fadeIn();
                },
                complete: function () {
                    self.consultando = false;

                }
            });

        }

    }
});