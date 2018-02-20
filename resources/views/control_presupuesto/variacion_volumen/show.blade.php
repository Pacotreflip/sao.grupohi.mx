@extends('control_presupuesto.layout')
@section('title', 'Cambios al Presupuesto')
@section('contentheader_title', 'VARIACIÓN DE VOLÚMEN (ADITIVAS Y DEDUCTIVAS)')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.variacion_volumen.show', $variacion_volumen) !!}
@endsection
@section('main-content')
    <variacion-volumen-show inline-template v-cloak>
        <section>

        </section>
    </variacion-volumen-show>
@endsection

