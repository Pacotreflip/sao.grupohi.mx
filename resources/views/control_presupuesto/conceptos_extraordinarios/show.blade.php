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
            v-cloak xmlns:v-on="http://www.w3.org/1999/xhtml">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <button id="btn_rechazar" class="btn btn-app btn-danger pull-right"
                            v-if="solicitud.id_estatus==1">
                        <span v-if="rechazando"><i class="fa fa-spinner fa-spin"></i> Rechazando</span>
                        <span v-else><i class="fa fa-close"></i> Rechazar</span>
                    </button>
                    <button  id="btn_autorizar" :disable="rechazando||autorizando" class="btn btn-sm btn-app btn-info pull-right"
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
                                    <td class="text-right"></td>
                                </tr>
                                    <td><b>Importe Presupuesto Original</b></td>
                                    <td class="text-right"></td></tr>
                                <tr>
                                    <td><b>Importe Presupuesto Actualizado</b></td>
                                    <td class="text-right"></td>
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
                                    <th>Volumen</th>
                                    <th>Costo</th>
                                    <th>Importe</th>
                                </tr>

                                <tr class="bg-gray-active">
                                    <td >@{{ partidas.unidad }}</td>
                                    <td >@{{ parseFloat((partidas.cantidad_presupuestada)).formatMoney(2,'.',',') }}</td>
                                    <td class="text-right">$ @{{ parseFloat((partidas.precio_unitario)).formatMoney(2,'.',',') }}</td>
                                    <td class="text-right">$ @{{ parseFloat((partidas.monto_presupuestado)).formatMoney(2,'.',',') }}</td>
                                </tr>
                                </thead>
                            </table>
                            <br>
                            <div v-for="(tipos, i) in partidas.agrupadores" v-show="tipos.insumos.length >0">
                                <table class="table table-striped table-bordered">

                                    <thead>
                                    <tr class="bg-gray-light">
                                        <th colspan="5" rowspan="3" width="80%"><h4>@{{ tipos.descripcion }}</h4></th>
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
                                        <th>Volumen</th>
                                        <th>Costo</th>
                                        <th>Importe</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <tr v-for="(insumo, i) in tipos.insumos">
                                        <td>@{{ i+1 }}</td>
                                        <td>@{{ insumo.descripcion }}</td>
                                        <td>@{{ insumo.unidad }}</td>
                                        <td>
                                            @{{ parseFloat(insumo.cantidad_presupuestada_nueva).formatMoney(2,'.',',') }}</td>
                                        <td class="text-right">
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
        </section>
    </concepto-extraordinario-show>
@endsection