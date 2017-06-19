Vue.component('poliza-tipo-create', {
    props: ['cuentas_contables', 'tipos_movimiento', 'transacciones_interfaz'],
    data: function() {
        return {
            'form' : {
                'poliza_tipo' : {
                    'id_transaccion_interfaz' : '',
                    'movimientos' : [],
                    'inicio_vigencia' : ''
                },
                'movimiento' : {
                    'id_cuenta_contable' : '',
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

        cuentas_contables_disponibles: function () {
            var self = this;
            var result = [];
            $.each(this.cuentas_contables, function (index, cuenta_contable) {
                var existe = false;
                self.form.poliza_tipo.movimientos.forEach(function (movimiento) {
                    if(cuenta_contable.id_int_cuenta_contable == movimiento.id_cuenta_contable) {
                        existe = true;
                    }
                });

                if(! existe) {
                    result.push(cuenta_contable);
                }
            });

            return result;
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
        add_movimiento: function () {
            var id_cuenta_contable = $('#id_cuenta_contable').val();
            var id_tipo_movimiento = $('#id_tipo_movimiento').val();

            this.form.poliza_tipo.movimientos.push({
                id_cuenta_contable: id_cuenta_contable,
                id_tipo_movimiento: id_tipo_movimiento
            });
        },

        reset_movimiento: function () {
            Vue.set(this.form.movimiento, 'id_cuenta_contable', '');
            Vue.set(this.form.movimiento, 'id_tipo_movimiento', '');
        },

        check_duplicity: function () {
            var self = this;
            var id = self.form.poliza_tipo.id_transaccion_interfaz;
            var url = App.host + '/modulo_contable/poliza_tipo/findBy';
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'attribute' : 'id_transaccion_interfaz',
                    'value' : id,
                    'with' : 'movimientos'
                },
                success: function (response) {
                    if(response.data.poliza_tipo != null) {
                        var body = "";
                        $.each(response.data.poliza_tipo.movimientos, function (index, movimiento) {
                            body += "<tr><td>"+(index+1)+"</td><td style='text-align: left'>"+ self.getTipoCuentaDescription(movimiento.id_cuenta_contable) +"</td><td>"+self.tipos_movimiento[movimiento.id_tipo_movimiento]+"</td></tr>"
                        });

                        swal({
                            title: "Advertencia",
                            html: "Ya existe una Plantilla para el tipo de Póliza seleccionado con un estado <b>" + response.data.poliza_tipo.vigencia + "</b><br>" +
                            "Con un inicio de vigencia el día <b>" + response.data.poliza_tipo.inicio_vigencia.split(" ")[0] + "</b><br><br>" +
                            "<table class='table table-striped small'>" +
                            "   <thead>" +
                            "   <tr>" +
                            "       <th style='text-align: center'>#</th>" +
                            "       <th style='text-align: center'>Cuenta Contable</th>" +
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
            var url = App.host + '/modulo_contable/poliza_tipo';
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
                        "<b>" + self.transacciones_interfaz[self.form.poliza_tipo.id_transaccion_interfaz] + "</b>",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                            window.location = xhr.getResponseHeader('Location');
                        })  .catch(swal.noop);
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
            $.each(this.cuentas_contables, function (index, cuenta_contable) {
                if(cuenta_contable.id_int_cuenta_contable == id) {
                    result = cuenta_contable.tipo_cuenta_contable.descripcion;
                }
            });
            return result;
        }
    }
});
