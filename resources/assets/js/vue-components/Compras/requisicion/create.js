Vue.component('requisicion-create', {

    props: ['departamentos_responsables', 'tipos_requisiciones', 'url_requisicion'],

    data: function() {
        return {
            form : {
                id_departamento : '',
                id_tipo_requisicion : '',
                observaciones : ''
            },
            guardando : false
        }
    },
    methods:{

        confirm_save: function () {
            var self = this;
            swal({
                title: "Guardar Requisición",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },

        save: function () {
            var self = this;
            var url = this.url_requisicion;
            var data = this.form;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha creado la Requisición <br>" +
                        "<b>" + data.data.requisicion.transaccion_ext.folio_adicional + "</b>",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = self.url_requisicion + '/' + data.data.requisicion.id_transaccion + '/edit';
                    })  .catch(swal.noop);
                },
                complete: function () {
                    self.guardando = false;
                }
            })
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if (funcion == 'save') {
                    this.confirm_save();
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
