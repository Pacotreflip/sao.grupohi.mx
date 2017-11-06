@extends('reportes.layout')
@section('title', 'Reportes')
@section('contentheader_title', 'REPORTES')
@section('breadcrumb')
    {!! Breadcrumbs::render('reportes.index') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @permission(['consultar_reporte_estimacion'])
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#subcontratos" data-toggle="tab" aria-expanded="true">Subcontratos</a></li>
                </ul>
                @endpermission

                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            @permission('consultar_reporte_estimacion')
                            <li><a href="{{ route('reportes.subcontratos.estimacion') }}">ORDEN DE PAGO ESTIMACIÓN</a></li>
                            @endpermission
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

