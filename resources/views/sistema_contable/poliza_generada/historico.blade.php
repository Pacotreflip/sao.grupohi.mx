@extends('sistema_contable.layout')
@section('title', 'Póliza General')
@section('contentheader_title', 'PREPÓLIZAS GENERADAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.historico', @$poliza) !!}
@endsection
@section('main-content')

    @if(count($polizas)==0)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Sin Historico!</h4>
            La poliza: {{mb_strtoupper($poliza->transaccionInterfaz)}}  No cuenta con movimientos considerados como historico.
        </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Histórico de Prepóliza</h3>

                </div>

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
                                        {{ $poliza->created_at->format('Y-m-d h:i:s a') }}
                                      </span>
                                    </li>

                                    <li>
                                        <i class="fa fa-clock-o bg-blue"></i>

                                        <div class="timeline-item">
                                            <h3 class="timeline-header"><a href="#">{{ $poliza->created_at->format('Y-m-d h:i:s a') }}</a>
                                            </h3>
                                            <div class="timeline-body">
                                                <div class="box-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th  class="bg-gray-light">Tipo Póliza SAO:<br><label>{{ $poliza->transaccionInterfaz}}</label></th>
                                                                <th class="bg-gray-light">Fecha de Solicitud:<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a')}}</label></th>
                                                                <th  class="bg-gray-light">Usuario Solicita:<br><label> {{$poliza->usuario_solicita }}</label></th>
                                                                <th class="bg-gray-light">Cuadre:<br><label>$ {{number_format($poliza->cuadre,'2','.',',')}}</label></th>


                                                            </tr>
                                                            <tr>
                                                                <th class="bg-gray-light">Estatus:<br>
                                                                    <label>
                                                                        <span class="label" style="background-color: {{$poliza->estatusPrepoliza->label}}">{{$poliza->estatusPrepoliza}}</span>
                                                                    </label>
                                                                </th>
                                                                <th class="bg-gray-light">
                                                                    Póliza Contpaq:
                                                                    <br><label>{{$poliza->poliza_contpaq}}</label>
                                                                </th>
                                                                <th class="bg-gray-light">
                                                                    Tipo de Póliza:
                                                                    <br><label> {{ $poliza->tipoPolizaContpaq}}</label>
                                                                </th>
                                                                <th class="bg-gray-light">
                                                                    Transacción Antecedente:
                                                                    <br><label>{{ $poliza->transacciones->tipoTransaccion}} - {{ $poliza->transacciones->numero_folio}}</label>
                                                                </th>
                                                            </tr>
                                                            <tr>

                                                                <th class="bg-gray-light" colspan="4">
                                                                    Concepto:
                                                                    <br><label> {{$poliza->concepto }}</label>
                                                                </th>
                                                            </tr>
                                                        </table>

                                                        @if(count($poliza->polizaMovimientos())>0)
                                                            <table class="table table-bordered table-striped">

                                                                <tr>
                                                                    <th class="bg-gray-light">Cuenta Contable</th>
                                                                    <th class="bg-gray-light">Tipo Cuenta Contable
                                                                    </th>
                                                                    <th class="bg-gray-light">Debe</th>
                                                                    <th class="bg-gray-light">Haber</th>
                                                                    <th class="bg-gray-light">Referencia</th>
                                                                    <th class="bg-gray-light">Concepto</th>

                                                                </tr>
                                                                @foreach($poliza->polizaMovimientos as $movimiento)
                                                                    <tr>
                                                                        <td>{{$movimiento->cuenta_contable}}</td>
                                                                        <td>
                                                                            @if($movimiento->tipoCuentaContable)
                                                                                {{$movimiento->tipoCuentaContable}}
                                                                            @else
                                                                                No Registrada
                                                                            @endif
                                                                        </td>
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
                                                                        <b>Sumas Iguales </b></td>
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
                                                            <div class="col-sm-12" style="text-align: right"><h4><b>Total de la Prepóliza:</b>
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
    @endif
@endsection
