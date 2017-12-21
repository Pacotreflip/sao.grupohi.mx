@extends('control_costos.layout')
@section('title', 'Control de Costos')
@section('contentheader_title', 'CONTROL DE COSTOS')
@section('main-content')
    {!! Breadcrumbs::render('control_costos.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            {{--@permission(['consultar_movimiento_bancario'])--}}
                            <li><a href="{{ route('control_costos.solicitar_reclasificacion.index') }}">SOLICITAR RECLASIFICACIÓN</a></li>
                            {{--@endpermission--}}
                            {{--@permission(['consultar_traspaso_cuenta'])--}}
                            <li><a href="{{ route('control_costos.reclasificacion_costos.index') }}">RECLASIFICACIÓN DE COSTOS</a></li>
                            {{--@endpermission--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
