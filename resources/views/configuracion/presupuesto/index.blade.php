@extends('configuracion.layout')
@section('title', 'Configuración del Presupuesto')
@section('contentheader_title', 'CONFIGURACIÓN DEL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('configuracion.presupuesto.index') !!}
@endsection
@section('main-content')
    <configuracion-presupuesto-index inline-template v-cloak>
        <section>

        </section>
    </configuracion-presupuesto-index>
@endsection

