@extends('sistema_contable.layout')
@section('title', 'REVALUACIÓN')
@section('contentheader_title', 'REVALUACIÓN')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.revaluacion.show') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalle de Revaluación</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-gray-light">Fecha de
                                    Revaluación<br><label>{{$revaluacion->fecha->format('M-Y')}}</label></th>
                                <th class="bg-gray-light">Tipo de
                                    Cambio<br><label>$ {{number_format($revaluacion->tipo_cambio,4)}}</label></th>
                                <th class="bg-gray-light">Moneda<br><label>{{$revaluacion->moneda}}</label></th>
                                <th class="bg-gray-light">Número de Facturas
                                    Revaluadas<br><label>{{$revaluacion->facturas()->count()}}</label></th>
                            </tr>
                        </table>
                        @if(count($revaluacion->facturas)>0)

                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Empresa</th>
                                    <th>Referencia</th>
                                    <th>Contrarecibo</th>
                                    <th>Observaciones</th>
                                    <th>Fecha </th>
                                    <th>Monto</th>
                                </tr>
                                </thead>
                                @foreach($revaluacion->facturas as $index=>$factura)
                                    <tr>
                                        <td>{{$index + 1 }}</td>
                                        <td>{{$factura->empresa->razon_social}}</td>
                                        <td>{{$factura->referencia}}</td>
                                        <td>{{$factura->id_antecedente}}</td>
                                        <td>{{$factura->observaciones}}</td>
                                        <td>{{$factura->fecha->format('Y-m-d')}}</td>
                                        <td style="text-align: right">$ {{number_format($factura->monto,2)}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
