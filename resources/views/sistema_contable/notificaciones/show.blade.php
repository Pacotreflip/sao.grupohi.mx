@extends('sistema_contable.layout')
@section('title', 'Notificaciones')
@section('contentheader_title', 'Notificaciones')
@section('contentheader_description', '(Detalle)')
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                           {!! $notificacion->body !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection