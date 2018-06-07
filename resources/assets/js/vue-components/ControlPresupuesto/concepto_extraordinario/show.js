Vue.component('concepto-extraordinario-show', {
    props: ['solicitud', 'partidas'],
    data: function () {
        return{
            form: {
                solicitud: this.solicitud

            },
            rechazando:false,
            autorizando:false
        }
    },
    methods: {
        confirm_autorizar_solicitud: function () {
            var self = this;
            var id = self.solicitud.id;
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
            var id = self.solicitud.id;

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

        autorizar_solicitud: function (id) {
            $('#btn_rechazar').prop('disabled',true);
            $('#btn_autorizar').prop('disabled',true);
            var self = this;
            var url = App.host + '/control_presupuesto/conceptos_extraordinarios/'+id+'/autorizar';
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
                    //window.location.reload(true);
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
            var url = App.host + '/control_presupuesto/conceptos_extraordinarios/'+id+'/rechazar';
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
        }
    }
});