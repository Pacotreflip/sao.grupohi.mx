Vue.component('traspaso-cuentas-index', {
    props: [
        'url_traspaso_cuentas_index', 'cuentas', 'monedas',
        'actions_permission',
        'permission_consultar_traspaso_cuenta',
        'permission_eliminar_traspaso_cuenta',
        'permission_editar_traspaso_cuenta'],
    data: function () {
        return {
            'data': {
                'cuentas': this.cuentas,
                'monedas': this.monedas,
                'ver': [],
                'item':''
            },
            'form': {
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
            'guardando': false,
            'peticion': false,
            'table': ''
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
    mounted: function () {
        var self = this;
        $(document).delegate('.modal_ver_traspaso', 'click', function () {
            self.peticio = false;
            var id = $(this).data('id_traspaso');
            self.show(id);
            $.when(self.peticion =true).done(function() {
                self.modal_ver_traspaso()
            });
        });
        $(document).delegate('.confirm_eliminar', 'click', function () {
            var id = $(this).data('id_traspaso');
            self.confirm_eliminar(id);
        });

        $(document).delegate('.modal_editar', 'click', function () {
            self.peticio = false;
            var id = $(this).data('id_traspaso');
            self.show(id);
            $.when(self.peticion =true).done(function() {
                self.modal_editar()
            });
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            "order": [
                [1, "desc"]
            ],
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/api/tesoreria/traspaso_cuentas',
                "type": "POST",
                "headers": {
                    'Authorization': localStorage.getItem('token')
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", localStorage.getItem('token'));
                },
                "dataSrc": function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].index = i + 1;
                        json.data[i].fecha = '$&nbsp;' + new Date(json.data[i].fecha).dateFormat();
                        json.data[i].importe = '$&nbsp; ' + parseFloat(json.data[i].importe).formatMoney(2, '.', ',');
                        json.data[i].referencia = '$&nbsp; ' + son.data[i].traspaso_transaccion.transaccion_debito.referencia;
                    }
                    return json.data;
                }
            },
            "columns": [
                {data: 'index', 'searchable': false, orderable: false},
                {data: 'numero_folio', 'searchable': true},
                {data: 'fecha', 'searchable': true},
                {
                    data: {},
                    render: function (data) {
                        var html = ' ' + data.cuenta_origen.numero + ' ' + data.cuenta_origen.abreviatura + '(' + data.cuenta_origen.empresa.razon_social + ')';
                        return html;
                    },
                    orderable: false, 'searchable': false
                },
                {
                    data: {},
                    render: function (data) {
                        var html = '' + data.cuenta_destino.numero + ' ' + data.cuenta_destino.abreviatura + '(' + data.cuenta_destino.empresa.razon_social + ')';
                        return html;
                    },
                    orderable: false, 'searchable': false
                },
                {data: 'importe', 'searchable': false, orderable: false},
                {data: 'referencia', 'searchable': false, orderable: false}
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        };
        if (self.actions_permission) {
            var $a = {
                data: {},
                render: function (data) {
                    var html = "";
                    if (self.actions_permission) {
                        html += "";
                        if (self.permission_consultar_traspaso_cuenta) {
                            html += '<div class="btn-group">\n' +
                                '<button type="button" title="Ver" class="btn btn-xs btn-success modal_ver_traspaso" data-id_traspaso="' + data.id_traspaso + '" ><i class="fa fa-eye"></i></button>\n' +
                                '</div>';
                        }
                        if (self.permission_eliminar_traspaso_cuenta) {
                            html += '<div class="btn-group">\n' +
                                '<button type="button" title="Eliminar" class="btn btn-xs btn-danger confirm_eliminar"  data-id_traspaso="' + data.id_traspaso + '" ><i class="fa fa-trash"></i></button>\n' +
                                '</div>';
                        }
                        if (self.permission_editar_traspaso_cuenta) {
                            html += ' <div class="btn-group">\n' +
                                '<button title="Editar" class="btn btn-xs btn-info modal_editar" type="button" data-id_traspaso="' + data.id_traspaso + '" > <i class="fa fa-edit"></i></button>\n' +
                                '</div>';
                        }

                    }
                    return html;
                },
                orderable: false, 'searchable': false
            };
            data.columns.push($a);
        }
        self.table = $('#tableTraspasos').DataTable(data);

        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form, 'vencimiento', $('#cumplimiento').val());
            Vue.set(self.form, 'cumplimiento', $('#cumplimiento').val());
        });
        $("#Fecha").datepicker().on("changeDate", function () {
            var thisElement = $(this);

            Vue.set(self.form, 'fecha', thisElement.val());
            thisElement.datepicker('hide');
            thisElement.blur();
            self.$validator.validate('required', self.form.fecha);
        });
        $(".fechas_edit").datepicker().on("changeDate", function () {
            var thisElement = $(this);
            var id = thisElement.attr('id').replace('edit_', '');

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
        confirm_guardar_traspaso: function () {
            var self = this;
            swal({
                title: "Guardar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if (result.value) {
                    self.guardar_traspaso();
                }
            }).catch(swal.noop);
        },
        guardar_traspaso: function () {
            var self = this;
            $.ajax({
                type: 'PUT',
                url:  App.host + '/api/tesoreria/traspaso_cuentas/'+self.form.id_traspaso,
                data: self.form,
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    // Si data.traspaso es un string hubo un error al guardar el traspaso
                    if (typeof data.data.traspaso === 'string') {
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.traspaso
                        });
                    }
                    else {
                        //self.data.traspasos.push(data.data.traspaso);
                        self.table.ajax.reload( null, false );
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
        confirm_eliminar: function (id_traspaso) {
            var self = this;
            swal({
                title: "Eliminar traspaso",
                text: "¿Estás seguro/a de que deseas eliminar este traspaso?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if (result.value) {
                    self.eliminar(id_traspaso);
                }
            }).catch(swal.noop);
        },
        eliminar: function (id_traspaso) {
            var self = this;
            $.ajax({
                type: 'DELETE',
                url: App.host+"/api/tesoreria/traspaso_cuentas/" + id_traspaso,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {
                    self.table.ajax.reload( null, false );
                    /*self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === id_traspaso) {
                            self.data.traspasos.splice(self.data.traspasos.indexOf(traspaso), 1);
                            $('#tableTraspasos').ajax.reload( null, false );
                        }
                    });*/

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso eliminado'
                    });
                },
                complete: function () {
                }
            });
        },
        modal_ver_traspaso: function () {
            var self = this;

            Vue.set(this.data, 'ver', self.item);
            Vue.set(this.data.ver, 'fecha', new Date(self.item.traspaso_transaccion.transaccion_debito.fecha).dateFormat());
            Vue.set(this.data.ver, 'importe', "$ " + parseFloat(self.item.importe).formatMoney(2, ',', '.'));
            Vue.set(this.data.ver, 'cumplimiento', new Date(self.item.traspaso_transaccion.transaccion_debito.cumplimiento).dateFormat());
            Vue.set(this.data.ver, 'vencimiento', new Date(self.item.traspaso_transaccion.transaccion_debito.vencimiento)).dateFormat();
            Vue.set(this.data.ver, 'referencia', self.item.traspaso_transaccion.transaccion_debito.referencia);
            Vue.set(this.data.ver, 'cuenta_origen_texto', self.item.cuenta_origen.numero + ' ' + self.item.cuenta_origen.abreviatura + ' (' + self.item.cuenta_origen.empresa.razon_social + ')');
            Vue.set(this.data.ver, 'cuenta_destino_texto', self.item.cuenta_destino.numero + ' ' + self.item.cuenta_destino.abreviatura + ' (' + self.item.cuenta_destino.empresa.razon_social + ')');

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
        modal_editar: function () {
            var self = this;
            Vue.set(this.traspaso_edit, 'id_traspaso', self.item.id_traspaso);
            Vue.set(this.traspaso_edit, 'id_cuenta_origen', self.item.id_cuenta_origen);
            Vue.set(this.traspaso_edit, 'id_cuenta_destino', self.item.id_cuenta_destino);
            Vue.set(this.traspaso_edit, 'observaciones', self.item.observaciones);
            Vue.set(this.traspaso_edit, 'importe', self.item.importe);
            Vue.set(this.traspaso_edit, 'fecha', new Date(self.item.traspaso_transaccion.transaccion_debito.fecha).dateFormat());
            Vue.set(this.traspaso_edit, 'cumplimiento', new Date(self.item.traspaso_transaccion.transaccion_debito.cumplimiento).dateFormat());
            Vue.set(this.traspaso_edit, 'vencimiento', new Date(self.item.traspaso_transaccion.transaccion_debito.vencimiento).dateFormat());
            Vue.set(this.traspaso_edit, 'referencia', self.item.traspaso_transaccion.transaccion_debito.referencia);

            this.validation_errors.clear('form_editar_traspaso');
            $('#edit_traspaso_modal').modal('show');
            $('#edit_id_cuenta_origen').focus();
        },
        confirm_editar: function () {
            var self = this;
            swal({
                title: "Editar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if (result.value) {
                    self.editar();
                }
            }).catch(swal.noop);
        },
        editar: function () {
            var self = this;

            self.traspaso_edit._method = 'PATCH';
            $.ajax({
                type: 'PUT',
                url :  App.host+"/api/tesoreria/traspaso_cuentas/" + self.traspaso_edit.id_traspaso,
                data: self.traspaso_edit,
                beforeSend: function () {
                },
                success: function (data, textStatus, xhr) {
                    self.table.ajax.reload( null, false );
                    /*self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === data.data.traspaso.id_traspaso) {
                            Vue.set(self.data.traspasos, self.data.traspasos.indexOf(traspaso), data.data.traspaso);
                        }
                    });*/
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
                    self.confirm_guardar_traspaso();
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
        show: function (id) {
            var self = this;
            $.ajax({
                type: 'get',
                async:false,
                url : App.host+"/api/tesoreria/traspaso_cuentas/" + id,
                success: function (data, textStatus, xhr) {
                    self.item = data.data;
                    self.peticion = true;
                },
                complete: function () {
                    self.peticion = true;
                }
            });
        }
    }
});