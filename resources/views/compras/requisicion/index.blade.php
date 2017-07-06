@extends('compras.layout')
@section('title', 'Requisiciones')
@section('contentheader_title', 'REQUISICIONES')

@section('main-content')
    {!! Breadcrumbs::render('compras.requisicion.index') !!}


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
                                <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
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
                                            <a href="{{ route('compras.requisicion.show', $requisicion->id_transaccion)}}" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('compras.requisicion.edit', $requisicion->id_transaccion) }}" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                            <a title="Eliminar" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>

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