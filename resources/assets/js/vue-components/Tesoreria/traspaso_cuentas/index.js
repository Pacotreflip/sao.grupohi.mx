Vue.component('traspaso-cuentas-index', {
    props: ['url_traspaso_cuentas_index', 'cuentas', 'traspasos', 'monedas'],
    data : function () {
        return {
            'data' : {
                'traspasos' : this.traspasos,
                'cuentas': this.cuentas,
                'monedas': this.monedas,
                'ver': []
            },
            'form' : {
                'id_cuenta_origen': '',
                'id_cuenta_destino': '',
                'observaciones': '',
                'importe': '',
                'fecha': moment().format('YYYY-MM-DD'),
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'traspaso_edit': {
                'id_traspaso': '',
                'id_cuenta_origen': '',
                'id_cuenta_destino': '',
                'observaciones': '',
                'importe': '',
                'fecha': '',
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'guardando' : false
        }
    },
    computed: {
        cuentas_disponibles: function () {
            var self = this;
            return this.cuentas.filter(function (cuenta) {
                return cuenta.id_cuenta != self.form.id_cuenta_origen;
            });
        }
    },
    mounted: function()
    {
        var self = this;

        $("#cumplimiento").datepicker().on("changeDate",function () {
            Vue.set(self.form, 'vencimiento', $('#cumplimiento').val());
            Vue.set(self.form, 'cumplimiento', $('#cumplimiento').val());
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

                    // Si data.traspaso es un string hubo un error al guardar el traspaso
                    if (typeof data.data.traspaso === 'string'){
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.traspaso
                        });
                    }
                    else{
                        self.data.traspasos.push(data.data.traspaso);
                        swal({
                            type: 'success',
                            title: 'Correcto',
                            html: 'Traspaso guardado correctamente'
                        });
                    }
                },
                complete: function () {
                    self.guardando = false;
                    self.close_traspaso();

                }
            });
        },
        confirm_eliminar: function(id_traspaso) {
            var self = this;
            swal({
                title: "Eliminar traspaso",
                text: "¿Estás seguro/a de que deseas eliminar este traspaso?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.eliminar(id_traspaso);
            }).catch(swal.noop);
        },
        eliminar: function (id_traspaso) {
            var self = this;
            $.ajax({
                type: 'GET',
                url : self.url_traspaso_cuentas_index +'/'+ id_traspaso,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === id_traspaso) {
                            self.data.traspasos.splice(self.data.traspasos.indexOf(traspaso), 1);
                        }
                    });

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso eliminado'
                    });
                },
                complete: function () { }
            });
        },
        modal_ver_traspaso: function (item) {
            Vue.set(this.data, 'ver', item);
            Vue.set(this.data.ver, 'fecha', this.trim_fecha(item.traspaso_transaccion.transaccion_debito.fecha));
            Vue.set(this.data.ver, 'importe', this.comma_format(item.importe));
            Vue.set(this.data.ver, 'cumplimiento', this.trim_fecha(item.traspaso_transaccion.transaccion_debito.cumplimiento));
            Vue.set(this.data.ver, 'vencimiento', this.trim_fecha(item.traspaso_transaccion.transaccion_debito.vencimiento));
            Vue.set(this.data.ver, 'referencia', item.traspaso_transaccion.transaccion_debito.referencia);
            Vue.set(this.data.ver, 'cuenta_origen_texto', item.cuenta_origen.numero +' '+ item.cuenta_origen.abreviatura +' ('+ item.cuenta_origen.empresa.razon_social +')');
            Vue.set(this.data.ver, 'cuenta_destino_texto', item.cuenta_destino.numero +' '+ item.cuenta_destino.abreviatura +' ('+ item.cuenta_destino.empresa.razon_social +')');

            $('#ver_traspaso_modal').modal('show');
        },
        close_modal_ver_traspaso: function () {
            $('#ver_traspaso_modal').modal('hide');
            Vue.set(this.data, 'ver', []);
        },
        modal_traspaso: function () {
            this.validation_errors.clear('form_guardar_traspaso');
            this.$validator.clean();
            $('#traspaso_modal').modal('show');
            $('#id_cuenta_origen').focus();
        },
        close_traspaso: function () {
            this.reset_form();
            $('#traspaso_modal').modal('hide');
        },
        modal_editar: function (traspaso){

            Vue.set(this.traspaso_edit, 'id_traspaso', traspaso.id_traspaso);
            Vue.set(this.traspaso_edit, 'id_cuenta_origen', traspaso.id_cuenta_origen);
            Vue.set(this.traspaso_edit, 'id_cuenta_destino', traspaso.id_cuenta_destino);
            Vue.set(this.traspaso_edit, 'observaciones', traspaso.observaciones);
            Vue.set(this.traspaso_edit, 'importe', traspaso.importe);
            Vue.set(this.traspaso_edit, 'fecha', this.trim_fecha(traspaso.traspaso_transaccion.transaccion_debito.fecha));
            Vue.set(this.traspaso_edit, 'cumplimiento', this.trim_fecha(traspaso.traspaso_transaccion.transaccion_debito.cumplimiento));
            Vue.set(this.traspaso_edit, 'vencimiento', this.trim_fecha(traspaso.traspaso_transaccion.transaccion_debito.vencimiento));
            Vue.set(this.traspaso_edit, 'referencia', traspaso.traspaso_transaccion.transaccion_debito.referencia);

            this.validation_errors.clear('form_editar_traspaso');
            $('#edit_traspaso_modal').modal('show');
            $('#edit_id_cuenta_origen').focus();
        },
        confirm_editar: function() {
            var self = this;
            swal({
                title: "Editar traspaso",
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

            self.traspaso_edit._method = 'PATCH';
            $.ajax({
                type: 'POST',
                url : self.url_traspaso_cuentas_index + '/' + self.traspaso_edit.id_traspaso,
                data: self.traspaso_edit,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {

                    self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === data.data.traspaso.id_traspaso) {
                            Vue.set(self.data.traspasos, self.data.traspasos.indexOf(traspaso), data.data.traspaso);
                        }
                    });
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso guardado correctamente'
                    });

                    self.close_edit_traspaso();
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        close_edit_traspaso: function () {
            $('#edit_traspaso_modal').modal('hide');
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
            Vue.set(this.form, 'id_traspaso', '');
            Vue.set(this.form, 'id_cuenta_origen', '');
            Vue.set(this.form, 'id_cuenta_destino', '');
            Vue.set(this.form, 'observaciones', '');
            Vue.set(this.form, 'importe', '');
            Vue.set(this.form, 'fecha', '');
            Vue.set(this.form, 'cumplimiento', '');
            Vue.set(this.form, 'vencimiento', '');
            Vue.set(this.form, 'referencia', '');
        },
        comma_format: function (number) {
            var n = !isFinite(+number) ? 0 : +number,
                decimals = 4,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                toFixedFix = function (n, prec) {
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    var k = Math.pow(10, prec);
                    return Math.round(n * k) / k;
                },
                s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    }
});