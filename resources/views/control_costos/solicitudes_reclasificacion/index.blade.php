@extends('control_costos.layout')
@section('title', 'Reclasificación De Costos')
@section('contentheader_title', 'RECLASIFICACIÓN DE COSTOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_costos.solicitudes_reclasificacion.index') !!}
@endsection
@section('main-content')

    <reclasificacion_costos-index inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultados</h3>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table" id="solicitudes_table">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Concepto Original</th>
                                    <th>Concepto Nuevo</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Item</th>
                                    <th>Concepto Original</th>
                                    <th>Concepto Nuevo</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </reclasificacion_costos-index>

@endsection

