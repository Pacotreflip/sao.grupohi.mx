Vue.component('variacion-volumen-show', {
    props: ['solicitud', 'cobrabilidad','presupuestos'],
    data: function () {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: this.cobrabilidad,
                afectaciones : []
            },
            cargando: false,
            rechazando:false,
            autorizando:false,
            consultando:false,
            partidas:[],
            importes:[],
            partida_id:0
        }
    },

    mounted: function () {

        this.fillAfectaciones();

        $(document).on('click', '.mostrar_pdf', function () {
            var _this = $(this),
                id = _this.data('pdf_id'),
                url = App.host + '/control_presupuesto/variacion_volumen/'+ id +'/pdf';

            $('#pdf_modal').modal('show');
            $('#pdf_modal .modal-body').html($('<iframe/>', {
                id:'formatoPDF',
                src: url,
                style:'width:99.6%;height:100%',
                frameborder:"0"
            })).css({height: '550px'});
        });
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
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.autorizar(id);
                }
            });
        },
        confirm_aplicar_solicitud: function () {
            var self = this;
            var id = self.form.solicitud.id;

            swal({
                title: "Aplicar cambios a la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.aplicar(id);
                }
            });
        },
        confirm_rechazar_solicitud: function () {
            var self = this;
            var id = self.form.solicitud.id;

            $('.rechazar_solicitud').addClass('disabled');

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
                } else {
                    $('.rechazar_solicitud').removeClass('disabled');
                }
            });
        },
        autorizar: function (id) {
            var self = this;
            var url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/autorizar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    afectaciones : self.form.afectaciones
                },
                beforeSend: function () {
                    self.cargando = true;
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
                        window.location.reload(true);
                    });
                },
                complete: function () {
                    self.cargando = false;
                    self.autorizando = false;
                    $('.autorizar_solicitud').removeClass('disabled');
                }
            });
        },
        aplicar: function (id) {
            var self = this;
            var url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/aplicar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    afectaciones : self.form.afectaciones
                },
                beforeSend: function () {
                    self.cargando = true;
                    self.autorizando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud aplicada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location.reload(true);
                    });
                },
                complete: function () {
                    self.cargando = false;
                    self.autorizando = false;
                }
            });
        },
        rechazar_solicitud: function (id,motivo) {
            var self = this;
            var url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/rechazar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    motivo:motivo
                },
                beforeSend: function () {
                    self.cargando = true;
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
                        window.location.reload(true);
                    });
                },
                complete: function () {
                    self.cargando = false;
                    self.rechazando = false;
                    $('.rechazar_solicitud').removeClass('disabled');
                }
            });
        },
        mostrar_detalle_partida:function (id) {
            var self = this;
            var partida = id;
            self.partida_id = id;
            var presupuesto = self.presupuestos[0].base_datos.id;
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
                    self.cargando = true;
                    self.consultando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.partidas=data.data;
                    $('#divDetalle').fadeIn();
                },
                complete: function () {
                    self.cargando = false;
                    self.consultando = false;
                }
            });
        },
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
                    self.cargando = true;
                    self.consultando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.partidas=data.data;
                    $('#divDetalle').fadeIn();
                },
                complete: function () {
                    self.cargando = false;
                    self.consultando = false;
                }
            });
        },
        fillAfectaciones : function () {
            var self = this;
            self.form.afectaciones = [];
            self.solicitud.aplicaciones.forEach(function (value) {
                self.form.afectaciones.push(value.id);
            });
        },
        aplicada: function (id) {
            var res = false;
            this.solicitud.aplicaciones.forEach(function(value) {
                if(id == value.id && value.pivot.aplicada == 1) {
                    res = true;
                }
            });
            return res;
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                switch(funcion) {
                case 'autorizar_solicitud':
                    this.confirm_autorizar_solicitud();
                    break;
                case 'aplicar_solicitud':
                    this.confirm_aplicar_solicitud();
                    break;
                }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        }
    }
});