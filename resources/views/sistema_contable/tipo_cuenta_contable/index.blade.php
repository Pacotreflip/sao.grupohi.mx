@extends('sistema_contable.layout')
@section('title', 'Tipos de Cuentas Contables')
@section('contentheader_title', 'TIPOS DE CUENTAS CONTABLES')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.tipo_cuenta_contable.index') !!}
@endsection
@section('main-content')

    @permission(['registrar_tipo_cuenta_contable'])
    <div class="row">
        <div class="col-sm-12">
            @permission('registrar_tipo_cuenta_contable')
            <a  href="{{ route('sistema_contable.tipo_cuenta_contable.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
            </a>
            @endpermission
        </div>
    </div>
    <br>
    @endpermission

    @if(count($tipos_cuenta_contable) > 0)
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tipos de Cuentas Contables</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">
                            <table  class="table table-bordered table-striped index_table" role="grid"
                                   aria-describedby="tipo_cuenta_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Descripción</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Registró</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Naturaleza de Cuenta</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Fecha y Hora de Registro</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Asignación a Cuenta Contable</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tipos_cuenta_contable as $index => $item)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->descripcion  }}</td>
                                        <td>{{ $item->userRegistro }}</td>
                                        <td>{{ $item->naturalezaPoliza}}</td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i:s a') }}</td>
                                        <td>
                                            @if($item->cuentaContable)
                                                <span class="label label-success" title="{{$item->cuentaContable->prefijo.''.$item->cuentaContable->cuenta_contable }}">Asignada</span>
                                            @else
                                                <span class="label label-danger">No Asignada</span>
                                            @endif
                                        </td>
                                        <td style="min-width: 90px;max-width: 90px">
                                            <a title="Ver" href="{{ route('sistema_contable.tipo_cuenta_contable.show', $item->id_tipo_cuenta_contable) }}">
                                                <button title="Ver" type="button" class="btn btn-xs btn-default">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>
                                            @permission('editar_tipo_cuenta_contable')
                                            <a title="Editar" href="{{ route('sistema_contable.tipo_cuenta_contable.edit', $item->id_tipo_cuenta_contable) }}">
                                                <button title="Editar" type="button" class="btn btn-xs btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </a>
                                            @endpermission
                                            @permission('eliminar_tipo_cuenta_contable')
                                            <button type="button" title="Eliminar" class="btn btn-xs btn-danger" onclick="delete_tipo_cuenta_contable({{$item->id_tipo_cuenta_contable}})"><i class="fa fa-trash"></i></button>
                                            @endpermission
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Registró</th>
                                    <th >Naturaleza de Cuenta</th>
                                    <th>Fecha y Hora de Registro</th>
                                    <th>Asignación a Cuenta Contable</th>
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
@endif
@endsection
@section('scripts-content')
    <script>
        function delete_tipo_cuenta_contable(id) {

            var url=App.host +"/sistema_contable/tipo_cuenta_contable/" + id;
            swal({
                title: "¡Eliminar TIPO CUENTA CONTABLE!",
                text: "¿Esta seguro de que deseas eliminar el Tipo Cuenta Contable?",
                input: 'text',
                inputPlaceholder: "Motivo de eliminación.",
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: function (inputValue) {
                    return new Promise(function (resolve) {
                        if (inputValue === "") {
                            swal.showValidationError("¡Escriba el motivo de la eliminación!");
                        }
                        resolve()
                    })
                },
                allowOutsideClick: false
            }).then(function (inputValue) {
                if(inputValue.value) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            motivo: inputValue.value
                        },
                        success: function (data, textStatus, xhr) {
                            swal({
                                type: "success",
                                title: '¡Correcto!',
                                text: 'Tipo Cuenta Contable Eliminada con éxito',
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection