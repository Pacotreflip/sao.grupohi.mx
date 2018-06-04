Vue.component('pago-cuenta-create', {
    data: function () {
        return {
            form: {
                cumplimiento: new Date().dateShortFormat(),
                vencimiento: new Date().dateShortFormat(),
                destino: '',
                fecha: new Date().dateShortFormat(),
                id_empresa: '',
                observaciones: '',
                monto: '',
                id_costo: ''
            },
            empresas: {},
            cargando: true,
            guardando: false
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
    watch : {
        'form.id_empresa' : function (id) {
            if(id) {
                this.setAFavorDe(id);
            } else {
                this.form.destino = '';
            }
        }
    },
    mounted: function () {

        var self = this;

        self.getEmpresas();
        self.carga_arbol();
        $('#cumplimiento').datepicker().on("changeDate", function() {
            self.form.cumplimiento = $('#cumplimiento').val();
        });

        $('#fecha').datepicker().on("changeDate", function() {
            self.form.fecha = $('#fecha').val();
        });

        $('#vencimiento').datepicker().on("changeDate", function() {
            self.form.vencimiento = $('#vencimiento').val()
        });
    },
    methods: {
        carga_arbol: function() {
            var self = this;
            
            var jstreeConf = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function (node) {
                            var costos = "";
                            if (node.id === "#") {
                                return App.host + '/api/costo/jstree';
                            }
                            return App.host + '/api/costo/' + node.id + '/jstree';
                        },
                        "data": function (node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'default': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'opened': {
                        'icon': 'fa fa-folder-open-o text-success'
                    }
                },
                'plugins': ['types']
            };

            $('#myModal').on('shown.bs.modal', function (e) {
                $('#jstree').jstree(jstreeConf);
            }).on('hidden.bs.modal', function (e) {
                var jstree = $('#jstree').jstree(true);
                var node = jstree.get_selected(true)[0];

                if (node) {
                    self.form.id_costo = node.id;
                    $('#costo').val(node.text);
                }
            });
        },
        getEmpresas: function() {
            var self = this;
            $.ajax({

                url: App.host + '/api/empresa/lists',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Authorization': localStorage.getItem('token')
                },
                success: function(data) {
                    self.empresas = data;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_pago') {
                this.confirmSave();

            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },
        confirmSave: function () {
            var self = this;
            swal({
                title: 'Guardar Pago a Cuenda',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function(result) {
                if(result.value) {
                    self.save();
                }
            });
        },
        setAFavorDe: function(id) {
            var self = this;
            $.ajax({
                url: App.host + '/api/empresa/' + id,
                type: 'GET',
                beforeSend: function () {
                    self.cargando = true;
                },
                success: function (response) {
                    self.form.destino = response.data.razon_social;
                },
                complete: function () {
                    self.cargando = false;
                }
            });
        },

        save: function () {
            var self = this;
            $.ajax({
                url : App.host + '/api/finanzas/solicitud_cheque/pago_cuenta',
                type : 'POST',
                data : self.form,
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function () {
                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Pago a Cuenta guardado correctamente'
                    }).then(function () {
                        location.reload();
                    });
                },
                error: function(error) {
                    console.log(error.responseJSON.errors);

                    $.each(error.responseJSON.errors, function(e, key) {

                        var field = $('#' + e );
                        console.log('#' + e );
                        self.validation_errors.errors.push({
                            field: field.attr('name'),
                            msg: key[0],
                            rule: 'valid',
                            scope: 'form_pago_cuenta'
                        });
                    });
                },
                complete : function () {
                    self.guardando = false;
                }
            })
        }
    }
});