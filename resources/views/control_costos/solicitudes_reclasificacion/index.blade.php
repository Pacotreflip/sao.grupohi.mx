@extends('control_costos.layout')
@section('title', 'Reclasificación De Costos')
@section('contentheader_title', 'RECLASIFICACIÓN DE COSTOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('solicitud_reclasificacion') !!}
@endsection
@section('main-content')

<global-errors></global-errors>
<reclasificacion_costos-index
        :url_solicitudes_reclasificacion_index="'{{ route('solicitudes_reclasificacion') }}'"
        :solicitudes="{{ $data_view['solicitudes']  }}"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultados</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">

                    </div>
                </div>
            </div>
        </div>
    </section>
</reclasificacion_costos-index>

@endsection

