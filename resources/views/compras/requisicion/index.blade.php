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
                    <div class="col-sm-12">

                        <div class="row table-responsive">
                            <table class="table table-bordered table-striped dataTable index_table" role="grid"
                                   aria-describedby="tipo_cuenta_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-sort="ascending">#</th>
                                    <th class="sorting" tabindex="0">Departamento Responsable</th>
                                    <th class="sorting" tabindex="0">Tipo</th>
                                    <th class="sorting" tabindex="0">Observaciones</th>
                                    <th class="sorting" tabindex="0">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requisiciones as $index => $requisicion)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{$requisicion->departamentoResponsable->descripcion}}</td>
                                        <td>{{$requisicion}}</td>
                                        <td>{{$requisicion->observaciones}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <th>#</th>
                                <th>Departamento Responsable</th>
                                <th>Tipo</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                                </tfoot>
                            </table>
                        </div>

                        <br/>
                    </div>
                </div>
            </div>

@endsection