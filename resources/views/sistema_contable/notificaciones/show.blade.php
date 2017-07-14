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
                    <p><b>Estimado:  {{$notificacion->usuario}}</b></p>
                    <p>Le informamos que las siguentes polizas tienen un error, por lo cual no podran ser lanzadas hasta no ser corregidas.</p>
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
                </ul>
            </div>
        </div>
    </div>









@endsection