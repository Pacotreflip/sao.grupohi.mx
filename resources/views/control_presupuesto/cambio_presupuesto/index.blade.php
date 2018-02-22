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
                    <a  href="#" class="btn btn-success
                    btn-app" style="float:right" v-on:click="openSelectModal()">
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
                                        <th>Número de Folio</th>
                                        <th>Tipo Orden</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Usuario Solicita</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Número de Folio</th>
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
                <div id="pdf_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="PDFModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detalles</h4>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-spin fa-spinner fa-5x text-center" id="spin_iframe" style="margin: auto;
                            display: block;"></i>
                                <iframe id="formatoPDF"  style="width:99.6%;height:100%" frameborder="0"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="select_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="SelectModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Seleccione el Tipo de Solicitud de Cambio que desea crear</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cobrabilidad"><b>Cobrabilidad:</b></label>
                                            <select class="form-control input-sm" v-model="form.id_tipo_cobrabilidad" @change="form.id_tipo_orden = ''" :disabled="!tipos_cobrabilidad.length">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="tipo_cobrabilidad in tipos_cobrabilidad" :value="tipo_cobrabilidad.id">@{{ tipo_cobrabilidad.descripcion }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cobrabilidad"><b>Tipo de Solicitud:</b></label>
                                            <select class="form-control input-sm" v-model="form.id_tipo_orden" :disabled="!tipos_orden_filtered.length">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="tipo_orden in tipos_orden_filtered" :value="tipo_orden.id">@{{ tipo_orden.descripcion }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        v-on:click="crearSolicitud()" :disabled="!form.id_tipo_orden">Crear</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </cambio-presupuesto-index>
@endsection
