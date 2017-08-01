Vue.component('revaluacion-create', {
    props: ['facturas','tipo_cambio','url_revaluacion'],
    data : function() {
        return {
            data: {
                facturas: this.facturas

            },
            guardando : false
        }
    },
    methods: {

        confirm_save_facturas: function () {
            var self = this;
            swal({
                title: "Guardar Revaluación",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save_facturas();
            }).catch(swal.noop);
        },
        save_facturas: function () {
            var self = this;
            var url = this.url_revaluacion;
            var data=$('#form_facturas').serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (data, textStatus, xhr) {

                },
                complete: function () {

                }
            });
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'confirm_save_facturas') {
                this.confirm_save_facturas();
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