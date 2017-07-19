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
                                <span class="mailbox-read-time pull-right">{{$notificacion->created_at->format('Y-m-d h:i:s a')}}</span></h5>
                        </div>

                        <div class="mailbox-read-message">
                            <p><b>Estimado Colaborador  {{$notificacion->usuario}}</b></p>
                            <p>Se le informa que las siguientes pólizas han sido registradas y tienen errores que deben corregirse  para que puedan ser enviadas al Contpaq.</p>

                        </div>
                    </div>
                    <div class="box-footer">
                        <ul class="mailbox-attachments clearfix">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped small" >
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Numero de Pre-Póliza</th>
                                        <th>Tipo de Póliza</th>
                                        <th>Concepto</th>
                                        <th>Total</th>
                                        <th>Cuadre</th>
                                        <th>Estatus</th>
                                        <th>Póliza ContPaq</th>
                                        <th>Editar</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                    @foreach($notificacion_poliza as $index=>$notificacion)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$notificacion->id_int_poliza}}</td>
                                            <td>{{$notificacion->tipo_poliza}}</td>
                                            <td>{{$notificacion->concepto}}</td>
                                            <td style="text-align: right">$ {{$notificacion->total}}</td>
                                            <td style="text-align: right">$ {{$notificacion->cuadre}}</td>
                                            <td>
                                                <span class="label bg-{{$notificacion->estatusPrepoliza->label}}">{{$notificacion->estatusPrepoliza}}</span>
                                            </td>
                                            <td>{{$notificacion->poliza_contpaq}}</td>
                                            <td style="min-width: 90px;max-width: 90px">
                                                <a href="{{route('sistema_contable.poliza_generada.edit',$notificacion->poliza)}}" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection