@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.show',$solicitud) !!}
@endsection


@section('main-content')
    <show-variacion-volumen
            inline-template
            :solicitud="{{$solicitud}}"
            :cobrabilidad="{{$cobrabilidad}}"
            :presupuestos="{{$presupuestos}}"
            v-cloak>
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
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle de la solicitud</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong>Folio de la solicitud:</strong>
                            <p class="text-muted">@{{ solicitud.numero_folio}}</p>
                            <hr>
                            <strong>Cobrabilidad:</strong>
                            <p class="text-muted">@{{ cobrabilidad.descripcion}}</p>
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
                            <h3 class="box-title">Partidas</h3>
                        </div>
                        <div class="box-body">


                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Tarjeta
                                        </th>
                                        <th>Sector</th>
                                        <th>Cuadrante</th>
                                        <th>Unidad</th>
                                        <th>P.U</th>
                                        <th>Volumen</th>
                                        <th width="200px">Variacion de volumen</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(partida,i) in solicitud.partidas" :title="partida.concepto.descripcion"
                                        style="cursor: pointer" v-on:click="mostrar_detalle_partida(partida.id)">
                                        <td>@{{ i+1 }}</td>
                                        <td>@{{ partida.numero_tarjeta.descripcion }}</td>
                                        <td>@{{ partida.concepto.sector }}</td>
                                        <td>@{{ partida.concepto.cuadrante }}</td>
                                        <td>@{{ partida.concepto.unidad }}</td>
                                        <td class="text-right">
                                            $@{{(parseInt( partida.concepto.precio_unitario )).formatMoney(2,'.',',')}}</td>
                                        <td class="text-right">@{{ parseInt(partida.cantidad_presupuestada_original).formatMoney(2, ',','.') }}</td>
                                        <td class="text-right">@{{ parseInt(partida.variacion_volumen).formatMoney(2, ',','.') }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12" class="text-center">
                        <span v-if="consultando"><i class="fa fa-spinner fa-spin"></i> </span>
                        <span v-else></span>
                    </div>
                    <div class="box box-solid" id="divDetalle">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalles de la Partida</h3>
                        </div>
                        <div class="box-body">
                            <ul class="nav nav-tabs">
                                @foreach($presupuestos as $index=>$presupuesto)
                                    <li v-on:click="mostrar_detalle_presupuesto({{$presupuesto->baseDatos->id}})"
                                        class="{{$index==0?'active':''}}"><a data-toggle="tab"
                                                                             href="#menu{{$presupuesto->baseDatos->id}}">{{$presupuesto->baseDatos->descripcion}}</a>
                                    </li>
                                @endforeach

                            </ul>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">No.Tarjeta</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Unidad</th>
                                        <th class="text-center">P.U</th>
                                        <th class="text-center">Volumen Original</th>
                                        <th class="text-center">Variación de volumen</th>
                                        <th class="text-center">Volumen Nuevo</th>
                                        <th class="text-center">Importe Original</th>
                                        <th class="text-center">Variación de importe</th>
                                        <th class="text-center">Importe Nuevo</th>
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
        </section>
    </show-variacion-volumen>
@endsection