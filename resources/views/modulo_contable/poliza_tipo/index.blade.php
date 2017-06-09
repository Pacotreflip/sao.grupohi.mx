@extends('modulo_contable.layout')
@section('title', 'Polizas Tipo')
@section('contentheader_title', 'PÓLIZAS TIPO')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.index') !!}
 <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Pólizas Generadas</h3>
                    <div class="col-sm-12">
                        <a class="btn btn-app btn-success" style="float:right">
                            <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
                        </a>
                        <br/><br/><br/><br/>
                    </div>

                    <div class="col-sm-12">
                        <div class="row">

                            <table id="polizas_tipo" class="table table-bordered table-striped dataTable" role="grid"
                                   aria-describedby="polizas_tipo_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="polizas_tipo"
                                        aria-sort="ascending">ID
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Póliza Tipo</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo"># Movimientos</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Registró</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Fecha y Hora de
                                        Registro
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($polizas_tipo as $index => $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->transaccionInterfaz  }}</td>
                                        <td>{{ $item->numMovimientos }}</td>
                                        <td>{{ $item->userRegistro }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i:s a') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ID</th>
                                    <th rowspan="1" colspan="1">Póliza Tipo</th>
                                    <th rowspan="1" colspan="1"># Movimientos</th>
                                    <th rowspan="1" colspan="1">Registró</th>
                                    <th rowspan="1" colspan="1">Fecha y Hora de Registro</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <br/>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts-content')
    <script>
        $(function () {
            $('#polizas_tipo').DataTable({
                'language': {
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
                },
                'ordering': true,
                'info': true
            });
        });
    </script>

@endsection