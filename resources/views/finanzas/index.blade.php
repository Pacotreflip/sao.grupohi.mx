@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SISTEMA DE FINANZAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.index') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-6">
            <div class="list-group">
                <div class="list-group-item active">TRANSACCIONES</div>
                @permission('consultar_comprobante_fondo_fijo')
                <a href="{{route('finanzas.comprobante_fondo_fijo.index')}}" class="list-group-item">Comprobantes de Fondo Fijo</a>
                @endpermission
                @permission('consultar_solicitud_pago')
                <a href="{{ route('finanzas.solicitud_pago.index') }}" class="list-group-item">Solicitudes de Pago</a>
                @endpermission
                @permission('consultar_solicitud_recursos')
                <a href="{{ route('finanzas.solicitud_recursos.index') }}" class="list-group-item">Solicitudes de Recursos</a>
                @endpermission
            </div>
        </div>
    </div>
@endsection
