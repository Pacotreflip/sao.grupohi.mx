@extends('sistema_contable.layout')
@section('title', 'Póliza Generada')
@section('contentheader_title', 'PÓLIZAS GENERADAS')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Pólizas Generadas</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped small index_table" id="example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Póliza</th>
                                <th>Concepto</th>
                                <th>Total</th>
                                <th>Cuadre</th>
                                <th>Estatus</th>
                                <th>Póliza ContPaq</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($polizas as $index => $item)
                                <tr>

                                    <td>{{ $index+1}}</td>
                                    <td>{{ $item->transaccionInterfaz}}</td>
                                    <td>{{ $item->concepto}}</td>
                                    <td class="numerico">$ {{number_format($item->total,'2','.',',')}}</td>
                                    <td class="numerico">$ {{number_format($item->cuadre,'2','.',',')}}</td>
                                    <td class="">
                                           @if($item->estatus_string=='Registrada') <span class="label bg-blue">Registrada</span>@endif
                                            @if($item->estatus_string=='Lanzada') <span class="label bg-green">Lanzada</span>@endif
                                            @if($item->estatus_string=='No lanzada') <span class="label bg-yellow">No lanzada</span>@endif
                                            @if($item->estatus_string=='Con errores') <span class="label bg-red">Con errores</span>@endif
                                    </td>
                                    <td>N/A</td>
                                    <td style="min-width: 90px;max-width: 90px">
                                        <a href="{{route('sistema_contable.poliza_generada.show',$item)}}" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                        <a href="{{route('sistema_contable.poliza_generada.edit',$item)}}" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                                        <a href="{{route('sistema_contable.poliza_generada.historico',$item)}}" title="Histórico" class="btn btn-xs btn-success {{$item->historicos()->count() > 0 ? '' : 'disabled' }}"><i class="fa fa-clock-o"></i></a>
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
