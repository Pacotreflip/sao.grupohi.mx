Vue.component('procuracion-asignacion-index', {
    props: ['permission', 'permission_eliminar_asignacion'],
    data : function () {
        return {
            'data' : {
            },
            'table':''
        }
    },
    mounted: function()
    {
        var self = this;
        var data = {
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'l><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "processing": true,
            "serverSide": true,
            "ordering" : true,
            "bFilter" : true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": App.host + '/api/procuracion/asignacion/paginate',
                "type" : "POST",
                "headers": {
                    'Authorization': localStorage.getItem('token')
                },
                'beforeSend': function (request) {
                    request.setRequestHeader("Authorization", localStorage.getItem('token'));
                    self.guardando = true;
                },
                "complete" : function () {
                    self.guardando = false;
                },
                "dataSrc" : function (json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].asignaciones_numero_folio = "#" + json.data[i].asignaciones_numero_folio;
                        json.data[i].transaccion_numero_folio = "#" + json.data[i].transaccion.numero_folio;
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].usuario_asigna = json.data[i].usuario_asigna.nombre +" "+ json.data[i].usuario_asigna.apaterno +" "+ json.data[i].usuario_asigna.amaterno;
                        json.data[i].usuario_asignado = json.data[i].usuario_asignado.nombre +" "+ json.data[i].usuario_asignado.apaterno +" "+ json.data[i].usuario_asignado.amaterno;
                        json.data[i].concepto = ((json.data[i].transaccion.tipo_transaccion=='49')?json.data[i].transaccion.referencia.trim():json.data[i].transaccion.observaciones.trim());
                    }
                    return json.data;
                }
            },
            "columns" : [
                {data : 'asignaciones_numero_folio'},
                {data : 'transaccion.tipo_tran.Descripcion',orderable : false, 'searchable' : true},
                {data : 'transaccion_numero_folio',orderable : false, 'searchable' : true},
                {data : 'concepto',orderable : false},
                {data : 'usuario_asignado',orderable : false, 'searchable' : true},
                {data : 'created_at'},
                {data : 'usuario_asigna',orderable : false},
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

        if(self.permission) {
            if(self.permission_eliminar_asignacion) {
                data.columns.push({
                    data: {},
                    render: function (data) {
                        return '<button class=\'remove\' data-id="'+data.id+'"><i class="fa fa-trash"></i></button>';
                    },
                    orderable: false
                });
            }
        }

        self.table = $('#asignacion_table').DataTable(data);
        $("#description,#numero_folio").on( 'keyup change', function () {
            console.log(this.value);
            self.table
                .column( $(this).parent().index()+':visible' )
                .search( this.value )
                .draw();
        });
        $(document).delegate('.remove','click',function () {
            var id = $(this).data('id');
            self.confirm_eliminar(id);
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
                    data: dataUsuarios
                }).on('select2:select', function (e) {
                    var data = e.params.data;
                    //self.form.id_usuario_asignado.push(data.id);
                    self.table
                        .column( $(this).parent().index()+':visible' )
                        .search( data.id )
                        .draw();
                });
            },
            complete: function () {}
        });
    },
    methods: {
        confirm_eliminar: function(id_asignacion) {
            var self = this;
            swal({
                title: "Eliminar asignacion",
                text: "¿Estás seguro/a de que deseas eliminar la asignación?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    self.eliminar(id_asignacion);
                }
            }).catch(swal.noop);
        },
        eliminar: function (id_asignacion) {
            var self = this;
            $.ajax({
                type: 'DELETE',
                url : App.host +'/api/procuracion/asignacion/'+ id_asignacion,
                beforeSend: function () {},
                success: function (data, textStatus, xhr) {
                    self.table.ajax.reload( null, false );
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Asignación eliminada'
                    });
                },
                complete: function () { }
            });
        }
    }
});