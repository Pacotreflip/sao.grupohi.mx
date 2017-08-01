@extends('sistema_contable.layout')
@section('title', 'Revaluaciones')
@section('contentheader_title', 'REVALUACIONES')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.revaluacion.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Listado de Revaluaciones</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered small">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($revaluaciones as $index => $revaluacion)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{route('sistema_contable.revaluacion.show', $revaluacion)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> </a>
                                    <a href="" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection