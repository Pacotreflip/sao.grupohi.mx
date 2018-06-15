@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE PAGO')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_pago.index') !!}
@endsection
@section('main-content')
    <solicitud-pago-index v-cloak></solicitud-pago-index>
@endsection
