@extends('sistema_contable.layout')
@section('title', 'Revaluaciones')
@section('contentheader_title', 'REVALUACIONES')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.revaluacion.index') !!}
    <div class="row">
        <div class="col-sm-12">
            <a  href="{{ route('sistema_contable.revaluacion.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nueva
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Revaluaciones</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable index_table small" role="grid">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha de Revaluación</th>
                                <th>Registró</th>
                                <th>Tipo de Cambio</th>
                                <th>Moneda</th>
                                <th>Número de Facturas Revaluadas</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($revaluaciones as $index => $revaluacion)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{$revaluacion->fecha->format('Y-m')}}</td>
                                <td>{{$revaluacion->usuario_registro}}</td>
                                <td class="text-right">$ {{number_format($revaluacion->tipo_cambio,4)}}</td>
                                <td>{{$revaluacion->moneda}}</td>
                                <td class="text-right">{{$revaluacion->facturas()->count()}}</td>
                                <td>
                                    <a href="{{route('sistema_contable.revaluacion.show', $revaluacion)}}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> </a>

                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Fecha de Revaluación</th>
                                <th>Tipo de Cambio</th>
                                <th>Moneda</th>
                                <th>Número de Facturas Revaluadas</th>
                                <th>Acciones</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection