@extends('modulo_contable.layout')
@section('title', 'Póliza General')
@section('contentheader_title', 'PÓLIZAS GENERADAS')
@section('contentheader_description', '(HISTORICO)')


@section('main-content')


    {!! Breadcrumbs::render('modulo_contable.poliza_generada.historico', @$polizas[0]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <section class="content-header">
                    <h1>
                        Historico de Póliza:
                        <small> {{ @$polizas[0]->tipoPolizaContpaq }}</small>
                    </h1>

                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- row -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- The time line -->
                            <ul class="timeline">
                                @foreach($polizas as $poliza)
                                    <li class="time-label">
                                      <span class="bg-red">
                                        {{ $poliza->created_at->format('Y-m-d') }}
                                      </span>
                                    </li>

                                    <li>
                                        <i class="fa fa-clock-o bg-blue"></i>

                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><a href="#">{{ $poliza->created_at->format('h:i:s a') }}</a>
                                            </h3>
                                            <div class="timeline-body">
                                                <div class="box-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered small">
                                                            <tr>
                                                                <th colspan="5" class="bg-gray-light">Poliza
                                                                    :<br><label>{{ $poliza->tipoPolizaContpaq}}</label>
                                                                </th>
                                                                <th class="bg-gray-light">Fecha de Solicitud
                                                                    :<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a') }}</label>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="4" class="bg-gray-light">Concepto:
                                                                    <br><label> {{$poliza->concepto }}</label></th>
                                                                <th colspan="2" class="bg-gray-light">Usuario
                                                                    Solicita:<br><label> {{$poliza->user_registro }}</label>
                                                                </th>

                                                            </tr>
                                                        </table>

                                                        @if($poliza->polizaMovimientos()->count())
                                                            <table class="table table-bordered small">

                                                                <tr>
                                                                    <th class="bg-gray-light">Cuenta Contable</th>
                                                                    <th class="bg-gray-light">Nombre Cuenta Contable
                                                                    </th>
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

                                                                    <td colspan="2"
                                                                        class="bg-gray @if($poliza->cuadrado!=1) bg-red @endif" style="text-align: right">
                                                                        <b>Sumas
                                                                            Iguales </b></td>
                                                                    <td class="bg-gray numerico @if($poliza->cuadrado!=1) bg-red @endif">
                                                                        <b>${{number_format($poliza->sumaDebe,'2','.',',')}}</b>
                                                                    </td>
                                                                    <td class="bg-gray numerico @if($poliza->cuadrado!=1) bg-red @endif">
                                                                        <b>${{number_format($poliza->sumaHaber,'2','.',',')}}</b>
                                                                    </td>
                                                                    <td class="bg-gray @if($poliza->cuadrado!=1) bg-red @endif"></td>
                                                                    <td class="bg-gray @if($poliza->cuadrado!=1) bg-red @endif"></td>
                                                                </tr>

                                                            </table>
                                                            <div class="col-sm-12" style="text-align: right"><h4><b>Total
                                                                        de la Póliza:</b>
                                                                    ${{number_format($poliza->total,'2','.',',')}}</h4>
                                                            </div>
                                                        @endif


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </li>

                                @endforeach

                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


            </div>
        </div>
    </div>
@endsection
