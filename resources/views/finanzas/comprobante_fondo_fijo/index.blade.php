@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'COMPROBANTE DE FONDO FIJO')
@section('contentheader_description', '(INDEX)')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.comprobante_fondo_fijo.index') !!}

    <div class="row">
        <div class="col-sm-12">
            @permission('registrar_comprobante_fondo_fijo')
            <a  href="{{ route('finanzas.comprobante_fondo_fijo.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
            </a>
            @endpermission

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Comprobantes de Fondo Fijo</h3>
                </div>

                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">

                        <table class="table table-bordered table-striped dataTable" role="grid" id="order">
                            <thead>
                            <tr role="row">
                                <th># Folio</th>
                                <th>Fondo Fijo</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Referencia</th>
                                <th>Fecha de Alta</th>
                                <th>Acciones</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comprobantes_fondo_fijo as $item)
                                <tr>
                                    <td>{{ $item->numero_folio}}</td>
                                    <td>{{ $item->FondoFijo}}</td>
                                    <td class="text-right">${{ number_format($item->monto, 2, ",", ".") }}</td>
                                    <td>{{ $item->fecha}}</td>
                                    <td>{{ $item->referencia }}</td>
                                    <td>{{ $item->FechaHoraRegistro }}</td>
                                    <td style="width: 80px">
                                        @permission('consultar_comprobante_fondo_fijo')
                                        <a href="{{route('finanzas.comprobante_fondo_fijo.show',$item)}}"
                                           title="Ver"
                                           class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                        @endpermission
                                        @permission('editar_comprobante_fondo_fijo')
                                        <a href="{{route('finanzas.comprobante_fondo_fijo.edit',$item)}}"
                                           title="Editar"
                                           class="btn btn-xs btn-info">
                                            <i class="fa fa-pencil"></i></a>
                                        @endpermission
                                        @permission('eliminar_comprobante_fondo_fijo')
                                        <button title="Eliminar" type="button" class="btn btn-xs btn-danger" onclick=" delete_comprobante({{$item->id_transaccion}})">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        @endpermission

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                            <tfoot>
                            <tr>
                                <th># Folio</th>
                                <th>Fondo Fijo</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Referencia</th>
                                <th>Fecha de Alta</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
    <script>
        $('#order').DataTable( {
            "order": [[ 5, "desc" ]]
        } );
        function delete_comprobante(id) {

            var url=App.host +"/finanzas/comprobante_fondo_fijo/" + id;
            swal({
                title: "Eliminar Comprobante de Fondo Fijo",
                html: "¿Estás seguro que desea eliminar el comprobante de fondo fijo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function () {
               $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _method: 'DELETE'
                    },
                    success: function (data, textStatus, xhr) {
                        swal({
                            type: "success",
                            title: '¡Correcto!',
                            text: 'Comprobante de Fondo Fijo Eliminado con éxito'
                        });
                        location.reload();
                    },
                    complete: function () {

                    }
                });
            }).catch(swal.noop);
        }

    </script>
@endsection
