@extends('sistema_contable.layout')
@section('title', 'Notificaciones')

@section('main-content')

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$notificacion->titulo}}</h3>
                <div class="box-tools pull-right">

                    <div class="mailbox-controls with-border text-center">
                        <div class="btn-group">
                            <a href="{{ route('notificacion')}}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Bandeja de Entrada">
                                <i class="fa fa-reply"></i></a>
                        </div>
                      </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="mailbox-read-info">
                    <h3></h3>
                    <h5>From: saoweb@grupohi.mx
                        <span class="mailbox-read-time pull-right">{{$notificacion->created_at->format('Y-m-d h:i:s a')}}</span></h5>
                </div>

                <div class="mailbox-read-message">
                    <p><b>Estimado Colaborador:  {{$notificacion->usuario}}</b></p>
                    <p>Se le informa que las siguientes pólizas han sido registradas y tienen errores que deben corregirse  para que puedan ser enviadas al Contpaq.</p>
                    <p>Sugerimos tomar acciones correctivas.</p>
                    <p>Gracias,<br>SAO WEB</p>
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
                                    <td> @if($notificacion->estatus == \Ghi\Domain\Core\Models\Contabilidad\Poliza::REGISTRADA) <span class="label bg-blue">Registrada</span>@endif
                                        @if($notificacion->estatus == \Ghi\Domain\Core\Models\Contabilidad\Poliza::LANZADA) <span class="label bg-green">Lanzada</span>@endif
                                        @if($notificacion->estatus ==\Ghi\Domain\Core\Models\Contabilidad\Poliza::NO_LANZADA) <span class="label bg-yellow">No lanzada</span>@endif
                                        @if($notificacion->estatus == \Ghi\Domain\Core\Models\Contabilidad\Poliza::CON_ERRORES) <span class="label bg-red">Con errores</span>@endif</td>
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









@endsection