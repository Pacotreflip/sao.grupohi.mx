@extends('control_costos.layout')
@section('title', 'Control de Costos')
@section('contentheader_title', 'CONTROL DE COSTOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_costos.index') !!}
@endsection
@section('main-content')

    @permission(['consultar_reclasificacion'])
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            @permission('consultar_reclasificacion')
                            <li><a href="{{ route('control_costos.solicitar_reclasificacion.index') }}">SOLICITAR RECLASIFICACIÓN</a></li>
                            <li ><a href="{{route('control_costos.solicitudes_reclasificacion.index')}}">SOLICITUDES DE RECLASIFICACIÓN REGISTRADAS</a></li>
                            @endpermission
                            @permission('eliminar')
                            <li><a></a></li>
                            @endpermission
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endpermission

@endsection

