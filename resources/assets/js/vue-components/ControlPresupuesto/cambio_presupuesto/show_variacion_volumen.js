Vue.component('show-variacion-volumen', {
    props: ['solicitud', 'cobrabilidad'],
    data: function () {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: this.cobrabilidad
            },
            cargando: false
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
                title: "Rechazar la Solicitud de Cambio",
                html: "¿Estás seguro que desea rechazar la solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if (result.value) {
                    self.rechazar_solicitud(id);
                }
            });

        },
        autorizar_solicitud: function (id) {
            var self = this;
            var url = App.host + '/control_presupuesto/cambio_presupuesto/autorizarSolicitud';
            $.ajax({
                type: 'POST',
                url: url,
                data:{
                    id:id,
                    id_tipo_orden:self.form.solicitud.id_tipo_orden
                },
                beforeSend: function () {
                   self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                  alert("exitoso");
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        rechazar_solicitud: function (id) {
            alert("Rechazar ->" + id);
        }

    }
});