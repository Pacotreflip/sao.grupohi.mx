@extends('sistema_contable.layout')
@section('title', 'Plantillas de Prepólizas')
@section('contentheader_title', 'PLANTILLAS DE PREPÓLIZAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.poliza_tipo.index') !!}
@endsection
@section('main-content')

    @permission(['registrar_plantilla_prepoliza'])
    <div class="row">
        <div class="col-sm-12">
            @permission('registrar_plantilla_prepoliza')
            <a  href="{{ route('sistema_contable.poliza_tipo.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nueva
            </a>
            @endpermission
        </div>
    </div>
    <br>
    @endpermission
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Plantilla de Prepólizas</h3>
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
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Número de Movimientos</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Registró</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Fecha y Hora de Registro</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Vigencia</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Inicio de Vigencia</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Fin de Vigencia</th>
                                    <th class="sorting" tabindex="0" aria-controls="polizas_tipo">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($polizas_tipo as $index => $item)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->polizaTipoSAO  }}</td>
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
                                            <a title="Ver" href="{{ route('sistema_contable.poliza_tipo.show', $item->id) }}">
                                                <button type="button" class="btn btn-xs btn-default">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>
                                            @permission('eliminar_plantilla_prepoliza')
                                            <button title="Eliminar" type="button" class="btn btn-xs btn-danger" onclick=" delete_plantilla({{$item->id}})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            @endpermission
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo de Póliza</th>
                                    <th>Número de Movimientos</th>
                                    <th>Registró</th>
                                    <th>Fecha y Hora de Registro</th>
                                    <th>Vigencia</th>
                                    <th>Inicio de Vigencia</th>
                                    <th>Fin de Vigencia</th>
                                    <th>Acciones</th>
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
        function delete_plantilla(id) {

            var url=App.host +"/sistema_contable/poliza_tipo/" + id;
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
                                reject("¡Escriba el motivo de la eliminación!");
                                return false
                            }
                            resolve()
                        },500)
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
                                text: 'Plantilla Eliminada con éxito'
                        });
                        location.reload();
                    },
                    complete: function () {

                    }
                });
            }) .catch(swal.noop);

 }
    </script>
@endsection