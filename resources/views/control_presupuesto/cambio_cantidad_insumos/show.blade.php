@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CAMBIO DE CANTIDAD A INSUMOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.show',$solicitud) !!}
@endsection

@section('main-content')

    <cambio-cantidad-insumos-show
            inline-template
            :solicitud="{{$solicitud}}"
            :agrupacion="{{$agrupacion}}"
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
                    <button id="btn_autorizar" :disable="rechazando||autorizando"
                            class="btn btn-sm btn-app btn-info pull-right"
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
                                    <td><b>Insumos Modificados</b></td>
                                    <td>{{ $detalle_afectacion['conceptos_modificados'] }}</td>
                                </tr>
                                <tr>
                                    <td><b>Importe Insumos Modificados</b></td>
                                    <td class="text-right">
                                        ${{number_format( $detalle_afectacion['imp_conceptos_modif'] ,'2','.',',')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Importe Variación</b></td>
                                    <td class="text-right">
                                        ${{number_format( $detalle_afectacion['imp_variacion'] ,'2','.',',')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Importe Insumos Actualizados</b></td>
                                    <td class="text-right">
                                        ${{number_format( $detalle_afectacion['imp_conceptos_actualizados'] ,'2','.',',')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Importe Presupuesto Original</b></td>
                                    <td class="text-right">
                                        ${{number_format(  $detalle_afectacion['imp_pres_original'] ,'2','.',',')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Importe Presupuesto Actualizado</b></td>
                                    <td class="text-right">
                                        ${{number_format( $detalle_afectacion['imp_pres_actualizado'] ,'2','.',',')}}</td>
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
                            <p class="text-muted">@{{ solicitud.tipo_orden.cobrabilidad.descripcion}}</p>
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

                        <!-- /.box-body -->
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Insumos agregados</h3>
                        </div>
                        <div class="box-body ">

                                <div class="table-responsive col-md-12 container">
                                    <table id="agrupadores_tablex" class="table table-bordered"
                                           v-if="form.agrupacion.length>0">
                                        <thead>
                                        <tr>
                                            <th style="width:20px"></th>
                                            <th>Cantidad de insumos</th>
                                            <th v-text="'Agrupados por '+solicitud.filtro_cambio_cantidad.tipo_filtro.descripcion   "></th>
                                            <th>Cantidad original</th>
                                            <th class="bg-gray-active">Importe original</th>
                                            <th class="bg-gray-active">Importe Actualizado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="(agrupado,i) in form.agrupacion">
                                            <tr>
                                                <td>
                                                    <div class="btn btn-xs btn-default" :id="'div_expand_'+i"
                                                         :disabled="consultando" v-if="agrupado.mostrar_detalle"
                                                         v-on:click="consulta_detalle_agrupador(i)">
                                                            <span v-if="consultando&&i==row_consulta">
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                            </span>
                                                        <span v-else>
                                                            <i class="fa  fa-list"></i>
                                                            </span>
                                                    </div>
                                                    <div v-else class="btn btn-xs btn-default"
                                                         v-on:click="ocultar_detalle(i)">
                                                    <span>
                                                        <i class="fa  fa-minus"></i>
                                                    </span>
                                                    </div>
                                                </td>
                                                <td>@{{agrupado.cantidad}}</td>
                                                <td>@{{agrupado.agrupador}}</td>
                                                <td>@{{agrupado.precio_unitario_original}}</td>
                                                <td class="text-right bg-gray-active">
                                                    $@{{ parseFloat(agrupado.importe_original).formatMoney(2, '.',',') }}</td>
                                                <td class="text-right  bg-gray-active">
                                                    $@{{ parseFloat(agrupado.importe_actualizado).formatMoney(2, '.',',') }}</td>

                                            </tr>
                                            <tr v-if="agrupado.mostrar_detalle&&agrupado.items.length>0"
                                                :id="'tr_detalle_'+i">
                                                <td colspan="6">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <table class="table table-bordered table-stripped ">
                                                                <thead>
                                                                <tr>
                                                                    <th class="bg-gray-active">#</th>
                                                                    <th class="bg-gray-active">Sector</th>
                                                                    <th class="bg-gray-active">Cuadrante</th>
                                                                    <th class="bg-gray-active">Especialidad</th>
                                                                    <th class="bg-gray-active">Partida</th>
                                                                    <th class="bg-gray-active">Subpartida o Cuenta de
                                                                        costo
                                                                    </th>
                                                                    <th class="bg-gray-active">Concepto</th>
                                                                    <th class="bg-gray-active">Filtro10</th>
                                                                    <th class="bg-gray-active">Filtro11</th>
                                                                    <th class="bg-gray-active">Precio unitario
                                                                        original
                                                                    </th>
                                                                    <th class="bg-gray-active">Precio unitario nuevo
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr v-for="(item,i2) in agrupado.items">
                                                                    <td>@{{i2+1 }}</td>
                                                                    <td>@{{item.filtro4}}</td>
                                                                    <td>@{{item.filtro5}}</td>
                                                                    <td>@{{item.filtro6}}</td>
                                                                    <td>@{{item.filtro7}}</td>
                                                                    <td>@{{item.filtro8}}</td>
                                                                    <td>@{{item.filtro9}}</td>
                                                                    <td>@{{item.filtro10}}</td>
                                                                    <td>@{{item.filtro11}}</td>
                                                                    <td class="text-right">
                                                                        $@{{ parseFloat(item.precio_unitario_original).formatMoney(2, '.',',') }}</td>
                                                                    <td class="text-right">
                                                                        $@{{ parseFloat(item.precio_unitario_nuevo).formatMoney(2, '.',',') }}</td>
                                                                </tbody>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                            </td>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                        </template>
                                        </tbody>

                                    </table>
                                </div>

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
                            <iframe id="formatoPDF" style="width:99.6%;height:100%" frameborder="0"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </cambio-cantidad-insumos-show>
@endsection