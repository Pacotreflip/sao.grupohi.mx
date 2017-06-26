@extends('sistema_contable.layout')
@section('title', 'Póliza General')
@section('contentheader_title', 'PÓLIZAS GENERADAS')
@section('contentheader_description', '(DETALLE)')


@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.show', $poliza) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalle de Póliza</h3>
                </div>


                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="5" class="bg-gray-light">Póliza
                                    :<br><label>{{ $poliza->tipoPolizaContpaq}}</label></th>
                                <th class="bg-gray-light">Fecha de Solicitud
                                    :<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a') }}</label></th>
                            </tr>
                            <tr>
                                <th colspan="4" class="bg-gray-light">Concepto:
                                    <br><label> {{$poliza->concepto }}</label></th>
                                <th colspan="2" class="bg-gray-light">Usuario
                                    Solicita:<br><label> {{$poliza->user_registro }}</label></th>

                            </tr>
                        </table>

                        @if($poliza->polizaMovimientos()->count())
                            <table class="table table-bordered">
                                <!--  <tr>
                                       <th>Tipo de Póliza</th>

                                       <th>Total</th>
                                       <th>Cuadre</th>
                                       <th>Estatus</th>
                                       <th>Poliza ContPaq</th>
                                   </tr>

                                   -->
                                <tr>
                                    <th class="bg-gray-light">Cuenta Contable</th>
                                    <th class="bg-gray-light">Nombre Cuenta Contable</th>
                                    <th class="bg-gray-light">Debe</th>
                                    <th class="bg-gray-light">Haber</th>
                                    <th class="bg-gray-light">Referencia</th>
                                    <th class="bg-gray-light">Concepto</th>

                                </tr>
                                @foreach($poliza->polizaMovimientos as $movimiento)
                                    <tr>
                                        <td>{{$movimiento->cuenta_contable}}</td>
                                        <td>{{$movimiento->descripcion_cuenta_contable}}</td>
                                        <td class="bg-gray-light numerico">@if($movimiento->id_tipo_movimiento_poliza==1)
                                                ${{number_format($movimiento->importe,'2','.',',')}}@endif</td>
                                        <td class="bg-gray-light numerico">@if($movimiento->id_tipo_movimiento_poliza==2)
                                                ${{number_format($movimiento->importe,'2','.',',')}}@endif</td>
                                        <td>{{$movimiento->referencia}}</td>
                                        <td>{{$movimiento->concepto}}</td>

                                    </tr>
                                @endforeach
                                <tr>

                                    <td colspan="2" class="bg-gray @if($poliza->cuadrado!=1) bg-red @endif" style="text-align: right"><b>Sumas Iguales  </b></td>
                                    <td class="bg-gray numerico @if($poliza->cuadrado!=1) bg-red @endif">
                                        <b>${{number_format($poliza->sumaDebe,'2','.',',')}}</b></td>
                                    <td class="bg-gray numerico @if($poliza->cuadrado!=1) bg-red @endif">
                                        <b>${{number_format($poliza->sumaHaber,'2','.',',')}}</b></td>
                                    <td class="bg-gray @if($poliza->cuadrado!=1) bg-red @endif"></td>
                                    <td class="bg-gray @if($poliza->cuadrado!=1) bg-red @endif"></td>
                                </tr>

                            </table>
                            <div class="col-sm-12" style="text-align: right"><h4><b>Total de la Póliza:</b>  ${{number_format($poliza->total,'2','.',',')}}</h4></div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
