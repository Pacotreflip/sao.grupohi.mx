Vue.component('movimientos_bancarios-index', {
    props: ['url_movimientos_bancarios_index', 'cuentas', 'tipos', 'movimientos',
        'actions_permission',
        'permission_consultar_movimiento_bancario',
        'permission_eliminar_movimiento_bancario',
        'permission_editar_movimiento_bancario'],
    data : function () {
        return {
            'data' : {
                'cuentas': this.cuentas,
                'tipos': this.tipos,
                'ver': [],
                'item':''
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
            'movimiento_ver': {
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
            'guardando': false,
            'peticion': false,
            'table': ''
        }
    },
    computed: {},
    mounted: function()
    {
        var self = this;

        var self = this;
        $(document).delegate('.modal_movimiento_ver', 'click', function () {
            self.peticio = false;
            var id = $(this).data('id_traspaso');
            self.show(id);
            $.when(self.peticion =true).done(function() {
                self.modal_movimiento_ver()
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
                "url": App.host + '/api/tesoreria/movimientos_bancarios',
                "type": "POST",
                "headers": {
                    'Authorization': localStorage.getItem('token')
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", localStorage.getItem('token'));
                },
                "dataSrc": function (json) {
                    for (var i = 0; i < json.data.length; i++) {

                        let total = parseFloat(json.data[i].importe) + parseFloat(json.data[i].impuesto);
                        total = total.formatMoney(2, '.', ',');

                        json.data[i].index = i + 1;
                        json.data[i].fecha = new Date(json.data[i].movimiento_transaccion.transaccion.fecha).dateFormat();
                        json.data[i].tipo = json.data[i].tipo.descripcion;
                        json.data[i].cuenta = json.data[i].cuenta.numero + " " + json.data[i].cuenta.abreviatura + " (" + json.data[i].cuenta.empresa.razon_social + ") ";
                        json.data[i].total = '$&nbsp;' + total;
                        json.data[i].importe = '$&nbsp;' + parseFloat(json.data[i].importe).formatMoney(2, '.', ',');
                        json.data[i].impuesto = '$&nbsp;' + parseFloat(json.data[i].impuesto).formatMoney(2, '.', ',');
                        json.data[i].referencia = json.data[i].movimiento_transaccion.transaccion.referencia;
                    }
                    return json.data;
                }
            },
            "columns": [
                {data: 'index', 'searchable': false, orderable: false},
                {data: 'numero_folio', 'searchable': true},
                {data: 'fecha', 'searchable': true},
                {data: 'tipo', 'searchable': true},
                {data: 'cuenta', 'searchable': true},
                {data: 'importe', 'searchable': true},
                {data: 'impuesto', 'searchable': true},
                {data: 'total', 'searchable': true},
                {data: 'referencia', 'searchable': true},
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
                        if (self.permission_consultar_movimiento_bancario) {
                            html += '<div class="btn-group">\n' +
                                '<button type="button" title="Ver" class="btn btn-xs btn-success modal_movimiento_ver" data-id_traspaso="' + data.id_movimiento_bancario + '" ><i class="fa fa-eye"></i></button>\n' +
                                '</div>';
                        }
                        if (self.permission_eliminar_movimiento_bancario) {
                            html += '<div class="btn-group">\n' +
                                '<button type="button" title="Eliminar" class="btn btn-xs btn-danger confirm_eliminar"  data-id_traspaso="' + data.id_movimiento_bancario + '" ><i class="fa fa-trash"></i></button>\n' +
                                '</div>';
                        }
                        if (self.permission_editar_movimiento_bancario) {
                            html += ' <div class="btn-group">\n' +
                                '<button title="Editar" class="btn btn-xs btn-info modal_editar" type="button" data-id_traspaso="' + data.id_movimiento_bancario + '" > <i class="fa fa-edit"></i></button>\n' +
                                '</div>';
                        }

                    }
                    return html;
                },
                orderable: false, 'searchable': false
            };
            data.columns.push($a);
        }
        self.table = $('#tableMovimientos').DataTable(data);

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
        modal_movimiento_ver: function () {
            var self = this;
            Vue.set(this.data, 'ver', self.item);
            Vue.set(this.data.ver, 'tipo_texto', self.item.tipo.descripcion);
            Vue.set(this.data.ver, 'importe', parseFloat(self.item.importe).formatMoney(2, '.', ','));
            Vue.set(this.data.ver, 'impuesto', parseFloat(self.item.impuesto).formatMoney(2, '.', ','));
            Vue.set(this.data.ver, 'cuenta_texto', self.item.cuenta.numero  +' '+ self.item.cuenta.abreviatura +' ('+ self.item.cuenta.empresa.razon_social +')');
            Vue.set(this.data.ver, 'referencia', self.item.movimiento_transaccion.transaccion.referencia);
            Vue.set(this.data.ver, 'cumplimiento', this.trim_fecha(self.item.movimiento_transaccion.transaccion.cumplimiento));
            Vue.set(this.data.ver, 'vencimiento', this.trim_fecha(self.item.movimiento_transaccion.transaccion.vencimiento));

            $('#ver_movimiento_modal').modal('show');
        },
        close_modal_movimiento_ver: function () {

            $('#ver_movimiento_modal').modal('hide');
            Vue.set(this.data, 'ver', {});
        },
        confirm_guardar: function() {
            var self = this;

            $('.guardar_movimiento_boton').addClass('disabled').attr('disabled', 'disabled');

            swal({
                title: "Guardar movimiento",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.guardar();
                }

                else
                    $('.guardar_movimiento_boton').removeClass('disabled').removeAttr("disabled");

            }).catch(swal.noop);
        },
        guardar: function () {
            var self = this;

            $.ajax({
                type: 'POST',
                url :  App.host+"/api/tesoreria/movimientos_bancarios/store",
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
                        //self.data.movimientos.push(data.data.movimiento);
                        self.table.ajax.reload( null, false );
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
            $('.guardar_movimiento_boton').removeClass('disabled').removeAttr("disabled");
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
            }).then(function (result) {
                if(result.value) {
                    self.eliminar(id_movimiento_bancario);
                }
            }).catch(swal.noop);
        },
        eliminar: function (id_movimiento_bancario) {
            var self = this;
            $.ajax({
                type: 'DELETE',
                url: App.host+"/api/tesoreria/movimientos_bancarios/" + id_movimiento_bancario,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {

                    self.table.ajax.reload( null, false );
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Movimiento eliminado'
                    });
                },
                complete: function () { }
            });
        },
        modal_editar: function (){
            var self = this;
            Vue.set(this.movimiento_edit, 'id_movimiento_bancario', self.item.id_movimiento_bancario);
            Vue.set(this.movimiento_edit, 'id_tipo_movimiento', self.item.id_tipo_movimiento);
            Vue.set(this.movimiento_edit, 'estatus', self.item.estatus);
            Vue.set(this.movimiento_edit, 'id_cuenta', self.item.id_cuenta);
            Vue.set(this.movimiento_edit, 'impuesto', self.item.impuesto);
            Vue.set(this.movimiento_edit, 'importe', self.item.importe);
            Vue.set(this.movimiento_edit, 'observaciones', self.item.observaciones);
            Vue.set(this.movimiento_edit, 'fecha', this.trim_fecha(self.item.movimiento_transaccion.transaccion.fecha));
            Vue.set(this.movimiento_edit, 'cumplimiento', this.trim_fecha(self.item.movimiento_transaccion.transaccion.cumplimiento));
            Vue.set(this.movimiento_edit, 'vencimiento', this.trim_fecha(self.item.movimiento_transaccion.transaccion.vencimiento));
            Vue.set(this.movimiento_edit, 'referencia', self.item.movimiento_transaccion.transaccion.referencia);

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
            }).then(function  (result) {
                if(result.value) {
                    self.editar();
                }
            }).catch(swal.noop);
        },
        editar: function () {
            var self = this;

            $.ajax({
                type: 'PUT',
                url :  App.host+"/api/tesoreria/movimientos_bancarios/" + self.movimiento_edit.id_movimiento_bancario,
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
                        self.table.ajax.reload( null, false );
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
        },
        show: function (id) {
            var self = this;
            $.ajax({
                type: 'get',
                async:false,
                url : App.host+"/api/tesoreria/movimientos_bancarios/" + id,
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
