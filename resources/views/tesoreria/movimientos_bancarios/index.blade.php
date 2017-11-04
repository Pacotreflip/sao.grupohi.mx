@extends('tesoreria.layout')
@section('title', 'Movimientos Bancarios')
@section('contentheader_title', 'MOVIMIENTOS BANCARIOS')
@section('main-content')
    {!! Breadcrumbs::render('tesoreria.movimientos_bancarios.index') !!}

    <global-errors></global-errors>
    <movimientos_bancarios-index
            :url_movimientos_bancarios_index="'{{ route('tesoreria.movimientos_bancarios.index') }}'"
            :cuentas="{{$dataView['cuentas']->toJson()}}"
            :tipos="{{$dataView['tipos']->toJson()}}"
            inline-template
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary pull-right" v-on:click="modal_movimiento()">Realizar Movimiento</button>
                </div>
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div id="movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="MovimientoModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form  id="form_guardar_movimiento" @submit.prevent="validateForm('form_guardar_movimiento', 'confirm_guardar')"  data-vv-scope="form_guardar_movimiento">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Realizar Traspaso</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{--Tipo movimiento--}}
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.id_tipo_movimiento')}">
                                            <label><b>Tipo de movimiento</b></label>
                                            <Select class="form-control" name="id_tipo_movimiento" id="id_tipo_movimiento" v-model="form.id_tipo_movimiento"  v-validate="'required'">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="(item, index) in tipos" :value="item.id_tipo_movimiento">@{{item.descripcion}}</option>
                                            </Select>
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.id_tipo_movimiento')">@{{ validation_errors.first('form_guadar_movimiento.id_tipo_movimiento') }}</label>
                                        </div>
                                    </div>
                                    {{--Cuenta--}}
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Cuenta')}">
                                            <label><b>Cuenta</b></label>
                                            <Select class="form-control" name="Cuenta" id="id_cuenta" v-model="form.id_cuenta" v-validate="'required'">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="item in cuentas" :value="item.id_cuenta">@{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}}) </option>
                                            </Select>
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Cuenta')">@{{ validation_errors.first('form_guadar_movimiento.Cuenta') }}</label>
                                        </div>
                                    </div>
                                    {{--Impuesto--}}
                                    <div class="col-md-4" v-if="form.id_tipo_movimiento === 4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Impuesto')}">
                                            <label><b>Impuesto</b></label>
                                            <input type="text" class="form-control pull-right" id="impuesto" value="" name="Impuesto" v-model="form.impuesto" v-validate="'required'">
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Impuesto')">@{{ validation_errors.first('form_guadar_movimiento.Impuesto') }}</label>
                                        </div>
                                    </div>
                                    {{--Importe--}}
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Importe')}">
                                            <label><b>Importe</b></label>
                                            <input type="text" class="form-control pull-right" id="importe" value="" name="Importe" v-model="form.importe" v-validate="'required|decimal:6'">
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Importe')">@{{ validation_errors.first('form_guadar_movimiento.Importe') }}</label>
                                        </div>
                                    </div>
                                    {{--Fecha--}}
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_guardar_movimiento.Fecha')}">
                                            <label for="Fecha" class="control-label"><b>Fecha</b></label>
                                            <input type="text" name="Fecha" class="form-control input-sm " id="fecha"
                                                   v-model="form.fecha"
                                                   v-datepicker>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_guardar_movimiento.Fecha')">@{{ validation_errors.first('form_guardar_movimiento.Fecha') }}</label>
                                        </div>
                                    </div>
                                    {{--Observaciones--}}
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Observaciones')}">
                                            <label for="comment"><b>Observaciones</b></label>
                                            <textarea class="form-control" rows="8" id="observaciones" name="Observaciones" v-model="form.observaciones" v-validate="'required'"></textarea>
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Observaciones')">@{{ validation_errors.first('form_guadar_movimiento.Observaciones') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </section>
    </movimientos_bancarios-index>

@endsection