Vue.component('cambio-presupuesto-index', {
    data: function () {
        return {
            data: '',
            form: {
                id_tipo_cobrabilidad: '',
                id_tipo_orden: ''
            },
            tipos_cobrabilidad: [],
            tipos_orden: []
        }
    },
    computed: {
        tipos_orden_filtered : function () {
            var self = this;

            return self.tipos_orden.filter(function (tipo_orden) {
                return tipo_orden.id_tipo_cobrabilidad == self.form.id_tipo_cobrabilidad;
            });
        }
    },
    mounted: function () {
        var self=this;

        this.fetchTiposCobrabilidad();
        this.fetchTiposOrden();

        $(document).on('click', '.mostrar_pdf', function () {
            var _this = $(this),
                id = _this.data('pdf_id'),
                url = App.host + '/control_presupuesto/cambio_presupuesto/'+ id +'/pdf';

            $('#pdf_modal').modal('show');
            $('#pdf_modal .modal-content').css({height: '700px'});
            $('#pdf_modal .modal-body').html($('<iframe/>', {
                id:'formatoPDF',
                src: url,
                style:'width:99.6%;height:100%',
                frameborder:"0"
            })).css({height: '550px'});

        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "ajax": {
                "url": App.host + '/control_presupuesto/cambio_presupuesto/paginate',
                "type": "POST",
                "beforeSend": function () {
                   // self.guardando = true;
                },
                "complete": function () {
                    //self.guardando = false;
                },
                "dataSrc": function (json) {


                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].registro = json.data[i].user_registro.nombre + ' ' + json.data[i].user_registro.apaterno + ' ' + json.data[i].user_registro.amaterno;
                    }

                    return json.data;
                }
            },
            "columns": [
                {data: 'numero_folio'},
                {data: 'tipo_orden.descripcion'},
                {data: 'created_at'},
                {data: 'registro', orderable: false},
                {data: 'estatus.descripcion'},
                {
                    data: {},
                    render: function(data, type, row, meta) {
                        var  button='<span class="label" ></span><button class="btn btn-xs btn-info mostrar_pdf" data-pdf_id="'+ row.id +'" title="Formato"><i class="fa fa-file-pdf-o"></i></button>  ';
                            button+='<a title="Ver" href="'+App.host+'/control_presupuesto/cambio_presupuesto/'+data.id+'">';
                        button+='<button title="Ver" type="button" class="btn btn-xs btn-default" >';
                        button+='<i class="fa fa-eye"></i>';
                        button+='   </button>';
                        button+='  </a>';
                       return button;
                    },
                    orderable: false
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


        $('#cierres_table').DataTable(data);
    },
    methods: {
        fetchTiposCobrabilidad: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_cobrabilidad',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                success : function (response) {
                    self.tipos_cobrabilidad = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        },
        fetchTiposOrden: function () {
            var self = this;
            $.ajax({
                url : App.host + '/control_presupuesto/tipo_orden',
                type : 'GET',
                beforeSend : function () {
                    self.cargando = true
                },
                success : function (response) {
                    self.tipos_orden = response;
                },
                complete : function () {
                    self.cargando = false;
                }
            });
        },
        openSelectModal: function () {
            $('#select_modal').modal('show');
        },

        crearSolicitud: function () {
            var self = this,
                tipo_seleccionado = self.findTipoOrden(self.form.id_tipo_orden);

                if (tipo_seleccionado === null)
                    swal({
                        title: 'Error',
                        text: "El item seleccionado no es un tipo de solicitud válido",
                        type: 'error'
                    });

            // Redirecciona a la ruta correcta
            window.location.href = App.host + '/control_presupuesto/'+ tipo_seleccionado.name +'/create';
        },
        findTipoOrden: function (id) {
            var self = this;

            for (var i = 0; i < self.tipos_orden.length; i++)
                if (self.tipos_orden[i]['id'] === id)
                    return self.tipos_orden[i];

            return null;
        }
    }

});