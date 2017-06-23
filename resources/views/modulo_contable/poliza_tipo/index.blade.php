@extends('modulo_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'PLANTILLAS DE PÓLIZA')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.index') !!}
    <div class="row">
        <div class="col-sm-12">
            <a  href="{{ route('modulo_contable.poliza_tipo.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nueva
            </a>
        </div>
    </div>
    <br>
    @if(count($polizas_tipo) > 0)
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Plantilla de Póliza</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">
                            <table  class="table table-bordered table-striped dataTable index_table" role="grid"
                                   aria-describedby="polizas_tipo_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="polizas_tipo" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Tipo de Póliza</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo"># Movimientos</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Registró</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Fecha y Hora de Registro</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Vigencia</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Inicio de Vigencia</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Fin de Vigencia</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($polizas_tipo as $index => $item)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->transaccion  }}</td>
                                        <td>{{ $item->numMovimientos }}</td>
                                        <td>{{ $item->userRegistro }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i:s a') }}</td>
                                        <td>
                                            @if($item->vigencia == "Vigente")
                                                <span class="label label-success">{{$item->vigencia}}</span>
                                            @elseif($item->vigencia == "No Vigente")
                                                <span class="label label-danger">{{$item->vigencia}}</span>
                                            @else
                                                <span class="label label-info">{{$item->vigencia}}</span>
                                            @endif
                                        </td>


                                        <td>{{$item->inicio_vigencia->format('Y-m-d h:i:s a')}}</td>
                                        <td>
                                            @if($item->fin_vigencia){{$item->fin_vigencia->format('Y-m-d h:i:s a')}}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td style="min-width: 90px;max-width: 90px">
                                            <div class="btn-group">
                                                <a href="{{ route('modulo_contable.poliza_tipo.show', $item->id) }}" type="button" class="btn btn-xs btn-default">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <button type="button" class="btn btn-xs btn-danger" onclick=" delete_plantilla({{$item->id}})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Póliza Tipo</th>
                                    <th># Movimientos</th>
                                    <th>Registró</th>
                                    <th>Fecha y Hora de Registro</th>
                                    <th>Vigencia</th>
                                    <th>Inicio de Vigencia</th>
                                    <th>Fin de Vigencia</th>
                                    <th></th>
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
@endif
@endsection
@section('scripts-content')
    <script>
        function delete_plantilla(id) {

            var url=App.host +"/modulo_contable/poliza_tipo/" + id;
            swal({
                title: "¡Eliminar Plantilla!",
                text: "¿Esta seguro de que deseas eliminar la Plantilla?",
                input: 'text',
                inputPlaceholder: "Motivo de eliminación.",
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: function (inputValue) {
                    return new Promise(function (resolve, reject) {
                        setTimeout(function() {
                            if (inputValue === false) return false;
                            if (inputValue === "") {
                                swal.showInputError("¡Escriba el motivo de la eliminación!");
                                return false
                            }
                            resolve()
                        }, 2000)
                    })
                },
                allowOutsideClick: false
            }).then(function (inputValue)
            { $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        motivo: inputValue
                    },
                    success: function (data, textStatus, xhr) {
                        swal({
                                type: "success",
                                title: '¡Correcto!',
                                text: 'Plantilla Eliminada con éxito',
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }).then(function () {
                            location.reload();
                        });
                    },
                    complete: function () {

                    }
                });
            }) .catch(swal.noop);

 }
    </script>
@endsection