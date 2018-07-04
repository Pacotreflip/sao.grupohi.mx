@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.edit', $solicitud) !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <h4 class="pull-right">Semana {{ $solicitud->semana }} del {{$solicitud->dia_inicio->format('d/m/Y')}} al {{$solicitud->dia_fin->format('d/m/Y')}} ({{$solicitud->tipo->descripcion}}) </h4>
        </div>
    </div>
    <solicitud-recursos-edit v-cloak :id="{{$solicitud->id}}"></solicitud-recursos-edit>
@endsection
