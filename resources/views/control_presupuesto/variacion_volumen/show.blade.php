@extends('control_presupuesto.layout')
@section('title', 'Cambios al Presupuesto')
@section('contentheader_title', 'VARIACIÓN DE VOLÚMEN <small>(ADITIVAS Y DEDUCTIVAS)</small>')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.variacion_volumen.show',$variacion_volumen) !!}
@endsection
@section('main-content')

    <variacion-volumen-show
            inline-template
            :solicitud="{{$variacion_volumen}}"
            :cobrabilidad="{{$cobrabilidad->toJson()}}"
            :presupuestos="{{$presupuestos->toJson()}}"
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <button :disabled="cargando" class="btn pull-right btn-app btn-danger rechazar_solicitud" v-on:click="confirm_rechazar_solicitud" v-if="solicitud.estatus.clave_estado == 1">
                        <span v-if="rechazando"><i class="fa fa-spinner fa-spin"></i> Rechazando</span>
                        <span v-else><i class="fa fa-close"></i> Rechazar</span>
                    </button>
                    <button v-if="solicitud.estatus.clave_estado == 1 || !solicitud.aplicada" :disabled="cargando" class="btn pull-right btn-sm btn-app btn-info autorizar_solicitud" data-toggle="modal" data-target="#select_presupuestos_modal"  @click="fillAfectaciones(); validation_errors.clear('form_autorizar_solicitud')">
                        <span v-if="autorizando"><i class="fa fa-spinner fa-spin"></i> @{{ (!solicitud
                                        .aplicada && solicitud.estatus.clave_estado == 2 ? 'Aplicando' : 'Autorizando')
                            }}</span>
                        <span v-else><i class="fa fa-check"></i> @{{ (!solicitud
                                        .aplicada && solicitud.estatus.clave_estado == 2 ? 'Aplicar' : 'Autorizar')
                            }}</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle de la solicitud</h3>
                            <div class="pull-right">
                                <span class="label" ></span><button class="btn btn-xs btn-info mostrar_pdf" :data-pdf_id="solicitud.id" title="Formato"><i class="fa fa-file-pdf-o"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong>Tipo de Solicitud de Cambio:</strong>
                            <p class="text-muted">@{{solicitud.tipo_orden.descripcion}}</p>
                            <strong>Cobrabilidad:</strong>
                            <p class="text-muted">@{{ cobrabilidad.descripcion}}</p>
                            <strong>Número de Folio:</strong>
                            <p class="text-muted">#@{{ solicitud.numero_folio}}</p>
                            <strong>Area Solicitante:</strong>
                            <p class="text-muted">@{{ solicitud.area_solicitante}}</p>
                            <strong>Motivo:</strong>
                            <p class="text-muted">@{{solicitud.motivo}}</p>
                            <strong>Usuario que Solicita:</strong>
                            <p class="text-muted">@{{solicitud.user_registro.apaterno +' '+ solicitud.user_registro.amaterno+' '+solicitud.user_registro.nombre}}</p>
                            <strong>Fecha de solicitud:</strong>
                            <p class="text-muted">@{{solicitud.fecha_solicitud}}</p>
                            <strong>Estatus:</strong>
                            <p class="text-muted">@{{  solicitud.estatus.descripcion.toUpperCase() + ' (' + (solicitud.aplicada ? 'APLICADA' : 'NO APLICADA') + ')' }}</p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Partidas</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover small">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Tarjeta
                                        </th>
                                        <th>Sector</th>
                                        <th>Cuadrante</th>
                                        <th>Descripción</th>
                                        <th>Unidad</th>
                                        <th>P.U</th>
                                        <th>Volúmen Original</th>
                                        <th>Volúmen del Cambio</th>
                                        <th>Volúmen Actualizado</th>
                                        <th>Importe Original</th>
                                        <th>Importe del Cambio</th>
                                        <th>Importe Actualizado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($variacion_volumen->partidas as $index => $partida)
                                        <tr title="{{  $partida->concepto }}" style="cursor: pointer" v-on:click="mostrar_detalle_partida({{$partida->id}})">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $partida->numeroTarjeta ? $partida->numeroTarjeta->descripcion : '' }}</td>
                                            <td>{{ $partida->concepto->sector }}</td>
                                            <td>{{ $partida->concepto->cuadrante }}</td>
                                            <td>{{ substr($partida->concepto->descripcion, 0, 50) }} ...</td>
                                            <td>{{ $partida->concepto->unidad }}</td>
                                            <td class="text-right">$&nbsp;{{ number_format($partida->concepto->precio_unitario, 2, '.', ',') }}</td>

                                            <td class="text-right">{{ number_format($partida->historico ? $partida->historico->cantidad_presupuestada_original : $partida->concepto->cantidad_presupuestada, 2, '.', ',') }}</td>
                                            <td class="text-right">{{ number_format($partida->historico ? $partida->historico->cantidad_presupuestada_actualizada - $partida->historico->cantidad_presupuestada_original : $partida->variacion_volumen, 2, '.', ',') }}</td>
                                            <td class="text-right">{{ number_format($partida->historico ? $partida->historico->cantidad_presupuestada_actualizada : $partida->concepto->cantidad_presupuestada * $partida->factor, 2, '.', ',') }}</td>

                                            <td class="text-right">$&nbsp;{{ number_format($partida->historico ? $partida->historico->monto_presupuestado_original : $partida->concepto->monto_presupuestado, 2, '.', ',') }}</td>
                                            <td class="text-right">$&nbsp;{{ number_format($partida->historico ? $partida->historico->monto_presupuestado_actualizado - $partida->historico->monto_presupuestado_original : ($partida->concepto->monto_presupuestado * $partida->factor) - $partida->concepto->monto_presupuestado, 2, '.', ',') }}</td>
                                            <td class="text-right">$&nbsp;{{ number_format($partida->historico ? $partida->historico->monto_presupuestado_actualizado : $partida->concepto->monto_presupuestado * $partida->factor, 2, '.', ',') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12" class="text-center">
                        <span v-if="consultando"><i class="fa fa-spinner fa-spin"></i> </span>
                        <span v-else></span>
                    </div>
                    <div class="box box-solid" id="divDetalle" style="display: none;">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalles de la Partida</h3>
                        </div>
                        <div class="box-body">
                            <ul class="nav nav-tabs">
                                @foreach($presupuestos as $index=>$presupuesto)
                                    <li v-on:click="mostrar_detalle_presupuesto({{$presupuesto->baseDatos->id}})"
                                        class="{{$index==0?'active':''}}"><a data-toggle="tab" href="#menu{{$presupuesto->baseDatos->id}}">{{$presupuesto->baseDatos->descripcion}}</a>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="table-responsive">
                                <table class="table small table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">No.Tarjeta</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Unidad</th>
                                        <th class="text-center">P.U</th>
                                        <th class="text-center">Volumen Original</th>
                                        <th class="text-center">Volúmen del Cambio</th>
                                        <th class="text-center">Volumen Actualizado</th>
                                        <th class="text-center">Importe Original</th>
                                        <th class="text-center">Importe del Cambio</th>
                                        <th class="text-center">Importe Actualizado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(partida,i) in partidas">
                                        <td>@{{i+1}}</td>
                                        <td>@{{partida.numTarjeta}}</td>
                                        <td>@{{partida.descripcion}}</td>
                                        <td>@{{partida.unidad}}</td>
                                        <td class="text-right">$&nbsp;@{{(parseFloat(partida.pu)).formatMoney(2,'.',',')}}</td>
                                        <td>@{{(parseFloat(partida.cantidadPresupuestada)).formatMoney(2,'.',',')}}</td>
                                        <td>@{{(parseFloat(partida.variacion_volumen)).formatMoney(2,'.',',')}}</td>
                                        <td>@{{(parseFloat(partida.cantidadNueva)).formatMoney(2,'.',',')}}</td>
                                        <td class="text-right">$&nbsp;@{{(parseFloat(partida.monto_presupuestado)).formatMoney(2,'.',',')}}</td>
                                        <td class="text-right">$&nbsp;@{{(parseFloat(partida.variacion_importe)).formatMoney(2,'.',',')}}</td>
                                        <td class="text-right">$&nbsp;@{{(parseFloat(partida.monto_nuevo)).formatMoney(2,'.',',')}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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

            <!-- Modal -->
            <div class="modal fade" id="select_presupuestos_modal" tabindex="-1" role="dialog" aria-labelledby="selectPresupuestosModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Seleccione los presupuestos que desea afectar con ésta solicitud<br><small>(Por defecto se marcan los presupuestos seleccionados al crear la solicitud)</small></h4>
                        </div>
                        <form id="form_autorizar_solicitud" @submit.prevent="validateForm('form_autorizar_solicitud', (!solicitud
                                        .aplicada && solicitud.estatus.clave_estado == 2 ? 'aplicar_solicitud' : 'autorizar_solicitud'))"  data-vv-scope="form_autorizar_solicitud">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-4" :class="{'has-error': validation_errors.has('form_autorizar_solicitud.Presupuesto')}" v-for="presupuesto in presupuestos" v-if="!aplicada(presupuesto.id_base_presupuesto)">
                                    <span v-if="aplicada(presupuesto.id_base_presupuesto)">
                                        <label class="text-warning">@{{ presupuesto.base_datos.descripcion }} (Aplicada)</label>
                                    </span>
                                        <span v-else>
                                        <label><b>@{{ presupuesto.base_datos.descripcion }}</b></label>
                                    </span>
                                        <input type="checkbox" :value="presupuesto.base_datos.id" v-model="form.afectaciones" :name="'Presupuesto'" v-validate="'required'">
                                    </div>
                                </div>
                                <label class="help text-red" v-show="validation_errors.has('form_autorizar_solicitud.Presupuesto')">Seleccione por lo menos un presupuesto por afectar.</label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" :disabled="cargando" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" :disabled="cargando" class="btn btn-primary">
                                    <span v-if="autorizando"><i class="fa fa-spinner fa-spin"></i> @{{ (!solicitud
                                        .aplicada && solicitud.estatus.clave_estado == 2 ? 'Aplicando' : 'Autorizando')
                            }}</span>
                                    <span v-else><i class="fa fa-check"></i> @{{ (!solicitud
                                        .aplicada && solicitud.estatus.clave_estado == 2 ? 'Aplicar' : 'Autorizar')
                            }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </variacion-volumen-show>
@endsection