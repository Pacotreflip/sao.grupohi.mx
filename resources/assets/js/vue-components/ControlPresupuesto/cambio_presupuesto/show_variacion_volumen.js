Vue.component('show-variacion-volumen', {
    props: ['solicitud', 'cobrabilidad'],
    data: function () {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: this.cobrabilidad
            },
            cargando: false,
            rechazando:false,
            autorizando:false,
            consultando:false,
            partidas:[],
            partida_id:0
        }
    },

    computed: {},

    mounted: function () {

    },

    methods: {

        confirm_autorizar_solicitud: function () {
            var self = this;
            var id = self.form.solicitud.id;
            swal({
                title: "Autorizar la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if (result.value) {
                    self.autorizar_solicitud(id);
                }
            });

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

            var self = this;
            var url = App.host + '/control_presupuesto/cambio_presupuesto/autorizarSolicitud';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden
                },
                beforeSend: function () {
                    self.autorizando = true;
                    $('#btn_rechazar').prop('enabled',false);
                    $('#btn_autorizar').prop('enabled',false);
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
                   // window.location.reload(true);
                },
                complete: function () {
                    self.autorizando = false;
                    $('#btn_rechazar').prop('enabled',true);
                    $('#btn_autorizar').prop('enabled',true);
                }
            });
        },

        rechazar_solicitud: function (id,motivo) {


            var self = this;
            var url = App.host + '/control_presupuesto/cambio_presupuesto/rechazarSolicitud';
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
                    $('#btn_rechazar').prop('enabled',false);
                    $('#btn_autorizar').prop('enabled',false);
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
                   // window.location.reload(true);
                },
                complete: function () {
                    self.rechazando = false;
                    $('#btn_rechazar').prop('enabled',true);
                    $('#btn_autorizar').prop('enabled',true);
                }
            });
        }
        ,
        mostrar_detalle_partida:function (id) {
            $('#divDetalle').fadeOut();
            var self = this;
            self.partida_id=id;
            var url = App.host + '/control_presupuesto/cambio_presupuesto_partida/'+id;
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function () {
                    self.consultando = true;
                    },
                success: function (data, textStatus, xhr) {
                  self.partidas=data.data;
                  $('#divDetalle').fadeIn();
                },
                complete: function () {
                    self.consultando = false;

                }
            });

        }
        ,
        mostrar_detalle_presupuesto:function (idPresupuesto) {
            var self = this;
            var partida=self.partida_id;
            var presupuesto=idPresupuesto;
            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/cambio_presupuesto_partida/detallePresupuesto';
            $.ajax({
                type: 'POST',
                data:{
                    id_partida:partida,
                    presupuesto:presupuesto
                },
                url: url,
                beforeSend: function () {
                    self.consultando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.partidas=data.data;
                    $('#divDetalle').fadeIn();
                },
                complete: function () {
                    self.consultando = false;

                }
            });

        }

    }
});