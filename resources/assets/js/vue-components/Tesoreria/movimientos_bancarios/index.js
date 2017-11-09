Vue.component('movimientos_bancarios-index', {
    props: ['url_movimientos_bancarios_index', 'cuentas', 'tipos', 'movimientos'],
    data : function () {
        return {
            'data' : {
                'cuentas': this.cuentas,
                'tipos': this.tipos,
                'movimientos': this.movimientos
            },
            'form' : {
                'id_tipo_movimiento' : '',
                'estatus' : '',
                'id_cuenta': '',
                'impuesto': '0',
                'importe': '',
                'observaciones': '',
                'fecha': moment().format('YYYY-MM-DD'),
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'movimiento_edit': {
                'id_movimiento_bancario' : '',
                'id_tipo_movimiento' : '',
                'estatus' : '',
                'id_cuenta': '',
                'impuesto': 0,
                'importe': 0,
                'observaciones': '',
                'fecha': '',
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'guardando' : false
        }
    },
    computed: {},
    mounted: function()
    {
        var self = this;

        $("#Cumplimiento").datepicker().on("changeDate",function () {
            Vue.set(self.form, 'vencimiento', $('#Cumplimiento').val());
            Vue.set(self.form, 'cumplimiento', $('#Cumplimiento').val());
        });
        $("#edit_cumplimiento").datepicker().on("changeDate",function () {
            Vue.set(self.movimiento_edit, 'vencimiento', $('#edit_cumplimiento').val());
            Vue.set(self.movimiento_edit, 'cumplimiento', $('#edit_cumplimiento').val());
        });
        $("#Fecha").datepicker().on("changeDate",function () {
            var thisElement = $(this);

            Vue.set(self.form, 'fecha', thisElement.val());
            thisElement.datepicker('hide');
            thisElement.blur();
            self.$validator.validate('required', self.form.fecha);
        });
        $(".fechas_edit").datepicker().on("changeDate",function () {
            var thisElement = $(this);
            var id = thisElement.attr('id').replace('edit_','');

            Vue.set(self.traspaso_edit, id, thisElement.val());
        });
    },
    directives: {
        datepicker: {
            inserted: function (el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        },
    },
    methods: {
        datos_cuenta: function (id) {
            return this.cuentas[id];
        },
        confirm_guardar: function() {
            var self = this;
            swal({
                title: "Guardar movimiento",
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
                url : self.url_movimientos_bancarios_index,
                data: self.form,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data.data.movimiento === 'string')
                    {
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.movimiento
                        });
                    }

                    else
                    {
                        self.data.movimientos.push(data.data.movimiento);
                        swal({
                            type: 'success',
                            title: 'Correcto',
                            html: 'Movimiento guardado correctamente'
                        });
                    }
                },
                complete: function () {
                    self.guardando = false;
                    self.close_modal_movimiento();
                }
            });
        },
        modal_movimiento: function () {
            $('#movimiento_modal').modal('show');
            $('#id_tipo_movimiento').focus();
        },
        close_modal_movimiento: function () {
            this.reset_form();
            $('#movimiento_modal').modal('hide');
        },
        confirm_eliminar: function(id_movimiento_bancario) {
            var self = this;
            swal({
                title: "Eliminar movimiento",
                text: "¿Estás seguro/a de que deseas eliminar este movimiento?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.eliminar(id_movimiento_bancario);
            }).catch(swal.noop);
        },
        eliminar: function (id_movimiento_bancario) {
            var self = this;
            $.ajax({
                type: 'GET',
                url : self.url_movimientos_bancarios_index +'/'+ id_movimiento_bancario,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    self.data.movimientos.forEach(function (movimiento) {
                        if (movimiento.id_movimiento_bancario == data.data.id_movimiento_bancario) {
                            self.data.movimientos.splice(self.data.movimientos.indexOf(movimiento), 1);
                        }
                    });

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Movimiento eliminado'
                    });
                },
                complete: function () { }
            });
        },
        modal_editar: function (movimiento){
            Vue.set(this.movimiento_edit, 'id_movimiento_bancario', movimiento.id_movimiento_bancario);
            Vue.set(this.movimiento_edit, 'id_tipo_movimiento', movimiento.id_tipo_movimiento);
            Vue.set(this.movimiento_edit, 'estatus', movimiento.estatus);
            Vue.set(this.movimiento_edit, 'id_cuenta', movimiento.id_cuenta);
            Vue.set(this.movimiento_edit, 'impuesto', movimiento.impuesto);
            Vue.set(this.movimiento_edit, 'importe', movimiento.importe);
            Vue.set(this.movimiento_edit, 'observaciones', movimiento.observaciones);
            Vue.set(this.movimiento_edit, 'fecha', this.trim_fecha(movimiento.movimiento_transaccion.transaccion.fecha));
            Vue.set(this.movimiento_edit, 'cumplimiento', this.trim_fecha(movimiento.movimiento_transaccion.transaccion.cumplimiento));
            Vue.set(this.movimiento_edit, 'vencimiento', this.trim_fecha(movimiento.movimiento_transaccion.transaccion.vencimiento));
            Vue.set(this.movimiento_edit, 'referencia', movimiento.movimiento_transaccion.transaccion.referencia);

            this.validation_errors.clear('form_editar_movimiento');
            $('#edit_movimiento_modal').modal('show');
            $('#edit_id_cuenta').focus();
        },
        confirm_editar: function() {
            var self = this;
            swal({
                title: "Editar movimiento",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.editar();
            }).catch(swal.noop);
        },
        editar: function () {
            var self = this;

            self.movimiento_edit._method = 'PATCH';
            $.ajax({
                type: 'POST',
                url : self.url_movimientos_bancarios_index + '/' + self.movimiento_edit.id_movimiento_bancario,
                data: self.movimiento_edit,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data.data.movimiento === 'string')
                    {
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.movimiento
                        });
                    }

                    else
                    {
                        self.data.movimientos.forEach(function (movimiento) {
                            if (movimiento.id_movimiento_bancario === data.data.movimiento.id_movimiento_bancario) {
                                Vue.set(self.data.movimientos, self.data.movimientos.indexOf(movimiento), data.data.movimiento);
                            }
                        });
                        swal({
                            type: 'success',
                            title: 'Correcto',
                            html: 'movimiento guardado correctamente'
                        });
                    }

                    self.close_edit_movimiento();
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        close_edit_movimiento: function () {
            $('#edit_movimiento_modal').modal('hide');
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
        },
        trim_fecha: function (fecha){
            return fecha.substring(0,10);
        },
        reset_form: function() {
            Vue.set(this.form, 'id_tipo_movimiento', '');
            Vue.set(this.form, 'estatus', '');
            Vue.set(this.form, 'id_cuenta', '');
            Vue.set(this.form, 'impuesto', '');
            Vue.set(this.form, 'observaciones', '');
            Vue.set(this.form, 'importe', '');
            Vue.set(this.form, 'fecha', '');
            Vue.set(this.form, 'cumplimiento', '');
            Vue.set(this.form, 'vencimiento', '');
            Vue.set(this.form, 'referencia', '');
        },
        total_edit: function () {
            var importe = this.movimiento_edit.importe == null ? 0 : this.movimiento_edit.importe,
                impuesto = this.movimiento_edit.impuesto == null ? 0 : this.movimiento_edit.impuesto;

            return impuesto > 0 ?  parseFloat(importe) + parseFloat(impuesto) : importe;
        },
        total_create: function () {
            var importe = this.form.importe == null ? 0 : this.form.importe,
                impuesto = this.form.impuesto == null ? 0 : this.form.impuesto;

            return impuesto > 0 ?  parseFloat(importe) + parseFloat(impuesto) : importe;
        },
        total: function (importe, impuesto) {
            var importe = importe == null ? 0 : importe,
                impuesto = impuesto == null ? 0 : impuesto;

            return impuesto > 0 ?  parseFloat(importe) + parseFloat(impuesto) : importe;
        }
    }
});
