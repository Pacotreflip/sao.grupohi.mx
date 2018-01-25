@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')

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
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle de la solicitud</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
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
                        <div class="box-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">
                                <i class="fa fa-check"></i> Autorizar</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat pull-right">
                                <i class="fa fa-close"></i> Rechazar</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Partidas</h3>
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
                                        <td>@{{ partida.numero_tarjeta }}</td>
                                        <td>@{{ partida.concepto.unidad }}</td>
                                        <td class="text-right">@{{ parseInt(partida.cantidad_presupuestada_original).formatMoney(2, ',','.') }}</td>
                                        <td class="text-right">@{{ parseInt(partida.cantidad_presupuestada_nueva).formatMoney(2, ',','.') }}</td>
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