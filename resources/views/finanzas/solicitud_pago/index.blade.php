@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE PAGO')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_pago.index') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Resultados</h3>
            <div class="box-tools">
                <a  href="{{ route('finanzas.solicitud_pago.create') }}" class="btn btn-default btn-sm">
                    <i class="glyphicon glyphicon-plus-sign"></i> Nueva Solicitud de Pago
                </a>
            </div>
        </div>
        <div class="box-body">
            <solicitud-pago-index v-cloak></solicitud-pago-index>
        </div>
    </div>
        </div>
    </div>
@endsection
