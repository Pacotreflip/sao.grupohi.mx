Vue.component('cuenta-contable-create', {
    props: ['obra'],
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
            alert('save');
        }
    }
});