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
    directives: {
        icheck: {
            inserted: function (el) {
                $(el).iCheck({
                    checkboxClass: 'icheckbox_minimal-grey'
                });
            }
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
            }).then(function (result) {
                if(result.value) {
                    self.save_facturas();
                }
            });
        },
        save_facturas: function () {
            var self = this;
            var url = this.url_revaluacion;
            var data=$('#form_facturas').serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function() {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Revaluación guardada correctamente'
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    });
                },
                complete: function () {
                    self.guardando = false;
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