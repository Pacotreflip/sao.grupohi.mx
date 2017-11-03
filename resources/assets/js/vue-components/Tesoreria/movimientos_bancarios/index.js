Vue.component('movimientos_bancarios-index', {
    props: ['url_movimientos_bancarios_index', 'cuentas', 'tipos'],
    data : function () {
        return {
            'data' : {
                'cuentas': this.cuentas,
                'tipos': this.tipos
            },
            'form' : {
                'id_tipo_movimiento' : '',
                'estatus' : '',
                'id_cuenta': '',
                'impuesto': '',
                'importe': '',
                'observaciones': ''
            },
            'traspaso_edit': {
                'id_tipo_movimiento' : '',
                'estatus' : '',
                'id_cuenta': '',
                'impuesto': '',
                'importe': '',
                'observaciones': ''
            },
            'guardando' : false
        }
    },
    computed: {
    },
    mounted: function()
    {
        var self = this;
    },
    directives: {},
    methods: {
        datos_cuenta: function (id) {
            return this.cuentas[id];
        },
        confirm_guardar: function() {
            var self = this;
            swal({
                title: "Guardar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.guardar();
            }).catch(swal.noop);
        },
        guardar: function () {
            var self = this;

            $.ajax({
                type: 'POST',
                url : self.url_traspaso_cuentas_index,
                data: self.form,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    self.data.traspasos.push(data.data.traspaso);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso guardado correctamente'
                    });
                },
                complete: function () {
                    self.guardando = false;
                    self.close_traspaso();
                }
            });
        },
        modal_movimiento: function () {
            $('#movimiento_modal').modal('show');
            $('#id_tipo_movimiento').focus();
        },
        close_modal_movimiento: function () {
            $('#movimiento_modal').modal('hide');
        },
        validateForm: function(scope, funcion) {
            self = this;
            this.$validator.validateAll(scope).then(() => {
                if(funcion === 'confirm_guardar') {
                    self.confirm_guardar();
                } else if (funcion === 'confirm_editar') {
                self.confirm_editar();
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