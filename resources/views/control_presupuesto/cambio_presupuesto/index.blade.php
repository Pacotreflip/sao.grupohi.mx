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
                <div class="col-sm-12">
                    <a  href="{{ route('control_presupuesto.cambio_presupuesto.create') }}" class="btn btn-success btn-app" style="float:right">
                        <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultados</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="cierres_table" class="table table-bordered table-stripped">
                                    <thead>
                                    <tr>
                                        <th>Núnero de Folio</th>
                                        <th>Tipo Orden</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Usuario Solicita</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Núnero de Folio</th>
                                        <th>Tipo Orden</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Usuario Solicita</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="pdf_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="PDFModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detalles</h4>
                            </div>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </cambio-presupuesto-index>
@endsection
