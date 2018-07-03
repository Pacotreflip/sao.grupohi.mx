@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE RECURSOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_recursos.edit', $solicitud) !!}
@endsection
@section('main-content')
    <div class="row">
        {!!

        \Carbon\Carbon::setToStringFormat('d/m/Y');
        $date = new \Carbon\Carbon();
        $date->setISODate($solicitud->anio, $solicitud->semana);

        !!}

        <div class="col-md-12">
            <h4 class="pull-right">Semana {{ $solicitud->semana }} del {{$date->startOfWeek()->toFormattedDateString()}} al {{$date->endOfWeek()->toFormattedDateString()}} ({{$solicitud->tipo->descripcion}}) </h4>
        </div>
    </div>
    <solicitud-recursos-edit v-cloak :id="{{$solicitud->id}}"></solicitud-recursos-edit>
@endsection
