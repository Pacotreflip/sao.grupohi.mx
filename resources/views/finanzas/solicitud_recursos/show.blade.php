@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.show', $solicitud) !!}
@endsection
@section('main-content')
    <solicitud-recursos-show v-cloak :id="{{$solicitud->id}}"></solicitud-recursos-show>
@endsection
