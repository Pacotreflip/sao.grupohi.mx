Vue.component('poliza-tipo-create', {
    props: ['tipos_cuentas_contables', 'tipos_movimiento', 'polizas_tipo_sao'],
    data: function() {
        return {
            'form' : {
                'poliza_tipo' : {
                    'id_poliza_tipo_sao' : '',
                    'movimientos' : [],
                    'inicio_vigencia' : ''
                },
                'movimiento' : {
                    'id_tipo_cuenta_contable' : '',
                    'id_tipo_movimiento' : ''
                },
                'errors' : []
            },
            'guardando' : false
        }
    },

    mounted: function() {
        var self = this;
        $("#inicio_vigencia").datepicker().on("changeDate",function () {
            Vue.set(self.form.poliza_tipo, 'inicio_vigencia', $('#inicio_vigencia').val())
        });
    },

    computed: {
        check_movimientos: function () {
           var a = false;
           var b = false;
            this.form.poliza_tipo.movimientos.forEach(function (movimiento) {
                if(movimiento.id_tipo_movimiento == '1') {
                    a = true;
                } else if (movimiento.id_tipo_movimiento == '2') {
                    b = true;
                }
            });

            return a && b;
        },

        tipos_cuentas_contables_disponibles: function () {
            return this.tipos_cuentas_contables;
        }
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
        }
    },

    methods: {
        show_add_movimiento: function () {
            this.validation_errors.clear('form_save_cuenta');
            $('#modal-add-movimiento').modal('show');
            this.validation_errors.clear('form_save_cuenta');
        },

        close_add_movimiento: function () {
            $('#modal-add-movimiento').modal('hide');
            this.reset_movimiento();
        },

        add_movimiento: function () {
            var id_tipo_cuenta_contable = $('#id_tipo_cuenta_contable').val();
            var id_tipo_movimiento = $('#id_tipo_movimiento').val();

            this.form.poliza_tipo.movimientos.push({
                id_tipo_cuenta_contable: id_tipo_cuenta_contable,
                id_tipo_movimiento: id_tipo_movimiento
            });
            this.reset_movimiento();
            this.validation_errors.clear('form_save_cuenta');
            $('#modal-add-movimiento').modal('hide');
            this.validation_errors.clear('form_save_cuenta');
        },

        reset_movimiento: function () {
            Vue.set(this.form.movimiento, 'id_tipo_cuenta_contable', '');
            Vue.set(this.form.movimiento, 'id_tipo_movimiento', '');
        },

        check_duplicity: function () {
            var self = this;
            var id = self.form.poliza_tipo.id_poliza_tipo_sao;
            var url = App.host + '/sistema_contable/poliza_tipo/findBy';
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'attribute' : 'id_poliza_tipo_sao',
                    'value' : id,
                    'with' : 'movimientos'
                },
                success: function (response) {
                    if(response.data.poliza_tipo != null) {
                        var body = "";
                        $.each(response.data.poliza_tipo.movimientos, function (index, movimiento) {
                            body += "<tr><td>"+(index+1)+"</td><td style='text-align: left'>"+ self.getTipoCuentaDescription(movimiento.id_tipo_cuenta_contable) +"</td><td>"+self.tipos_movimiento[movimiento.id_tipo_movimiento]+"</td></tr>"
                        });

                        swal({
                            title: "Advertencia",
                            html: "Ya existe una Plantilla para el tipo de Póliza seleccionado con un estado <b>" + response.data.poliza_tipo.vigencia + "</b><br>" +
                            "Con un inicio de vigencia el día <b>" + response.data.poliza_tipo.inicio_vigencia.split(" ")[0] + "</b><br><br>" +
                            "<table class='table table-striped small'>" +
                            "   <thead>" +
                            "   <tr>" +
                            "       <th style='text-align: center'>#</th>" +
                            "       <th style='text-align: center'>Tipo de Cuenta Contable</th>" +
                            "       <th style='text-align: center'>Tipo</th>" +
                            "   </tr>" +
                            "   </thead>" +
                            "   <tbody>" +
                                body +
                            "   </tbody>" +
                            "</table>" +
                            "<b>¿Deseas continuar con el registro?</b><br>" +
                            "<small><small>(Se establecerá el fin de vigencia para la plantilla existente)</small></small>",
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: 'No, Cancelar',
                            confirmButtonText: 'Si, Continuar',

                        }
                        ).then(function (){
                            self.confirm_save();
                        }).catch(swal.noop);
                    } else {
                        self.confirm_save();
                    }
                }
            });
        },

        confirm_save: function() {
            var self = this;
            swal({
                title: "Guardar Plantilla",
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
            var url = App.host + '/sistema_contable/poliza_tipo';
            var data = self.form.poliza_tipo;

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
                        html: "Se ha creado la plantilla para el Tipo de Póliza<br>" +
                        "<b>" + self.polizas_tipo_sao[self.form.poliza_tipo.id_poliza_tipo_sao] + "</b>",
                        type: "success"
                    });
                    window.location = xhr.getResponseHeader('Location');
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        remove_movimiento:function (e) {
            Vue.delete(this.form.poliza_tipo.movimientos,e);
        },

        getTipoCuentaDescription: function (id) {
            var result = "";
            $.each(this.tipos_cuentas_contables, function (index, tipo_cuenta_contable) {
                if(tipo_cuenta_contable.id_tipo_cuenta_contable == id) {
                    result = tipo_cuenta_contable.descripcion;
                }
            });
            return result;
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_cuenta') {
                    this.add_movimiento();
                } else if (funcion == 'save') {
                    this.check_duplicity();
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
