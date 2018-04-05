Vue.component('cambio-cantidad-insumos-show', {
    props: ['solicitud', 'agrupacion'],
    data: function () {
        return {
            form: {
                filtro_agrupador: {
                    id_tipo_filtro: 0,
                    id_material: 0
                },
                solicitud: this.solicitud,
                cobrabilidad: '',
                agrupacion: this.agrupacion
            },
            rechazando: false,
            autorizando: false,
            consultando:false

        }
    },
    mounted: function () {
        var self = this;

        $(function() {
            $(document).on('click', '.mostrar_pdf', function () {
                var _this = $(this),
                    id = _this.data('pdf_id'),
                    url = App.host + '/control_presupuesto/cambio_cantidad_insumos/'+ id +'/pdf';

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
                    self.rechazar_solicitud(id, result.value);
                }
            });


        },
        rechazar_solicitud: function (id, motivo) {
            $('#btn_rechazar').prop('disabled', true);
            $('#btn_autorizar').prop('disabled', true);

            var self = this;
            var url = App.host + '/control_presupuesto/cambio_insumos/' + id + '/rechazar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_solicitud_cambio: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    motivo: motivo
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
        consulta_detalle_agrupador: function (indexRow) {
            var self = this;
            if(self.form.agrupacion[indexRow].items.length==0) {

                self.row_consulta = indexRow;
                $.ajax({
                    type: 'POST',
                    async: true,
                    url: App.host + '/control_presupuesto/cambio_cantidad_insumos/getExplosionAgrupadosPartidas',
                    data: {
                        id_material: self.form.agrupacion[indexRow].id_material,
                        precio: self.form.agrupacion[indexRow].precio_unitario_original,
                        descripcion: self.form.agrupacion[indexRow].agrupador,
                        id_tipo_filtro: self.solicitud.filtro_cambio_cantidad.id_tipo_filtro,
                        id_solicitud: self.solicitud.id
                    },
                    beforeSend: function () {
                        self.consultando = true;
                    },
                    success: function (data, textStatus, xhr) {
                        self.form.agrupacion[indexRow].items = data.data;
                        self.form.agrupacion[indexRow].expandido=true;
                        self.form.agrupacion[indexRow].mostrar_detalle = true;
                        if (self.form.agrupacion[indexRow].aplicar_todos) {
                            $.each(self.form.agrupacion[indexRow].items, function (index, value) {
                                value.agregado = true;
                            });

                        }
                        self.consultando = false;
                    },
                    complete: function () {
                        self.consultando = false;
                    },

                });
            }
            else{

                    if(self.form.agrupacion[indexRow].expandido==true){
                        self.form.agrupacion[indexRow].expandido=false;
                        $('#tr_detalle_'+indexRow).hide();
                    }else{
                        self.form.agrupacion[indexRow].expandido=true;
                        $('#tr_detalle_'+indexRow).show();
                    }
                }
        },
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
        autorizar_solicitud: function (id) {
            $('#btn_rechazar').prop('disabled',true);
            $('#btn_autorizar').prop('disabled',true);
            var self = this;
            var url = App.host + '/control_presupuesto/cambio_cantidad_insumos/'+id+'/autorizar';
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

        }

    }
});