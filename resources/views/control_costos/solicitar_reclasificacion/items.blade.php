@extends('control_costos.layout')
@section('title', 'Solicitar Reclasificación - Items')
@section('contentheader_title', 'SOLICITAR RECLASIFICACIÓN - ITEMS')
@section('main-content')
    {!! Breadcrumbs::render('control_costos.solicitar_reclasificacion.index') !!}

<global-errors></global-errors>
<solicitar_reclasificacion-items
        :url_solicitar_reclasificacion_items="'{{ route('control_costos.solicitar_reclasificacion.items') }}'"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Título</h3>
                    </div>
                    <div class="box-body">
                        something something
                    </div>
                </div>
            </div>
        </div>
    </section>
</solicitar_reclasificacion-items>

@endsection

