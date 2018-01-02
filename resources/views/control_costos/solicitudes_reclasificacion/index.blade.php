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
                                    <th>Motivo</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Motivo</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="solicitud_detalles_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="DetallesModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document" style="width: 70% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detalles</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Tipo Transacción</th>
                                            <th>Folio</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                            <th>Costo Origen</th>
                                            <th>Costo Destino</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in partidas">
                                                <td >@{{ item.item.material.descripcion }}</td>
                                                <td>@{{ item.item.transaccion.tipoTransaccion != undefined ? item.item.transaccion.tipoTransaccion.Descripcion : '-' }}</td>
                                                <td>#@{{ item.item.transaccion.numero_folio }}</td>
                                                <td class="text-right">@{{ item.item.cantidad }}</td>
                                                <td class="text-right">@{{  parseInt(item.item.importe).formatMoney(2, '.', ',') }}</td>
                                                <td >@{{ item.concepto_original.clave  }}</td>
                                                <td >@{{ item.concepto_nuevo.clave  }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" v-on:click="close_modal_detalles()">Cerrar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </section>
    </reclasificacion_costos-index>

@endsection

