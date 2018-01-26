Vue.component('variacion-volumen', {
    props : ['filtros', 'niveles', 'id_tipo_orden', 'id_tarjeta'],
    data : function () {
        return {
            form : {
                partidas : [],
                motivo : ''
            },
            cargando : false,
            guardando : false
        }
    },

    computed : {
        datos : function () {
            var res = {
                id_tipo_orden: this.id_tipo_orden,
                motivo: this.form.motivo,
                partidas: []
            };

            this.form.partidas.forEach(function (value) {
                res.partidas.push({
                    id_concepto : value.id_concepto,
                    cantidad_presupuestada_original : value.cantidad_presupuestada,
                    cantidad_presupuestada_nueva : value.cantidad_presupuestada_nueva
                });
            });
            return res;
        }
    },

    mounted: function () {
        var self = this;

        $(document).on('click', '.btn_add_concepto', function () {
            var id = $(this).attr('id');
            self.addConcepto(id);
        }).on('click', '.btn_remove_concepto', function() {
            var id = $(this).attr('id');
            self.removeConcepto(id);
        });

        $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : false,
            "ajax": {
                "url": App.host + '/conceptos/getPathsConceptos',
                "type" : "POST",
                "beforeSend" : function () {
                    self.cargando = true;
                },
                "data": function ( d ) {
                    d.filtros = self.filtros;
                    d.id_tarjeta = self.id_tarjeta
                },
                "complete" : function () {
                    self.cargando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                        json.data[i].cantidad_presupuestada = parseInt(json.data[i].cantidad_presupuestada).formatMoney(2, ',', '.');
                        json.data[i].precio_unitario = '$' + parseInt(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'filtro1'},
                {data : 'filtro2'},
                {data : 'filtro3'},
                {data : 'filtro4'},
                {data : 'filtro5'},
                {data : 'filtro6'},
                {data : 'filtro7'},
                {data : 'filtro8'},
                {data : 'filtro9'},
                {data : 'filtro10'},
                {data : 'filtro11'},
                {data : 'unidad'},
                {data : 'cantidad_presupuestada', className : 'text-right'},
                {data : 'precio_unitario', className : 'text-right'},
                {data : 'monto_presupuestado', className : 'text-right'},
                {
                    data : {},
                    render : function (data) {
                        if (self.existe(data.id_concepto)) {
                            return '<button class="btn btn-xs btn-default btn_remove_concepto" id="'+data.id_concepto+'"><i class="fa fa-minus text-red"></i></button>';
                        }
                        return '<button class="btn btn-xs btn-default btn_add_concepto" id="'+data.id_concepto+'"><i class="fa fa-plus text-green"></i></button>';
                    }
                }
            ],
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
    },

    methods : {
        get_conceptos : function () {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        },

        addConcepto : function (id) {
            var self = this;
            $.ajax({
                url : App.host + '/conceptos/' + id,
                type : 'GET',
                beforeSend : function () {
                    self.guardando = true;
                    $('#'+id).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#'+id).attr('disabled', true);

                },
                success : function (response) {
                    self.form.partidas.push(response);
                    $('#'+id).html('<i class="fa fa-minus text-red"></i>');
                    $('#'+id).removeClass('btn_add_concepto');
                    $('#'+id).addClass('btn_remove_concepto');
                },
                complete : function () {
                    self.guardando = false;
                    $('#'+id).attr('disabled', false);
                },
                error: function () {
                    $('#'+id).html('<i class="fa fa-plus text-green"></i>');
                }
            });
        },

        existe : function (id) {
            var found = this.form.partidas.find(function (partida) {
                return partida.id_concepto == id;
            });
            return found != undefined;
        },

        confirmSave: function () {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
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

        save : function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/cambio_presupuesto',
                type : 'POST',
                data : self.datos,
                beforeSend : function () {
                    self.cargando = true;
                },
                success : function (response) {
                    swal({
                        type : 'success',
                        title : '¡Correcto!',
                        html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                    }).then(function () {
                        $('#conceptos_modal').modal('hide');
                        self.form.partidas = [];
                        self.$emit('reset-filtros');
                        Vue.set(self.form, 'motivo', '');
                        $('#conceptos_table').DataTable().ajax.reload();
                    });
                },
                complete : function () {
                    self.cargando = false;
                }
            })
        },

        removeConcepto : function (id) {
            var index = this.form.partidas.map(function (partida) { return partida.id_concepto; }).indexOf(parseInt(id));
            this.form.partidas.splice(index, 1);
            $('#'+id).html('<i class="fa fa-plus text-green"></i>');
            $('#'+id).addClass('btn_add_concepto');
            $('#'+id).removeClass('btn_remove_concepto');
            if(!this.form.partidas.length) {
                $('#conceptos_modal').modal('hide');
            }
        },

        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'save_solicitud') {
                    this.confirmSave();
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