@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.index') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Resultados</h3>
                    <div class="box-tools">
                        <a  href="{{ route('finanzas.solicitud_recursos.create') }}" class="btn btn-default btn-sm">
                            <i class="glyphicon glyphicon-plus-sign"></i> Nueva Solicitud de Recursos
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <solicitud-recursos-index v-cloak></solicitud-recursos-index>
                </div>
            </div>
        </div>
    </div>
@endsection
