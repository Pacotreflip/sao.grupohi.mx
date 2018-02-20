@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.show',$solicitud) !!}
@endsection


@section('main-content')
    <show-variacion-insumos
            inline-template
            :solicitud="{{$solicitud}}"
            :presupuestos="{{$presupuestos}}"
            :conceptos_agrupados="{{json_encode($conceptos_agrupados['conceptos'])}}"
            :total_proforma_agrupados="{{json_encode($conceptos_agrupados['maximo_proforma'])}}"

            v-cloak xmlns:v-on="http://www.w3.org/1999/xhtml">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-app btn-danger pull-right" v-on:click="confirm_rechazar_solicitud"
                       v-if="solicitud.id_estatus==1">
                        <span v-if="rechazando"><i class="fa fa-spinner fa-spin"></i> Rechazando</span>
                        <span v-else><i class="fa fa-close"></i> Rechazar</span>
                    </a>
                    <a class="btn btn-sm btn-app btn-info pull-right" v-on:click="confirm_autorizar_solicitud"
                       v-if="solicitud.id_estatus==1">
                        <span v-if="autorizando"><i class="fa fa-spinner fa-spin"></i> Autorizando</span>
                        <span v-else><i class="fa fa-check"></i> Autorizar</span>
                    </a>
                </div>

                <div class="col-md-3">
                    <div class="box box-solid" id="detalles_impactos">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle de Afectaciones</h3>
                        </div>
                        <div class="box-body">
                            <strong>Conceptos Modificados</strong>
                            <p class="text-muted">@{{ (conceptos_agrupados).length }}</p>
                            <hr>
                            <strong>Importe Conceptos Modificados</strong>
                            <p class="text-muted text-right">
                                ${{number_format( $conceptos_agrupados['imp_nuevo_gen']-$conceptos_agrupados['total_variaciones'],'2','.',',')}}</p>
                            <hr>
                            <strong>Importe Variación</strong>
                            <p class="text-muted text-right">
                                ${{number_format($conceptos_agrupados['total_variaciones'],'2','.',',')}}</p>
                            <hr>
                            <strong>Importe Conceptos Actualizados</strong>
                            <p class="text-muted text-right">
                                ${{number_format($conceptos_agrupados['imp_nuevo_gen'],'2','.',',')}}</p>
                            <hr>
                            <strong>Importe Presupuesto Original</strong>
                            <p class="text-muted text-right">
                                ${{number_format( $conceptos_agrupados['total_presupuesto'],'2','.',',')}}</p>
                            <hr>
                            <strong>Importe Presupuesto Actualizado</strong>
                            <p class="text-muted text-right">
                                ${{number_format($conceptos_agrupados['total_presupuesto']+$conceptos_agrupados['total_variaciones'],'2','.',',')}}</p>
                            <hr>
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
                            <hr>
                            <strong>Cobrabilidad:</strong>
                            <p class="text-muted">@{{ solicitud.tipo_orden.cobrabilidad.descripcion}}</p>
                            <hr>
                            <strong>Tipo de Orden de Cambio:</strong>
                            <p class="text-muted">@{{solicitud.tipo_orden.descripcion}}</p>
                            <hr>
                            <strong>Motivo:</strong>
                            <p class="text-muted">@{{solicitud.motivo}}</p>
                            <hr>
                            <strong>Usuario que Solicita:</strong>
                            <p class="text-muted">@{{solicitud.user_registro.apaterno +' '+ solicitud.user_registro.amaterno+' '+solicitud.user_registro.nombre}}</p>
                            <hr>
                            <strong>Fecha de solicitud:</strong>
                            <p class="text-muted">@{{solicitud.fecha_solicitud}}</p>
                            <hr>
                            <strong>Estatus:</strong>
                            <p class="text-muted">@{{solicitud.estatus.descripcion}}</p>
                            <hr>

                        </div>

                        <!-- /.box-body -->
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Conceptos Agrupados</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12" v-if="total_proforma_agrupados.diferencia<0">
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-ban"></i> Atención!</h4>
                                        El Importe Conceptos Actualizados es mayor al importe del presupuesto proforma. Maximo proforma: $ @{{parseFloat(total_proforma_agrupados.maximo).formatMoney(2, ',','.')}} ,Variación: $ @{{parseFloat(Math.abs(total_proforma_agrupados.diferencia)).formatMoney(2, ',','.') }}
                                    </div>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Concepto</th>
                                    <th>Volumen</th>
                                    <th>Importe Original</th>
                                    <th>Variación de Importe</th>
                                    <th>Importe Actualizado</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(agrupado, i) in conceptos_agrupados" :title="agrupado.concepto.path"
                                    style="cursor:pointer" v-on:click="mostrarDetalleInsumos(i)">
                                    <td>@{{(i+1)}}</td>
                                    <td>@{{ (agrupado.concepto.descripcion).substr(0, 50) + '...' }}</td>
                                    <td>@{{ parseFloat(agrupado.concepto.cantidad_presupuestada).formatMoney(2, ',','.') }}</td>
                                    <td class="text-right">
                                        $ @{{ parseFloat(agrupado.concepto.importe_anterior).formatMoney(2, ',','.') }}</td>
                                    <td class="text-right">
                                        $ @{{ parseFloat(agrupado.concepto.variacion).formatMoney(2, ',','.') }}</td>
                                    <td class="text-right">
                                        $ @{{ parseFloat(agrupado.concepto.importe_nuevo).formatMoney(2, ',','.') }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12" class="text-center">
                        <span v-if="consultando"><i class="fa fa-spinner fa-spin"></i> </span>
                        <span v-else></span>
                    </div>
                    <div class="box box-solid" id="divDetalle" style="display: none;">
                        <div class="box-header with-border">
                            <h3 class="box-title">Afectacion de insumos</h3>
                        </div>
                        <div class="box-body">
                            <div v-for="(tipos, i) in clasificacion" v-show="tipos.items.length >0">
                                <table class="table table-striped table-bordered">

                                    <thead>
                                    <tr class="bg-gray-light">
                                        <th colspan="6" rowspan="3"><h4>@{{ tipos.tipo }}</h4></th>
                                    </tr>
                                    <tr class="bg-gray-active">
                                        <th>Importe Original</th>
                                        <th>Variación de Importe</th>
                                        <th>Importe Actualizado</th>
                                    </tr>
                                    <tr class="bg-gray-active">
                                        <td class="text-right">
                                            $ @{{ parseFloat(tipos.monto_original).formatMoney(2,'.',',') }}</td>
                                        <td class="text-right">
                                            $ @{{ parseFloat(tipos.variacion).formatMoney(2,'.',',') }}</td>
                                        <td class="text-right">
                                            $ @{{ parseFloat((tipos.monto_nuevo)).formatMoney(2,'.',',') }}</td>
                                    </tr>

                                    <tr>
                                        <th>#</th>
                                        <th style="width: 40%;">Descripción</th>
                                        <th>Unidad</th>
                                        <th>Volumen Original</th>
                                        <th>Volumen Actualizado</th>
                                        <th>Costo Original</th>
                                        <th>Costo Actualizado</th>
                                        <th>Importe Original</th>
                                        <th>Importe Actualizado</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <tr v-for="(insumo, i) in tipos.items">
                                        <td>@{{ i+1 }}</td>
                                        <td>@{{ insumo.material.descripcion }}</td>
                                        <td>@{{ insumo.material.unidad }}</td>
                                        <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(2,'.',',') }}</td>
                                        <td>@{{ parseFloat(insumo.cantidad_presupuestada_nueva).formatMoney(2,'.',',') }}</td>
                                        <td class="text-right">
                                            $@{{ parseFloat(insumo.precio_unitario_original).formatMoney(2,'.',',') }}</td>
                                        <td class="text-right">
                                            $@{{ parseFloat(insumo.precio_unitario_nuevo).formatMoney(2,'.',',') }}</td>
                                        <td class="text-right">
                                            $@{{ parseFloat(insumo.cantidad_presupuestada*insumo.precio_unitario_original).formatMoney(2,'.',',') }}</td>
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </show-variacion-insumos>
@endsection