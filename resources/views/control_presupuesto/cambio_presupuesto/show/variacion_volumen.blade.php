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
            v-cloak>
        <section>
            <div class="row">
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
                        <div class="box-header with-border" style="height:75px">
                            <div class="col-sm-3">
                                <h3 class="box-title">Partidas</h3>
                            </div>
                            <div class="col-sm-9">
                                <a class="btn btn-app btn-danger pull-right" v-on:click="confirm_rechazar_solicitud" v-if="solicitud.id_estatus==1">
                                    <span v-if="rechazando"><i class="fa fa-spinner fa-spin"></i> Rechazando</span>
                                    <span v-else><i class="fa fa-close"></i> Rechazar</span>
                                </a>
                                <a class="btn btn-sm btn-app btn-info pull-right"  v-on:click="confirm_autorizar_solicitud" v-if="solicitud.id_estatus==1">
                                    <span v-if="autorizando"><i class="fa fa-spinner fa-spin"></i> Autorizando</span>
                                    <span v-else><i class="fa fa-check"></i> Autorizar</span>
                                </a>
                            </div>

                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Número de Tarjeta</th>
                                        <th>Unidad</th>
                                        <th>Cantidad Presupuestada Original</th>
                                        <th width="200px">Cantidad Presupuestada Nueva</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="partida in solicitud.partidas">
                                        <td>@{{ partida.concepto.descripcion }}</td>
                                        <td>@{{ partida.numero_tarjeta.descripcion }}</td>
                                        <td>@{{ partida.concepto.unidad }}</td>
                                        <td class="text-right">@{{ parseInt(partida.cantidad_presupuestada_original).formatMoney(2, ',','.') }}</td>
                                        <td class="text-right">@{{ parseInt(partida.cantidad_presupuestada_nueva).formatMoney(2, ',','.') }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <div class="box box-solid">
                        <div class="box-header with-border" style="height:75px">
                                <h3 class="box-title">Detalles de la Solicitud</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                @foreach($afectaciones as $afectacion)


                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr><th colspan="8">{{$afectacion['partida']->concepto->descripcion}}</th></tr>
                                        <tr>
                                            <th>#</th>
                                            <th>No.Tarjeta</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Cantidad Original</th>
                                            <th>Cantidad Nueva</th>
                                            <th>Monto Original</th>
                                            <th>Monto Nuevo</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($afectacion['detalle'] as $index=>$row)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$row['numTarjeta']}}</td>
                                                <td>{{$row['descripcion']}}</td>
                                                <td>{{$row['unidad']}}</td>
                                                <td>{{$row['cantidadPresupuestada']}}</td>
                                                <td>{{$row['cantidadNueva']}}</td>
                                                <td class="text-right">{{$row['monto_presupuestado']}}</td>
                                                <td class="text-right">{{$row['monto_nuevo']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endforeach

                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </section>
    </show-variacion-volumen>

@endsection