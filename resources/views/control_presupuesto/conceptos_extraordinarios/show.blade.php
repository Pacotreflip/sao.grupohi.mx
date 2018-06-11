@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONCEPTOS EXTRAORDINARIOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.show',$solicitud) !!}
@endsection

@section('main-content')
    <concepto-extraordinario-show
            inline-template
            :solicitud="{{$solicitud}}"
            :partidas="{{json_encode($partidas)}}"
            :resumen="{{json_encode($resumen)}}"
            v-cloak xmlns:v-on="http://www.w3.org/1999/xhtml">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <button id="btn_rechazar" class="btn btn-app btn-danger pull-right"
                            v-on:click="confirm_rechazar_solicitud"
                            v-if="solicitud.id_estatus==1">
                        <span v-if="rechazando"><i class="fa fa-spinner fa-spin"></i> Rechazando</span>
                        <span v-else><i class="fa fa-close"></i> Rechazar</span>
                    </button>
                    <button  id="btn_autorizar" :disable="rechazando||autorizando" class="btn btn-sm btn-app btn-info pull-right"
                             v-on:click="confirm_autorizar_solicitud"
                             v-if="solicitud.id_estatus==1">
                        <span v-if="autorizando"><i class="fa fa-spinner fa-spin"></i> Autorizando</span>
                        <span v-else><i class="fa fa-check"></i> Autorizar</span>
                    </button>
                </div>

                <div class="col-md-3">
                    <div class="box box-solid" id="detalles_impactos">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle de Afectaciones</h3>
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <tr>
                                    <td><b>Importe Concepto Extraordinario</b></td>
                                    <td class="text-right">$ @{{ parseFloat((partidas.monto_presupuestado)).formatMoney(2,'.',',') }}</td>
                                </tr>
                                    <td><b>Importe Presupuesto Original</b></td>
                                    <td class="text-right" v-if="solicitud.id_estatus == 1 || solicitud.id_estatus == 3">$ @{{ parseFloat((resumen.monto_presupuestado)).formatMoney(2,'.',',') }}</td>
                                    <td class="text-right" v-else>$ @{{ parseFloat((resumen.monto_presupuestado_original)).formatMoney(2,'.',',') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Importe Presupuesto Actualizado</b></td>
                                    <td class="text-right" v-if="solicitud.id_estatus == 1  || solicitud.id_estatus == 3">$ {{ number_format(($resumen->monto_presupuestado+$partidas['monto_presupuestado']),'2','.',',')}}</td>
                                    <td class="text-right" v-else>$ @{{ parseFloat((resumen.monto_presupuestado_actualizado)).formatMoney(2,'.',',') }}</td>
                                </tr>
                            </table>

                        </div>
                    </div>

                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle de la solicitud</h3>
                            <div class="pull-right">
                                <span class="label"></span>
                                <button class="btn btn-xs btn-info mostrar_pdf" :data-pdf_id="solicitud.id"
                                        title="Formato"><i class="fa fa-file-pdf-o"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong>Folio de la solicitud:</strong>
                            <p class="text-muted">@{{ solicitud.numero_folio}}</p>
                            <strong>Cobrabilidad:</strong>
                            <p class="text-muted">@{{ solicitud.tipo_orden.descripcion}}</p>
                            <strong>Tipo de Orden de Cambio:</strong>
                            <p class="text-muted">@{{solicitud.tipo_orden.descripcion}}</p>
                            <strong>Motivo:</strong>
                            <p class="text-muted">@{{solicitud.motivo}}</p>
                            <strong>Usuario que Solicita:</strong>
                            <p class="text-muted">@{{solicitud.user_registro.apaterno +' '+ solicitud.user_registro.amaterno+' '+solicitud.user_registro.nombre}}</p>
                            <strong>Fecha de solicitud:</strong>
                            <p class="text-muted">@{{solicitud.fecha_solicitud}}</p>
                            <strong>Estatus:</strong>
                            <p class="text-muted">@{{solicitud.estatus.descripcion}}</p>

                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Concepto Extraordinario</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped table-bordered">

                                <thead>
                                <tr class="bg-gray-light">
                                    <th colspan="2" rowspan="9" width="60%"><b>@{{ partidas.descripcion }}</b></th>
                                </tr>
                                <tr class="bg-gray-active">
                                    <th>Unidad</th>
                                    <th v-show="partidas.agrupadores[5].insumos.length <= 0">Volumen</th>
                                    <th v-show="partidas.agrupadores[5].insumos.length <= 0">Costo</th>
                                    <th>Importe</th>
                                </tr>

                                <tr class="bg-gray-active">
                                    <td >@{{ partidas.unidad }}</td>
                                    <td  v-show="partidas.agrupadores[5].insumos.length <= 0">@{{ parseFloat((partidas.cantidad_presupuestada)).formatMoney(2,'.',',') }}</td>
                                    <td class="text-right" v-show="partidas.agrupadores[5].insumos.length <= 0">$ @{{ parseFloat((partidas.precio_unitario)).formatMoney(2,'.',',') }}</td>
                                    <td class="text-right">$ @{{ parseFloat((partidas.monto_presupuestado)).formatMoney(2,'.',',') }}</td>
                                </tr>
                                </thead>
                            </table>
                            <br>
                            <div v-for="(tipos, i) in partidas.agrupadores" v-show="tipos.insumos.length >0">
                                <table class="table table-striped table-bordered">

                                    <thead>
                                    <tr class="bg-gray-light">
                                        <th colspan="3" rowspan="3" width="80%" v-if="tipos.descripcion == 'GASTOS'"><h4>@{{ tipos.descripcion }}</h4></th>
                                        <th colspan="5" rowspan="3" width="80%" v-else><h4>@{{ tipos.descripcion }}</h4></th>

                                    </tr>
                                    <tr class="bg-gray-active">
                                        <th width="10%">Importe Agrupador</th>
                                    </tr>
                                    <tr class="bg-gray-active">
                                        <td class="text-right">
                                            $ @{{ parseFloat((tipos.monto_presupuestado)).formatMoney(2,'.',',') }}</td>
                                    </tr>

                                    <tr>
                                        <th>#</th>
                                        <th style="width: 40%;">Descripción</th>
                                        <th>Unidad</th>
                                        <th v-show="tipos.descripcion != 'GASTOS'">Volumen</th>
                                        <th v-show="tipos.descripcion != 'GASTOS'">Costo</th>
                                        <th>Importe</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                        <tr v-for="(insumo, i) in tipos.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td v-show="tipos.descripcion != 'GASTOS'">
                                                @{{ parseFloat(insumo.cantidad_presupuestada_nueva).formatMoney(2,'.',',') }}</td>
                                            <td class="text-right" v-show="tipos.descripcion != 'GASTOS'">
                                                $@{{ parseFloat(insumo.precio_unitario_nuevo).formatMoney(2,'.',',') }}</td>
                                            <td class="text-right">
                                                $@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pdf_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="PDFModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
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

        </section>
    </concepto-extraordinario-show>
@endsection