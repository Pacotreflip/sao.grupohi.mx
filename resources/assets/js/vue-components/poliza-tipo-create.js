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
            self.check_fecha($('#inicio_vigencia').val());
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
            var result = {};
            $.each(this.cuentas_contables, function (index, cuenta_contable) {
                var existe = false;
                self.form.poliza_tipo.movimientos.forEach(function (movimiento) {
                    if(index == movimiento.id_cuenta_contable) {
                        existe = true;
                    }
                });

                if(! existe) {
                    result[index] = cuenta_contable;
                } else {
                    Vue.delete(result, index);
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
                    startDate: '0d',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
                $(el).val(App.timeStamp(1));
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
                    if(response) {
                        var body = "";
                        $.each(response.movimientos, function (index, movimiento) {
                            body += "<tr><td>"+(index+1)+"</td><td>"+ self.cuentas_contables[movimiento.id_cuenta_contable] +"</td><td>"+self.tipos_movimiento[movimiento.id_tipo_movimiento]+"</td></tr>"
                        });
                        swal({
                            title: "Advertencia",
                            text: "Ya existe una Plantilla para el tipo de Póliza seleccionado con los siguientes movimientos <br>" +
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
                            html: true,
                            showCancelButton: true,
                            cancelButtonText: 'No, Cancelar',
                            confirmButtonText: 'Si, Continuar',
                            closeOnConfirm: false
                        },
                        function(){
                            self.confirm_save();
                        });
                    } else {
                        self.confirm_save();
                    }
                },
                error: function (error) {

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
                closeOnConfirm: false
            },
            function(){
                self.save();
            });
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
                    console.log(xhr.status);
                    console.log(xhr.getResponseHeader('Location'));
                    swal({
                        title: "Correcto",
                        text: "Se ha creado la plantilla para el Tipo de Póliza<br>" +
                        "<b>" + self.transacciones_interfaz[self.form.poliza_tipo.id_transaccion_interfaz] + "</b>",
                        html: true,
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    },
                    function(){
                        window.location = xhr.getResponseHeader('Location');
                    });
                },
                error: function (error) {
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },

        remove_movimiento:function (e) {
            Vue.delete(this.form.poliza_tipo.movimientos,e);
        },

        check_fecha: function (date) {
            alert(date);

            var id = this.form.poliza_tipo.id_transaccion_interfaz;

            $.ajax({
                type: 'GET',
                url: App.host + '/modulo_contable/poliza_tipo/' + id + '/check_fecha',
                data: {
                    fecha: date
                },
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    //Vue.set(self.form.poliza_tipo, 'inicio_vigencia', date);
                },
                error: function (error) {
                    console.log(error);
                    //Vue.set(self.form.poliza_tipo, 'inicio_vigencia', response);
                }
            });
        }
    }
});
