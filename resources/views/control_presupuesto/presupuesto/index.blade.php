@extends('control_costos.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
@section('main-content')
    {!! Breadcrumbs::render('control_presupuesto.presupueso.index') !!}

<global-errors></global-errors>
<control_presupuesto-index
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-sm btn-primary pull-right" >Agregar Filtro</button>
            </div>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>

    </section>
</control_presupuesto-index>

@endsection

