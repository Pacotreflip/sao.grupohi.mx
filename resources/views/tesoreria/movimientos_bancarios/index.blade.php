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
            :movimientos="{{$dataView['movimientos']->toJson()}}"
            inline-template
            v-cloak>
        <section>
            @permission(['registrar_movimiento_bancario'])
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
                        <form  id="form_guardar_movimiento" name="form_guardar_movimiento" @submit.prevent="validateForm('form_guardar_movimiento', 'confirm_guardar')"  data-vv-scope="form_guardar_movimiento">
                            <div class="modal-header">
                                <button type="button" class="close" v-on:click="close_modal_movimiento()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Realizar Movimiento</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{--Tipo movimiento--}}
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.tipo_movimiento')}">
                                            <label><b>Tipo de movimiento</b></label>
                                            <Select class="form-control" name="tipo_movimiento" id="tipo_movimiento" v-model="form.id_tipo_movimiento"  v-validate="'required'">
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
                                            <Select class="form-control" name="Cuenta" id="Cuenta" v-model="form.id_cuenta" v-validate="'required'">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="item in cuentas" :value="item.id_cuenta">@{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}}) </option>
                                            </Select>
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Cuenta')">@{{ validation_errors.first('form_guadar_movimiento.Cuenta') }}</label>
                                        </div>
                                    </div>
                                    {{--Importe--}}
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Importe')}">
                                            <label><b>Importe</b></label>
                                            <input type="text" class="form-control pull-right" id="Importe" name="Importe" v-model="form.importe" v-validate="'required|decimal:6'">
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Importe')">@{{ validation_errors.first('form_guadar_movimiento.Importe') }}</label>
                                        </div>
                                    </div>
                                    {{--Impuesto--}}
                                    <div class="col-md-6" v-if="form.id_tipo_movimiento === 4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Impuesto')}">
                                            <label><b>Impuesto</b></label>
                                            <input type="text" class="form-control pull-right" id="Impuesto" value="" name="Impuesto" v-model="form.impuesto">
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Impuesto')">@{{ validation_errors.first('form_guadar_movimiento.Impuesto') }}</label>
                                        </div>
                                    </div>
                                    {{--Referencia--}}
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Referencia')}">
                                            <label><b>Referencia</b></label>
                                            <input type="text" class="form-control pull-right" id="Referencia" value="" name="Referencia" v-model="form.referencia" v-validate="'required'">
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Referencia')">@{{ validation_errors.first('form_guadar_movimiento.Referencia') }}</label>
                                        </div>
                                    </div>
                                    {{--Fecha--}}
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_guardar_movimiento.Fecha')}">
                                            <label for="Fecha" class="control-label"><b>Fecha</b></label>
                                            <input type="text" name="Fecha" class="form-control input-sm " id="Fecha"
                                                   v-model="form.fecha"
                                                   v-datepicker>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_guardar_movimiento.Fecha')">@{{ validation_errors.first('form_guardar_movimiento.Fecha') }}</label>
                                        </div>
                                    </div>
                                    {{--Cumplimiento--}}
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_guardar_movimiento.Cumplimiento')}">
                                            <label for="Cumplimiento" class="control-label"><b>Cumplimiento</b></label>
                                            <input type="text" name="Cumplimiento" class="form-control input-sm " id="Cumplimiento"
                                                   v-model="form.cumplimiento"
                                                   v-datepicker>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_guardar_movimiento.Cumplimiento')">@{{ validation_errors.first('form_guardar_movimiento.Cumplimiento') }}</label>
                                        </div>
                                    </div>
                                    {{--Vencimiento--}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Vencimiento" class="control-label"><b>Vencimiento</b></label>
                                            <input type="text" name="Vencimiento" class="form-control input-sm " id="Vencimiento"  :value="form.vencimiento" v-model="form.vencimiento"
                                                   disabled >
                                        </div>
                                    </div>
                                    {{--Observaciones--}}
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guadar_movimiento.Observaciones')}">
                                            <label for="comment"><b>Observaciones</b></label>
                                            <textarea class="form-control" rows="8" id="Observaciones" name="Observaciones" v-model="form.observaciones" v-validate="'required'"></textarea>
                                            <label class="help" v-show="validation_errors.has('form_guadar_movimiento.Observaciones')">@{{ validation_errors.first('form_guadar_movimiento.Observaciones') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" v-on:click="close_modal_movimiento()">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            @endpermission

            @permission(['consultar_movimiento_bancario'])
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Movimientos</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped index_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Cuenta</th>
                                        <th>Importe | Total</th>
                                        <th>Referencia</th>
                                        @permission(['eliminar_movimiento_bancario', 'editar_movimiento_bancario'])
                                        <th>Acciones</th>
                                        @endpermission
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data.movimientos">
                                            <td >@{{ index + 1  }}</td>
                                            <td>@{{ item.numero_folio }}</td>
                                            <td>@{{trim_fecha(item.movimiento_transaccion.transaccion.fecha)}}</td>
                                            <td>@{{item.tipo.descripcion }}</td>
                                            <td>@{{item.cuenta.numero }} @{{item.cuenta.abreviatura }} (@{{item.cuenta.empresa.razon_social}})</td>
                                            <td>@{{item.importe}} | @{{total(item.importe, item.impuesto)}}</td>
                                            <td>@{{item.movimiento_transaccion.transaccion.referencia}}</td>
                                            @permission(['eliminar_movimiento_bancario', 'editar_movimiento_bancario'])
                                            <td>
                                                @permission(['eliminar_movimiento_bancario'])
                                                <div class="btn-group">
                                                    <button type="button" title="Eliminar" class="btn btn-xs btn-danger" v-on:click="confirm_eliminar(item.id_movimiento_bancario)"><i class="fa fa-trash"></i></button>
                                                </div>
                                                @endpermission
                                                @permission(['editar_movimiento_bancario'])
                                                <div class="btn-group">
                                                    <button title="Editar" class="btn btn-xs btn-info" type="button" v-on:click="modal_editar(item)"> <i class="fa fa-edit"></i></button>
                                                </div>
                                                @endpermission
                                            </td>
                                            @endpermission
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endpermission
            @permission(['registrar_movimiento_bancario'])
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary pull-right" v-on:click="modal_movimiento()">Realizar Movimiento</button>
                </div>
                <div class="col-md-12">

                </div>
            </div>
            @endpermission

            <!-- Modal Edit Cuenta -->
            @permission(['editar_movimiento_bancario'])
            <div id="edit_movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editMovimientoModal" data-backdrop="static" data-keyboard="false">
                <form  id="form_editar_movimiento" @submit.prevent="validateForm('form_editar_movimiento','confirm_editar')"  data-vv-scope="form_editar_movimiento">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_edit_movimiento"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">
                                    Editar movimiento
                                </h4>
                            </div>
                            <div class="modal-body row">
                                {{--Tipo movimiento Edit--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar id_tipo_movimiento')}">
                                        <label><b>Tipo de movimiento</b></label>
                                        <Select class="form-control" name="Editar id_tipo_movimiento" id="Editar id_tipo_movimiento" v-model="movimiento_edit.id_tipo_movimiento"  v-validate="'required'">
                                            <option value>[--SELECCIONE--]</option>
                                            <option v-for="(item, index) in tipos"
                                                :value="item.id_tipo_movimiento"
                                                :selected="movimiento_edit.id_tipo_movimiento == item.id_tipo_movimiento ? 'selected' : ''">@{{item.descripcion}}</option>
                                        </Select>
                                        <label class="help" v-show="validation_errors.has('form_editar_movimiento.Editar id_tipo_movimiento')">@{{ validation_errors.first('form_editar_movimiento.Editar id_tipo_movimiento') }}</label>
                                    </div>
                                </div>
                                {{--Cuenta--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Cuenta')}">
                                        <label><b>Cuenta</b></label>
                                        <Select class="form-control" name="Editar Cuenta" id="Editar Cuenta" v-model="movimiento_edit.id_cuenta" v-validate="'required'">
                                            <option value>[--SELECCIONE--]</option>
                                            <option v-for="item in cuentas"
                                                :value="item.id_cuenta"
                                                :selected="movimiento_edit.id_cuenta == item.id_cuenta ? 'selected' : ''">@{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}}) </option>
                                        </Select>
                                        <label class="help" v-show="validation_errors.has('form_editar_movimiento.Editar Cuenta')">@{{ validation_errors.first('form_editar_movimiento.Editar Cuenta') }}</label>
                                    </div>
                                </div>
                                {{--Importe--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Importe')}">
                                        <label><b>Importe</b></label>
                                        <input type="text" class="form-control pull-right" id="Editar Importe" value="" name="Editar Importe" v-model="movimiento_edit.importe" v-validate="'required|decimal:6'">
                                        <label class="help" v-show="validation_errors.has('form_editar_movimiento.Editar Importe')">@{{ validation_errors.first('form_editar_movimiento.Editar Importe') }}</label>
                                    </div>
                                </div>
                                {{--Impuesto--}}
                                <div class="col-md-6" v-if="movimiento_edit.id_tipo_movimiento == 4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Impuesto')}">
                                        <label><b>Impuesto</b></label>
                                        <input type="text" class="form-control pull-right" id="Editar Impuesto" value="" name="Editar Impuesto" v-model="movimiento_edit.impuesto">
                                        <label class="help" v-show="validation_errors.has('form_editar_movimiento.Editar Impuesto')">@{{ validation_errors.first('form_editar_movimiento.Editar Impuesto') }}</label>
                                    </div>
                                </div>
                                {{--Referencia--}}
                                <div class="col-md-12">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Referencia')}">
                                        <label><b>Referencia</b></label>
                                        <input type="text" class="form-control pull-right" id="referencia" value="" name="Editar Referencia" v-model="movimiento_edit.referencia" v-validate="'required'">
                                        <label class="help" v-show="validation_errors.has('form_editar_movimiento.Editar Referencia')">@{{ validation_errors.first('form_editar_movimiento.Editar Referencia') }}</label>
                                    </div>
                                </div>
                                {{--Fecha--}}
                                <div class="col-md-4">
                                    <div class="form-group"
                                         :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Fecha')}">
                                        <label for="Fecha" class="control-label"><b>Fecha</b></label>
                                        <input type="text" name="Editar Fecha" class="form-control input-sm " id="Editar Fecha"
                                               v-model="movimiento_edit.fecha"
                                               v-datepicker>
                                        <label class="help"
                                               v-show="validation_errors.has('form_editar_movimiento.Editar Fecha')">@{{ validation_errors.first('form_editar_movimiento.Editar Fecha') }}</label>
                                    </div>
                                </div>
                                {{--Cumplimiento--}}
                                <div class="col-md-4">
                                    <div class="form-group"
                                         :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Cumplimiento')}">
                                        <label for="Cumplimiento" class="control-label"><b>Cumplimiento</b></label>
                                        <input type="text" name="Editar Cumplimiento" class="form-control input-sm " id="edit_cumplimiento"
                                               v-model="movimiento_edit.cumplimiento"
                                               v-datepicker>
                                        <label class="help"
                                               v-show="validation_errors.has('form_editar_movimiento.Editar Cumplimiento')">@{{ validation_errors.first('form_editar_movimiento.Editar Cumplimiento') }}</label>
                                    </div>
                                </div>
                                {{--Vencimiento--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Vencimiento" class="control-label"><b>Vencimiento</b></label>
                                        <input type="text" name="Editar Vencimiento" class="form-control input-sm " id="Editar Vencimiento"  :value="movimiento_edit.vencimiento" v-model="movimiento_edit.vencimiento"
                                               disabled >
                                    </div>
                                </div>
                                {{--Observaciones--}}
                                <div class="col-md-12">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_movimiento.Editar Observaciones')}">
                                        <label for="comment"><b>Observaciones</b></label>
                                        <textarea class="form-control" rows="8" id="Editar Observaciones" name="Editar Observaciones" v-model="movimiento_edit.observaciones" v-validate="'required'"></textarea>
                                        <label class="help" v-show="validation_errors.has('form_editar_movimiento.Editar Observaciones')">@{{ validation_errors.first('form_editar_movimiento.Editar Observaciones') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" @click="close_edit_movimiento">Cerrar</button>
                                <button type="submit" class="btn btn-primary" >Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endpermission
        </section>
    </movimientos_bancarios-index>

@endsection
