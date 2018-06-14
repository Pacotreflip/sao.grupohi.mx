@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE CHEQUE')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_cheque.index') !!}
@endsection
@section('main-content')
    <solicitud-cheque-index v-cloak></solicitud-cheque-index>
@endsection
