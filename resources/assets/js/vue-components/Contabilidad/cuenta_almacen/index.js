Vue.component('cuenta-almacen-index', {
    props: ['datos_contables', 'editar_cuenta_almacen', 'registrar_cuenta_almacen'],
    data: function() {
        return {
            'data' : {
                'almacen_edit': {}
            },
            'form': {
                'cuenta_almacen': {
                    'id': '',
                    'id_almacen': '',
                    'cuenta' : ''
                }
            },
            'guardando' : false
        }
    },

    mounted: function () {
        var self = this;

        $(document).on('click', '.btn_edit', function () {
            var id = $(this).attr('id');
            self.editar(id);
        });


        var data = {
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "searching" : false,
            "order": [
                [1, "asc"]
            ],
            "ajax": {
                "url": App.host + '/almacen/paginate',
                "type" : "POST",
                "beforeSend" : function () {
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].index = i + 1;
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'index', orderable : false},
                {data : 'descripcion'},
                {data : 'tipo_almacen'},
                {
                    data : {},
                    render : function (data) {
                        return (data.cuenta_almacen != null && data.cuenta_almacen.cuenta != null ? data.cuenta_almacen.cuenta : '---')
                    },
                    orderable : false
                },
                {
                    data : {},
                    render : function (data){
                        return '<div class="btn-group">' +
                            '     <button id="'+data.id_almacen+'" title="'+(data.cuenta_almacen != null ? 'Editar' : 'Registrar')+'" class="btn btn-xs btn_edit btn-'+(data.cuenta_almacen != null ? 'info' : 'success')+'" type="button">' +
                            '       <i class="fa fa-edit"></i>' +
                            '     </button>' +
                            '   </div>'
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
        };

        $('#almacenes_table').DataTable(data);
    },

    methods:{
        editar:function (id_almacen){

            var self = this;

            $.ajax({
                url : App.host + '/almacen/' + id_almacen,
                type : 'GET',
                beforeSend : function () {
                    self.guardando = true;
                },
                success : function (response) {
                    self.data.almacen_edit = response;
                    Vue.set(self.form.cuenta_almacen, 'id_almacen', response.id_almacen);
                    if(response.cuenta_almacen != null){
                        Vue.set(self.form.cuenta_almacen, 'cuenta', response.cuenta_almacen.cuenta);
                        Vue.set(self.form.cuenta_almacen, 'id', response.cuenta_almacen.id);
                    }else{
                        Vue.set(self.form.cuenta_almacen, 'cuenta', '');
                        Vue.set(self.form.cuenta_almacen, 'id', '');
                    }
                    self.validation_errors.clear('form_edit_cuenta');
                    $('#edit_cuenta_modal').modal('show');
                    $('#cuenta_contable').focus();
                    self.validation_errors.clear('form_edit_cuenta');
                },
                complete : function () {
                    self.guardando = false;
                }
            });
        },
        validateForm: function(scope, funcion) {
            this.$validator.validateAll(scope).then(() => {
                if(funcion == 'confirm_save_cuenta') {
                this.confirm_save_cuenta();
            } else if (funcion == 'confirm_update_cuenta') {
                this.confirm_update_cuenta();
            }
        }).catch(() => {
                swal({
                         type: 'warning',
                         title: 'Advertencia',
                         text: 'Por favor corrija los errores del formulario'
                     });
        });
        },
        confirm_update_cuenta: function () {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
        },

        update_cuenta: function () {
            var self = this;
            var url = App.host + '/sistema_contable/cuenta_almacen/' + self.form.cuenta_almacen.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta_almacen.cuenta
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    $('#almacenes_table').DataTable().ajax.reload(null, false);
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;

                }
            });
        },

        confirm_save_cuenta: function () {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value)
                    self.save_cuenta();
            });
        },

        save_cuenta: function () {
            var self = this;

            $.ajax({
                type: 'POST',
                url: App.host + '/sistema_contable/cuenta_almacen',
                data: {
                    cuenta: self.form.cuenta_almacen.cuenta,
                    id_almacen: self.form.cuenta_almacen.id_almacen
                },
                beforeSend: function () {
                    self.guardando = true;
                },
                success: function (data, textStatus, xhr) {
                    $('#almacenes_table').DataTable().ajax.reload(null, false);
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente',
                    });
                },
                complete: function () {
                    self.guardando = false;
                }
            });
        },
        close_edit_cuenta: function () {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form.cuenta_almacen, 'cuenta', '');
            Vue.set(this.form.cuenta_almacen, 'id', '');
            Vue.set(this.form.cuenta_almacen, 'id_almacen', '');
        }

    }
});
