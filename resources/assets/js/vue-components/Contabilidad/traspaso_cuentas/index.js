Vue.component('traspaso-cuentas-index', {
    props: ['url_traspaso_cuentas_index'],
    data : function () {
        return {
            'form' : {
                'cuenta_origen': '',
                'cuenta_destino': '',
                'observaciones': '',
                'importe': ''
            },
            'guardando' : false
        }
    },
    computed: {},
    methods: {
        confirm_save: function() {
            var self = this;
            swal({
                title: "Guardar traspaso",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.guardar();
            }).catch(swal.noop);
        },
        guardar: function () {
            var self = this,
                data_guardar = {
                    cuenta_origen: self.form.cuenta_origen,
                    cuenta_destino: self.form.cuenta_destino,
                    observaciones: self.form.observaciones,
                    importe: self.form.importe
            };
            $.ajax({
                type: 'POST',
                url : self.url_traspaso_cuentas_index +'/guardar',
                data: data_guardar,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    // Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso guardado correctamente'
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        validateForm: function(scope) {
            this.$validator.validateAll(scope).then(() => {
                this.confirm_save();
            }).catch(() => {
            swal({
                 type: 'warning',
                 title: 'Advertencia',
                 text: 'Por favor corrija los errores del formulario'
             });
        });
        },
    }
});