@extends('compras.layout')
@section('title', 'Requisiciones')
@section('contentheader_title', 'REQUISICIONES')
@section('breadcrumb')
    {!! Breadcrumbs::render('compras.requisicion.index') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Requisiciones</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <a  href="{{ route('compras.requisicion.create') }}" class="btn btn-success btn-app" style="float:right">
                                <i class="glyphicon glyphicon-plus-sign"></i>Nueva
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-12">

                        <div class="row table-responsive">
                            <table class="table table-bordered table-striped dataTable index_table" role="grid"
                                   aria-describedby="tipo_cuenta_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0">Folio de requisición</th>
                                    <th class="sorting" tabindex="0">Observación</th>
                                    <th class="sorting" tabindex="0">Fecha</th>
                                    <th class="sorting" tabindex="0">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requisiciones as $index => $requisicion)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$requisicion->folio}}</td>
                                        <td>{{$requisicion->observaciones}}</td>
                                        <td>{{$requisicion->fecha->format('Y-m-d h:i:s a')}}</td>
                                        <td>
                                            <a href="{{ route('compras.requisicion.show', $requisicion) }}" title="Ver"><button class="btn-xs btn-default"><i class="fa fa-eye"></i></button></a>
                                            <a href="{{ route('compras.requisicion.edit', $requisicion) }}" title="Editar"><button class="btn-xs btn-info"><i class="fa fa-edit"></i></button></a>
                                            <a title="Eliminar"><button  class="btn-xs btn-danger" onclick="eliminar_requisicion({{$requisicion->id_transaccion}}, this)"><i class="fa fa-trash"></i></button></a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th>#</th>
                                <th>Folio de requisición</th>
                                <th>Observación</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                                </tfoot>
                            </table>
                        </div>

                        <br/>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('scripts-content')
    <script>
         function eliminar_requisicion(id) {
             var self = this;
             swal({
                 title: "Eliminar Requisición",
                 text: "¿Estás seguro de que deseas eliminar la Requisición?",
                 type: "warning",
                 showCancelButton: true,
                 confirmButtonText: "Si, Continuar",
                 cancelButtonText: "No, Cancelar",
             }).then(function (result) {
                 if(result.value) {
                     eliminar(id);
                 }
             });
         }

         function eliminar(item) {

             var url = App.host + '/item/' + item;
             $.ajax({
                 type: 'POST',
                 url: url,
                 data: {
                     _method: 'DELETE'
                 },
                 success: function (data, textStatus, xhr) {
                     swal({
                         title: '¡Correcto!',
                         text: "Requisición eliminada correctamente.",
                         type: "success",
                         confirmButtonText: "Ok",
                         closeOnConfirm: false
                     }).then(function () {
                         location.reload();
                     });
                 }
             });
         }
    </script>
@endsection
