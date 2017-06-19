@extends('modulo_contable.layout')
@section('title', 'Cuentas Contables')
@section('contentheader_title', 'CUENTAS CONTABLES')
@section('contentheader_description', '(CONFIGURACIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.cuenta_contable.index') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <cuenta-contable-create
                v-cloak
                inline-template>
            <section>
            </section>
        </cuenta-contable-create>
    </div>
@endsection