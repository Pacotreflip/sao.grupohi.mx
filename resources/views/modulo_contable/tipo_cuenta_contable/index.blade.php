@extends('modulo_contable.layout')
@section('title', 'Plantillas de Tipo Cuenta Contable')
@section('contentheader_title', 'TIPO CUENTA CONTABLE')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.tipo_cuenta_contable.index') !!}
    <div class="row">
        <div class="col-sm-12">
            <a  href="{{ route('modulo_contable.tipo_cuenta_contable.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nueva
            </a>
        </div>
    </div>
    <br>
    @if(count($tipos_cuenta_contable) > 0)
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tipo Cuenta Contable</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">
                            <table  class="table table-bordered table-striped dataTable index_table" role="grid"
                                   aria-describedby="tipo_cuenta_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Descripción</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Registró</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Fecha y Hora de Registro</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Asignacion Tipo Cuenta Contable</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tipos_cuenta_contable as $index => $item)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->descripcion  }}</td>
                                        <td>{{ $item->userRegistro }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d h:i:s a') }}</td>
                                        <td>
                                            @if($item->cuentaContable)
                                                <span class="label label-success">{{$item->cuentaContable->prefijo.''.$item->cuentaContable->cuenta_contable }}</span>

                                            @else
                                                <span class="label label-danger">No Asignada</span>
                                            @endif
                                        </td>
                                        <td style="min-width: 90px;max-width: 90px">
                                            <div class="btn-group">
                                                <a href="{{ route('modulo_contable.tipo_cuenta_contable.show', $item->id_tipo_cuenta_contable) }}" type="button" class="btn btn-xs btn-default">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <button type="button" class="btn btn-xs btn-danger" onclick=" delete_tipo_cuena_contable({{$item->id_tipo_cuenta_contable}})">
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
                                    <th>Descripcion</th>
                                    <th>Registró</th>
                                    <th>Fecha y Hora de Registro</th>
                                    <th>Asignacion Tipo Cuenta Contable</th>
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
        function delete_tipo_cuena_contable(id) {

            var url=App.host +"/modulo_contable/tipo_cuenta_contable/" + id;
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
                                text: 'Tipo Cuenta Contable Eliminada con éxito',
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