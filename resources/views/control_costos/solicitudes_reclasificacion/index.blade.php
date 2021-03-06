@extends('control_costos.layout')
@section('title', 'Solicitudes de Reclasificación Registradas')
@section('contentheader_title', 'SOLICITUDES DE RECLASIFICACIÓN REGISTRADAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_costos.solicitudes_reclasificacion.index') !!}
@endsection
@section('main-content')

    <reclasificacion_costos-index
        :repetidas="{{ json_encode($repetidas)  }}"
        :solicitar_reclasificacion="{{ \Entrust::can(['solicitar_reclasificacion']) ? 'true' : 'false' }}"
        :consultar_reclasificacion="{{ \Entrust::can(['consultar_reclasificacion']) ? 'true' : 'false' }}"
        :autorizar_reclasificacion="{{ \Entrust::can(['autorizar_reclasificacion']) ? 'true' : 'false' }}"
        inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-9">
                    &nbsp;
                </div>
                <div class="col-md-3">
                    <a href="{{ route('control_costos.solicitar_reclasificacion.index') }}" class="btn btn-sm btn-primary pull-right">Solicitar otra clasificación</a>
                </div>
                <div class="col-md-12">
                    &nbsp;
                </div>
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">

                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table" id="solicitudes_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Motivo</th>
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
            <div id="solicitud_detalles_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="DetallesModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document" style="width: 70% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Detalles
                                <small class="text-muted"> #@{{ item.id }} @{{ new Date(item.fecha ? item.fecha : item.created_at).dateShortFormat() }} Estatus: @{{ item.estatus_desc }}</small>
                            </h4>
                        </div>
                        <div class="modal-body show_pdf" v-if="show_pdf">
                            <iframe :src="show_pdf"  frameborder="0" height="600px" width="99.6%">d</iframe>
                        </div>
                        <div class="modal-body" v-else>
                            <div class="row" v-if="!rechazando">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Tipo Transacción</th>
                                                <th>Folio</th>
                                                <th>Item</th>
                                                <th>Cantidad</th>
                                                <th>Importe</th>
                                                <th>Costo Origen</th>
                                                <th>Costo Destino</th>
                                                <template v-if="editando">
                                                    <th>Fecha</th>
                                                    <th>Creado por</th>
                                                </template>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in partidas">
                                                    <td>@{{ item.item.transaccion.tipo_transaccion_string != undefined ? item.item.transaccion.tipo_transaccion_string : '-' }}</td>
                                                    <td>#@{{ item.item.transaccion.numero_folio }}</td>
                                                    <td >@{{ (item.item.transaccion.tipo_tran.Tipo_Transaccion == 52 ? item.item.contrato.descripcion :  item.item.material.descripcion) }}</td>
                                                    <td class="text-right">@{{ item.item.cantidad }}</td>
                                                    <td class="text-right">@{{  parseInt(item.item.importe).formatMoney(2, '.', ',') }}</td>
                                                    <td ><span :title="item.concepto_original.path">[@{{ item.concepto_original.clave  }}] @{{ item.concepto_original.descripcion }}</span></td>
                                                    <td ><span :title="item.concepto_nuevo.path">[@{{ item.concepto_nuevo.clave  }}] @{{ item.concepto_nuevo.descripcion }}</span></td>
                                                    <template v-if="editando">
                                                        <td>@{{  new Date(editando.created_at).dateShortFormat() }}</td>
                                                        <td>@{{ editando.usuario.nombre +' '+ editando.usuario.apaterno }}</td>
                                                    </template>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="box box-default box-solid" v-if="!editando">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Motivo</h3>
                                            </div>
                                            <div class="box-body">
                                                @{{ html_decode(item.motivo) }}
                                            </div>
                                        </div>
                                        <div class="col-md-12" v-if="!editando">
                                            <div class="pull-right">
                                                <button type='button' title='Formato' class='btn btn-info btn_pdf' v-on:click="pdf(item.id)"><i class='fa fa-file-pdf-o'>  Formato</i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <template v-if="editando">
                                    <div class="col-md-12">
                                        <div class="box box-default box-solid">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Motivo</h3>
                                            </div>
                                            <div class="box-body">
                                                @{{ html_decode(editando.motivo) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box box-solid">
                                            <div class="box-header with-border">
                                                <i class="fa fa-thumbs-up"></i>
                                                <h3 class="box-title">Aprobaciones pendientes:</h3>
                                            </div>
                                            <div class="box-body">
                                                <ul class="list-unstyled">
                                                    <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull-right">
                                            <button type='button' title='Formato' class='btn btn-info btn_pdf' v-on:click="pdf(item.id)"><i class='fa fa-file-pdf-o'> Formato</i></button>
                                            <button type="button" class="btn btn-success" v-on:click="confirm('aprobar')"> <i class="fa fa-fw fa-thumbs-up" v-if="autorizar_reclasificacion"></i>Aprobar</button>
                                            <button type="button" class="btn btn-danger" v-on:click="rechazar_motivo()" v-if="autorizar_reclasificacion"> <i class="fa fa-fw fa-trash"></i> Rechazar</button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div class="row" v-else>
                                <div class="col-md-12">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Indique el motivo del rechazo de la solicitud</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="motivo..." v-model="rechazo_motivo"></textarea>
                                            </div>
                                            <div class="pull-right">
                                                <button type="button" class="btn btn-danger" v-on:click="confirm('rechazar')" v-if="autorizar_reclasificacion">Rechazar</button>
                                                <button type="button" class="btn btn-default" v-on:click="cancelar_rechazo()">Cancelar</button>
                                            </div>
                                            <div>
                                                El motivo será compartido con los demás responsables de aprobación
                                            </div>
                                        </div>
                                    </div>
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

