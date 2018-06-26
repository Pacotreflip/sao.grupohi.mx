@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.create') !!}
@endsection
@section('main-content')
    <solicitud-recursos-create v-cloak></solicitud-recursos-create>
@endsection
