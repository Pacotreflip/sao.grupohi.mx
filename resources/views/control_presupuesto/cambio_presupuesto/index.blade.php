@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.index') !!}
@endsection
@section('main-content')
    <cambio-presupuesto-index inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultados</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <div class="table table-bordered table-striped">
                                    <table>
                                        <thead>
                                        <tr></tr>
                                        </thead>
                                        <tbody>
                                        <tr></tr>
                                        </tbody>
                                        <tfoot>
                                        <tr></tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </cambio-presupuesto-index>
@endsection
