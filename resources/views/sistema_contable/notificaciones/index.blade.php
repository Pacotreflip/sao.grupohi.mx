@extends('sistema_contable.layout')
@section('title', 'Notificaciones')
@section('contentheader_title', 'Notificaciones')
@section('contentheader_description', '(LISTA)')
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box-body">
                    <div class="row table-responsive">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable"
                                   role="grid"
                                   aria-describedby="tipo_cuenta_info">
                                <thead>

                                </thead>
                                <tbody>

                                @foreach($notificaciones as $index => $notificacion)
                                    <tr>
                                        <td><i class="fa {{$notificacion->leida?'fa-envelope-open text-gray':'fa-envelope text-yellow'}}"></i></td>
                                        <td><a href="{{route('notificacion.show',$notificacion->id)}}">{{$notificacion->titulo}}</a></td>
                                        <td>{{$notificacion->total_polizas}} Polizas</td>
                                        <td>{{$notificacion->created_at->format('Y-m-d h:i:s a')}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection