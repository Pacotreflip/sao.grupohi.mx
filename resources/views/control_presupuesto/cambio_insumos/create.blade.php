@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'SOLICITUD DE CAMBIO AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-insumos-create inline-template v-cloak :id_tipo_orden="{{$tipo_orden}}"
                        bases_afectadas="{{$presupuestos->toJson()}}">
        <section>

        </section>
    </cambio-insumos-create>

@endsection

