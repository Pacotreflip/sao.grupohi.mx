@extends('sistema_contable.layout')
@section('title', 'Notificaciones')
@section('contentheader_title', 'Notificaciones')
@section('main-content')
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Bandeja de Entrada.</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">
                            <table  class="table table-bordered table-striped dataTable index_table" role="grid"
                                    aria-describedby="tipo_cuenta_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending" style="display:none">#</th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta"  style="display:none"></th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta"  style="display:none"></th>
                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta"  style="display:none"></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($notificaciones as $index => $notificacion)
                                    <tr>
                                        <td><i class="fa {{$notificacion->leida?'fa-envelope-open text-gray':'fa-envelope text-yellow'}}"></i></td>
                                        <td>{{$notificacion->remitente}}</td>
                                        <td><a href="{{route('sistema_contable.notificacion.show',$notificacion->id)}}">{{$notificacion->titulo}}</a></td>
                                        <td>{{$notificacion->created_at->format('Y-m-d h:i:s a')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
@endsection