Vue.component('procuracion-asignacion-create', {
    props: [
        'url_success'
    ],
    data: function () {
        return {
            'form': {
                tipo_transaccion: '',
                id_transaccion: '',
                id_usuario_asignado: []
            },
            'tipotransaccion': [],
            'idtransaccion':[],
            'idusuarioasignado': [],
            'guardando' : false,
            'cargando_transacciones' : false,
            'table': '',
            'mostrartable': false,
            'registro': [],
            'dataUsuarios': []
        }
    },
    mounted: function () {
        var self = this;
        $.ajax({
            type : 'POST',
            url : App.host + '/api/tipoTran',
            data: {paramters : [{Tipo_Transaccion: 17, Opciones: 1}, {Tipo_Transaccion: 49, Opciones: 1026}]},
            headers: {
                'Authorization': localStorage.getItem('token')
            },
            beforeSend: function () {},
            success: function (data, textStatus, xhr) {
                var dataTipoTransaccion = [];
                $.each(data,function (index,value) {
                    dataTipoTransaccion.push({
                        id: value.Tipo_Transaccion.trim(),
                        text: value.Descripcion.trim()
                    });
                });
                $('#tipo_transaccion').select2({
                    data: dataTipoTransaccion
                }).on('select2:select', function (e) {
                    var data = e.params.data;
                    self.selectTipoTransaccion(data.id);
                    self.form.tipo_transaccion = data.id;
                    self.tipotransaccion = {id:data.id,name:data.text};
                });
            },
            complete: function () { }
        });

        $.ajax({
            type : "POST",
            url : App.host + "/api/usuario",
            data: {roles:["comprador"]},
            headers: {
                'Authorization': localStorage.getItem('token')
            },
            beforeSend: function () {},
            success: function (data, textStatus, xhr) {
                var dataUsuarios = [];
                $.each(data,function (index,value) {
                    dataUsuarios.push({
                        id: value.idusuarios,
                        text: value.name
                    });
                });
                $('#id_usuario_asignado').select2({
                    data: dataUsuarios,
                    multiple: true,
                    placeholder: "[--SELECCIONE--]"
                }).on('select2:select', function (e) {
                    var data = e.params.data;
                    self.form.id_usuario_asignado.push(data.id);
                    self.idusuarioasignado.push({id:data.id,name:data.text});
                });
            },
            complete: function () {}
        });
        self.table = $('#table_asignacion').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'l><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            language: {
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
        });

        self.table.on( 'click', '.remove', function () {
            var row = self.table.row( $(this).parents('tr') );
            self.registro.splice(row.index(),1);
            var rowNode = row.node().remove();
            row.remove();
        });
        $('button').button({loadingText: 'Procesando...'});
    },
    methods: {
        selectTipoTransaccion: function (id) {
            var self = this;
            $("#id_transaccion").val(null).trigger("change");

            $("#id_transaccion").select2({placeholder: "Procesando...."}).html("");

            var url ='' ;
            var col = [];
            if(id=='49'){
                url = App.host + '/api/contratoProyectado';
                col = ['referencia','numero_folio'];
            }
            if(id=='17'){
                url = App.host + '/api/compras/requisicion';
                col = ['observaciones','numero_folio'];
            }
            if(url != '') {
                $('#id_transaccion').select2({
                    ajax: {
                        url: url,
                        type: 'POST',
                        delay: 500,
                        dataType: 'json',
                        escapeMarkup: function (markup) {
                            return markup;
                        },
                        data: function (params) {
                            var query = {q: params.term,columns:col}
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data['dbo.transacciones'], function (item) {
                                    var text = item.numero_folio + "-" +((id=='49')?item.referencia.trim():item.observaciones.trim());
                                    return {
                                        text:text,
                                        id: item.id_transaccion
                                    }
                                })
                            };
                        },
                        error: function (error) {

                        },
                        cache: true
                    }
                }).on('select2:select', function (e) {
                    var data = e.params.data;
                    self.form.id_transaccion = data.id;
                    var textSplit = data.text.split('-');
                    self.idtransaccion = {id:data.id,name:textSplit[1],numero_folio:textSplit[0]};
                });
            }else{
                $("#id_transaccion").select2().val(null).trigger("change");
            }
        },
        agregarRegistro: function () {
            var self = this;
            self.mostrartable = true;
            $.each(self.idusuarioasignado,function (index, value) {
                var found = self.registro.find(function(element) {
                    return (element.id_usuario_asignado === value.id && element.id_transaccion === self.idtransaccion.id);
                });
                if(found) {
                    swal({
                        type: 'warning',
                        title: 'Advertencia',
                        text: 'El elemento que intenta agregar, ya a sido agregardo al listado'
                    });
                }else{
                    var rowNode = self.table.row.add([
                        self.tipotransaccion.name,
                        self.idtransaccion.numero_folio,
                        self.idtransaccion.name,
                        value.name,
                        "<button class='remove' ><i class=\"fa fa-trash\"></i></button>"
                    ]).draw(true);
                    self.registro[rowNode.index()] = {
                        "tipo_transaccion": self.tipotransaccion.id,
                        "id_transaccion": self.idtransaccion.id,
                        "id_usuario_asignado": value.id
                    };
                }
            });

            Vue.set(self.form, 'tipo_transaccion', '');
            Vue.set(self.form, 'id_transaccion', '');
            Vue.set(self.form, 'id_usuario_asignado', []);
            self.idusuarioasignado = [];
            self.idtransaccion = [];
            self.tipotransaccion = [];
            $("#tipo_transaccion").select2({placeholder: "[--SELECCIONE--]"}).val(null).trigger("change");
            $("#id_transaccion").select2({placeholder: "[--SELECCIONE--]"}).val(null).trigger("change").html("");
            $("#id_usuario_asignado").select2({placeholder: "[--SELECCIONE--]"}).val(null).trigger("change");

            setTimeout(function() {
                self.validation_errors.clear('form_agregar_asignacion');
            }, 1);

        },
        confirm_guardar: function(id_btn) {


            var self = this;
            var $btn = $("#"+id_btn);
            $btn.button('loading');
            if(self.registro.length>0){
                swal({
                    title: "Guardar Asignaciones",
                    text: "¿Estás seguro/a de que la información es correcta?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, Continuar",
                    cancelButtonText: "No, Cancelar",
                }).then(function (result) {
                    if (result.value) {
                        self.guardar(id_btn);
                    }else{
                        $("#"+id_btn).button('reset');
                    }
                }).catch(swal.noop);
            }else {
                $("#"+id_btn).button('reset');
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor debe por lo menos asignar a  un comprador'
                });
            }
        },
        guardar: function(id_btn) {
            var self = this;
            $.ajax({
                type : 'POST',
                url : App.host + '/api/procuracion/asignacion/masivas',
                data: {asignaciones:self.registro},
                success: function (data, textStatus, xhr) {
                    $("#"+id_btn).button('reset');
                    if(data.exists.length==0) {
                        self.table
                            .clear()
                            .draw();
                        swal({
                            type: 'success',
                            title: '¡Correcto!',
                            html: 'Las Asignaciones se guardaron correctamente'
                        }).then(function () {
                            window.location = self.url_success;
                        });
                    }else{
                        var total_exists = data.exists.length;
                        var total_env = self.registro.length;
                        var html = "Algunos elementos ya existen en la asignación<br> " +
                            "<div class=\"table-responsive\">" +
                            "<table class='table table-bordered table-striped' style='font-size: 10px;'>" +
                            "<tr>" +
                            "<td>Folio de la Transacción</td>" +
                            "<td>Tipo de Transacción</td>" +
                            "<td>Nombre del Comprador Asignado</td>" +
                            "</tr>";
                        $.each(data.exists, function (index, value) {

                            html += "<tr>";
                            html += "<td>" + value.transaccion.numero_folio + "</td>";
                            html += "<td>" + value.transaccion.tipo_tran.Descripcion + "</td>";
                            html += "<td>" + value.usuario_asignado.nombre +" "+ value.usuario_asignado.apaterno +" "+ value.usuario_asignado.amaterno + "</td>";
                            html += "</tr>";

                        });
                        html += "</table>" +
                            "</div>";
                        swal({
                            type: 'success',
                            title: '¡Correcto!',
                            //html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                            html: html
                        }).then(function () {
                            /*if(total_exists>0){
                                var warning = new Array();
                                $.each(data.exists,function (index, value) {
                                    var found = self.registro.findIndex(function (element) {
                                        return (parseInt(element.id_usuario_asignado) === parseInt(value.id_usuario_asignado) && parseInt(element.id_transaccion) === parseInt(value.id_transaccion));
                                    });
                                    if(found>=0) {
                                        warning.push(found);
                                    }
                                });
                                console.log(warning);
                                self.table.rows().each( function ( indexTable ) {
                                    console.log('indices de las tabla---',indexTable);
                                    $.each(indexTable,function (index,value) {
                                        var row = self.table.row(value);
                                        console.log(value,warning,$.inArray(value,warning));
                                        if($.inArray(value,warning)<0){
                                            var rowNode = row.node().remove();
                                            row.remove();
                                        }else{
                                            $(row.node()).addClass('danger');
                                        }
                                    });
                                } );
                            }else {*/
                                window.location = self.url_success;
                            //}
                        });
                    }
                },
                error:function () {
                    swal({
                        type: 'warning',
                        title: 'Advertencia',
                        text: 'Error no se pudo guardar ninguna asignación.'
                    });
                    $("#"+id_btn).button('reset');
                }
            });
        },
        validateForm: function(scope, funcion) {
            self = this;
            this.$validator.validateAll(scope).then(() => {
                if(funcion === 'agregar_asignacion') {
                    self.agregarRegistro();
                }
            }).catch((res) => {
                swal({
                     type: 'warning',
                     title: 'Advertencia',
                     text: 'Por favor corrija los errores del formulario'
                 });
            });
        },
    }
});