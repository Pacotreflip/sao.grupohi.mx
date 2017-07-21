@extends('sistema_contable.layout')
@section('title', 'Notificaciones')
@section('contentheader_title', 'Notificaciones')
@section('contentheader_description', '(Detalle)')
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box-body">

                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h3></h3>
                            <h5>From: saoweb@grupohi.mx
                                <span class="mailbox-read-time pull-right">{{$notificacion->created_at->format('Y-m-d h:i:s a')}}</span>
                            </h5>
                        </div>

                        <div class="mailbox-read-message">
                            <p><b>Estimado Colaborador {{$notificacion->usuario}}</b></p>
                            <p>Se le informa que las siguientes prepólizas requieren de revisión para poder ser emitidas
                                correctamente.</p>

                        </div>
                    </div>
                    <div class="box-footer">
                        <ul class="mailbox-attachments clearfix">
                            <div class="table-responsive">

                                <table class="table table-bordered small"
                                       style="width: 100% !important;text-size-adjust: auto;">

                                    @if(count($polizas_errores))
                                        <thead>
                                        <tr>
                                            <th colspan="9" bgcolor="#d3d3d3">PREPÓLIZAS CON ERRORES</th>
                                        </tr>
                                        </thead>
                                        <tr>
                                            <th bgcolor="#d3d3d3">No.</th>
                                            <th bgcolor="#d3d3d3">Número de Prepóliza</th>
                                            <th bgcolor="#d3d3d3">Tipo de Póliza</th>
                                            <th bgcolor="#d3d3d3">Concepto</th>
                                            <th bgcolor="#d3d3d3">Total</th>
                                            <th bgcolor="#d3d3d3">Cuadre</th>
                                            <th bgcolor="#d3d3d3">Estatus</th>
                                            <th bgcolor="#d3d3d3">Póliza ContPaq</th>
                                            <th bgcolor="#d3d3d3">Editar</th>
                                        </tr>
                                        @foreach($polizas_errores as $index=>$notificacion)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$notificacion->id_int_poliza}}</td>
                                                <td>{{$notificacion->tipo_poliza}}</td>
                                                <td>{{$notificacion->concepto}}</td>
                                                <td style="text-align: right">$ {{$notificacion->total}}</td>
                                                <td style="text-align: right">
                                                    $ {{$notificacion->cuadre}}</td>
                                                <td>
                                                    <span class="label bg-{{$notificacion->estatusPrepoliza->label }}">{{$notificacion->estatusPrepoliza}}</span>
                                                </td>
                                                <td>{{$notificacion->poliza_contpaq}}</td>
                                                <td style="min-width: 90px;max-width: 90px">
                                                    <a href="{{route('sistema_contable.poliza_generada.edit',$notificacion->poliza)}}"
                                                       title="Editar" class="btn btn-xs btn-info"><i
                                                                class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if(count($polizas_no_lanzadas))
                                        <tr>
                                            <th colspan="9" bgcolor="white"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="9" bgcolor="#d3d3d3">PREPÓLIZAS NO LANZADAS</th>
                                        </tr>

                                        <tr>
                                            <th bgcolor="#d3d3d3">No.</th>
                                            <th bgcolor="#d3d3d3">Número de Prepóliza</th>
                                            <th bgcolor="#d3d3d3">Tipo de Póliza</th>
                                            <th bgcolor="#d3d3d3">Concepto</th>
                                            <th bgcolor="#d3d3d3">Total</th>
                                            <th bgcolor="#d3d3d3">Cuadre</th>
                                            <th bgcolor="#d3d3d3">Estatus</th>
                                            <th bgcolor="#d3d3d3">Póliza ContPaq</th>
                                            <th bgcolor="#d3d3d3">Editar</th>
                                        </tr>
                                        @foreach($polizas_no_lanzadas as $index=>$notificacion)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$notificacion->id_int_poliza}}</td>
                                                <td>{{$notificacion->tipo_poliza}}</td>
                                                <td>{{$notificacion->concepto}}</td>
                                                <td style="text-align: right">$ {{$notificacion->total}}</td>
                                                <td style="text-align: right">
                                                    $ {{$notificacion->cuadre}}</td>
                                                <td>
                                                    <span class="label bg-{{$notificacion->estatusPrepoliza->label }}">{{$notificacion->estatusPrepoliza}}</span>
                                                </td>
                                                <td>{{$notificacion->poliza_contpaq}}</td>
                                                <td style="min-width: 90px;max-width: 90px">
                                                    <a href="{{route('sistema_contable.poliza_generada.edit',$notificacion->poliza)}}"
                                                       title="Editar" class="btn btn-xs btn-info"><i
                                                                class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if(count($polizas_no_validadas))

                                        <tr>
                                            <th colspan="9" bgcolor="white"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="9" bgcolor="#d3d3d3">PREPÓLIZAS NO VALIDADAS</th>
                                        </tr>

                                        <tr>
                                            <th bgcolor="#d3d3d3">No.</th>
                                            <th bgcolor="#d3d3d3">Número de Prepóliza</th>
                                            <th bgcolor="#d3d3d3">Tipo de Póliza</th>
                                            <th bgcolor="#d3d3d3">Concepto</th>
                                            <th bgcolor="#d3d3d3">Total</th>
                                            <th bgcolor="#d3d3d3">Cuadre</th>
                                            <th bgcolor="#d3d3d3">Estatus</th>
                                            <th bgcolor="#d3d3d3">Póliza ContPaq</th>
                                            <th bgcolor="#d3d3d3">Editar</th>
                                        </tr>

                                        @foreach($polizas_no_validadas as $index=>$notificacion)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$notificacion->id_int_poliza}}</td>
                                                <td>{{$notificacion->tipo_poliza}}</td>
                                                <td>{{$notificacion->concepto}}</td>
                                                <td style="text-align: right">$ {{$notificacion->total}}</td>
                                                <td style="text-align: right">
                                                    $ {{$notificacion->cuadre}}</td>
                                                <td>
                                                    <span class="label bg-{{$notificacion->estatusPrepoliza->label }}">{{$notificacion->estatusPrepoliza}}</span>
                                                </td>
                                                <td>{{$notificacion->poliza_contpaq}}</td>
                                                <td style="min-width: 90px;max-width: 90px">
                                                    <a href="{{route('sistema_contable.poliza_generada.edit',$notificacion->poliza)}}"
                                                       title="Editar" class="btn btn-xs btn-info"><i
                                                                class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>

                                </table>
                            </div>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection