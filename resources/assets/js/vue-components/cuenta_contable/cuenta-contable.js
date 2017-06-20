Vue.component('cuenta-contable', {
    props: ['obra', 'obra_update_url'],
    data: function() {
        return {
            guardando : false
        }
    },

    methods: {
        confirm_datos_obra: function (e) {
            e.preventDefault();

            var self = this;

            swal({
                title: "Guardar Datos de Obra",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_datos_obra();
            }).catch(swal.noop);
        },

        save_datos_obra: function () {
            var self = this;
            $.ajax({
                type: 'POST',
                url: self.obra_update_url,
                data: self.datosObra,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos de la Obra <b>' +self.obra.nombre + '</b> actualizados correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        }
    }
});