@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SISTEMA DE FINANZAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.index') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <ul class="nav nav-stacked">
                            @permission('consultar_solicitud_pago')
                            <li><a href="{{ route('finanzas.solicitud_pago.index') }}">SOLICITUD DE PAGO</a> </li>
                            @endpermission
                            @permission('consultar_comprobante_fondo_fijo')
                            <li><a href="{{route('finanzas.comprobante_fondo_fijo.index')}}">COMPROBANTE DE FONDO FIJO</a></li>
                            @endpermission
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
