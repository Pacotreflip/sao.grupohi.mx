@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.show',$solicitud) !!}
@endsection

@section('main-content')
    <show-escalatoria
            inline-template
            :solicitud="{{$solicitud}}"
            :cobrabilidad="{{$cobrabilidad->toJson()}}"
            :presupuestos="{{$presupuestos->toJson()}}"
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-app btn-danger pull-right rechazar_solicitud" v-on:click="confirm_rechazar_solicitud"
                       v-if="solicitud.id_estatus==1">
                        <span v-if="rechazando"><i class="fa fa-spinner fa-spin"></i> Rechazando</span>
                        <span v-else><i class="fa fa-close"></i> Rechazar</span>
                    </a>
                    <a class="btn btn-sm btn-app btn-info pull-right autorizar_solicitud" v-on:click="confirm_autorizar_solicitud"
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
                            <strong>Tipo de Orden de Cambio:</strong>
                            <p class="text-muted">@{{solicitud.tipo_orden.descripcion}}</p>
                            <hr>
                            <strong>Cobrabilidad:</strong>
                            <p class="text-muted">@{{ cobrabilidad.descripcion}}</p>
                            <hr>
                            <strong>Folio de la solicitud:</strong>
                            <p class="text-muted">@{{ solicitud.numero_folio}}</p>
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
                                        <th>Descripción</th>
                                        <th>Importe</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(partida,i) in solicitud.partidas" :title="partida.descripcion">
                                        <td>@{{ i+1 }}</td>
                                        <td>@{{ partida.descripcion }}</td>
                                        <td class="text-right">$@{{ parseFloat(partida.monto_presupuestado).formatMoney(2, ',','.') }}</td>
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
                    <div class="box box-solid" id="divDetalle" style="display: none;">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalles de la Partida</h3>
                        </div>
                        <div class="box-body">
                            <ul class="nav nav-tabs">
                                @foreach($presupuestos as $index=>$presupuesto)
                                    <li v-on:click="mostrar_detalle_presupuesto({{$presupuesto->baseDatos->id}})"
                                        class="{{$index==0?'active':''}}">
                                        <a data-toggle="tab" href="#menu{{$presupuesto->baseDatos->id}}">{{$presupuesto->baseDatos->descripcion}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Importe</th>
                                        <th>--</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(partida, i) in form.partidas">
                                        <td>@{{ i + 1 }}</td>
                                        <td>
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Descripción ' + (i+1))}">
                                                <input v-validate="'required'" :name="'Descripción ' + (i+1)" type="text" class="form-control input-sm" v-model="partida.descripcion">
                                                <label class="help" v-show="validation_errors.has('form_save_solicitud.Descripción ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Descripción ' + (i+1)) }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Importe ' + (i+1))}">
                                                <input v-validate="'required'" :name="'Importe ' + (i+1)" type="number" step="any" class="form-control input-sm" v-model="partida.importe">
                                                <label class="help" v-show="validation_errors.has('form_save_solicitud.Importe ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Importe ' + (i+1)) }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn-default btn btn-xs" @click="removePartida(i)"><i class="fa fa-minus text-red"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                                <label><b>Motivo</b></label>
                                                <textarea class="form-control" v-validate="'required'" :name="'Motivo'" v-model="form.motivo"></textarea>
                                                <label class="help" v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </show-escalatoria>
@endsection