@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.edit') !!}
@endsection
@section('main-content')
    <solicitud-recursos-edit v-cloak :id="{{$solicitud->id}}"></solicitud-recursos-edit>
@endsection
