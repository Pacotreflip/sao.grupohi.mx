@extends('sistema_contable.layout')
@section('title', 'Póliza Generada')
@section('contentheader_title', 'PRE-PÓLIZAS GENERADAS')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Opciones de Búsqueda</h3>
                </div>
                <div class="box-body">
                    {!! Form::model(Request::only(['fechas', 'estatus']), ['method' => 'GET']) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Rango de Fechas</b></label>
                                {!! Form::text('fechas', null, ['class' => 'form-control rango_fechas']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Estatus</b></label>
                                {!! Form::select('estatus', array('' => 'Todas', '0' => 'Registrada', '1' => 'Lanzada', '-1' => 'No Lanzada', '-2' => 'Con Errores'), '', array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-sm btn-primary pull-right" type="submit">Buscar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Pre-Pólizas Generadas</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped small index_table" id="example"> <!--<table class="table table-bordered table-striped small " role="grid" aria-describedby="tipo_cuenta_info">-->
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Póliza</th>
                                <th>Tipo de Transaccion</th>
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
                                    <td>{{ $item->tipoPolizaContpaq}}</td>
                                    <td>{{ $item->concepto}}</td>
                                    <td class="numerico">$ {{number_format($item->total,'2','.',',')}}</td>
                                    <td class="numerico">$ {{number_format($item->cuadre,'2','.',',')}}</td>
                                    <td class="">
                                        @if($item->estatus == $item::REGISTRADA) <span class="label bg-blue">Registrada</span>@endif
                                        @if($item->estatus == $item::LANZADA) <span class="label bg-green">Lanzada</span>@endif
                                        @if($item->estatus == $item::NO_LANZADA) <span class="label bg-yellow">No lanzada</span>@endif
                                        @if($item->estatus == $item::CON_ERRORES) <span class="label bg-red">Con errores</span>@endif
                                    </td>
                                    <td>@if($item->id_poliza_contpaq>0){{$item->id_poliza_contpaq}}@else N/A @endif</td>
                                    <td style="min-width: 90px;max-width: 90px">
                                        <a href="{{route('sistema_contable.poliza_generada.show',$item)}}" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                        <a href="{{route('sistema_contable.poliza_generada.edit',$item)}}" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                                        <a href="{{route('sistema_contable.poliza_generada.historico',$item)}}" title="Histórico" class="btn btn-xs btn-success {{$item->historicos()->count() > 0 ? '' : 'disabled' }}"><i class="fa fa-clock-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $polizas->appends(['fechas' => $fechas, 'estatus' => $estatus])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
