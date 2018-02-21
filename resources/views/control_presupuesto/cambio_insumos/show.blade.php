@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.show',$solicitud) !!}
@endsection

@section('main-content')
    <cambio-insumos-show
            inline-template
            :solicitud="{{$solicitud->toJson()}}"
            :cobrabilidad="{{$cobrabilidad->toJson()}}"
            :presupuestos="{{$presupuestos->toJson()}}"
            v-cloak>
        <section>

        </section>
    </cambio-insumos-show>
@endsection