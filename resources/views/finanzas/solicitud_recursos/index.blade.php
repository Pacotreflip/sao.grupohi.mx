@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.index') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <solicitud-recursos-index
                    :permission_modificar_solicitud_recursos="{{ \Entrust::can('modificar_solicitud_recursos') ? 'true' : 'false' }}"
                    :permission_consultar_solicitud_recursos="{{ \Entrust::can('consultar_solicitud_recursos') ? 'true' : 'false' }}"
                    :permission_eliminar_solicitud_recursos="{{ \Entrust::can('eliminar_solicitud_recursos') ? 'true' : 'false' }}"
                    v-cloak
            >
            </solicitud-recursos-index>
        </div>
    </div>
@endsection
