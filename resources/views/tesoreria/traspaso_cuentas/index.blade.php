@extends('tesoreria.layout')
@section('title', 'Traspaso entre cuentas')
@section('contentheader_title', 'TRASPASO ENTRE CUENTAS')
@section('main-content')
    {!! Breadcrumbs::render('tesoreria.traspaso_cuentas.index') !!}

    <global-errors></global-errors>
    <traspaso-cuentas-index
            :url_traspaso_cuentas_index="'{{ route('tesoreria.traspaso_cuentas.index') }}'"
            :cuentas="{{$dataView['cuentas']->toJson()}}"
            :traspasos="{{$dataView['traspasos']->toJson()}}"
            inline-template
            v-cloak>
        <section>
            @permission(['registrar_traspaso_cuenta'])
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary pull-right" v-on:click="modal_traspaso()">Crear Traspaso</button>
                </div>
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div id="traspaso_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TraspasoModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form  id="form_guardar_traspaso" @submit.prevent="validateForm('form_guardar_traspaso', 'confirm_guardar')"  data-vv-scope="form_guardar_traspaso">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Realizar Traspaso</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{--Cuenta origen--}}
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guardar_traspaso.Cuenta Origen')}">
                                            <label><b>Cuenta origen</b></label>
                                            <Select class="form-control" name="Cuenta Origen" id="id_cuenta_origen" v-model="form.id_cuenta_origen"  v-validate="'required'">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="(item, index) in cuentas" :value="item.id_cuenta">@{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}})</option>
                                            </Select>
                                            <label class="help" v-show="validation_errors.has('form_guardar_traspaso.Cuenta Origen')">@{{ validation_errors.first('form_guardar_traspaso.Cuenta Origen') }}</label>
                                        </div>
                                    </div>
                                    {{--Cuenta destino--}}
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guardar_traspaso.Cuenta Destino')}">
                                            <label><b>Cuenta destino</b></label>
                                            <Select class="form-control" name="Cuenta Destino" id="id_cuenta_destino" v-model="form.id_cuenta_destino" v-validate="'required'">
                                                <option value>[--SELECCIONE--]</option>
                                                <option v-for="item in cuentas_disponibles" :value="item.id_cuenta">@{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}}) </option>
                                            </Select>
                                            <label class="help" v-show="validation_errors.has('form_guardar_traspaso.Cuenta Destino')">@{{ validation_errors.first('form_guardar_traspaso.Cuenta Destino') }}</label>
                                        </div>
                                    </div>
                                    {{--Fecha--}}
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_guardar_traspaso.Fecha')}">
                                            <label for="Fecha" class="control-label"><b>Fecha</b></label>
                                            <input type="text" name="Fecha" class="form-control input-sm " id="fecha"
                                                   v-model="form.fecha"
                                                   v-datepicker>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_guardar_traspaso.Fecha')">@{{ validation_errors.first('form_guardar_traspaso.Fecha') }}</label>
                                        </div>
                                    </div>
                                    {{--Cumplimiento--}}
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_guardar_traspaso.Cumplimiento')}">
                                            <label for="Cumplimiento" class="control-label"><b>Cumplimiento</b></label>
                                            <input type="text" name="Cumplimiento" class="form-control input-sm " id="cumplimiento"
                                                   v-model="form.cumplimiento"
                                                   v-datepicker>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_guardar_traspaso.Cumplimiento')">@{{ validation_errors.first('form_guardar_traspaso.Cumplimiento') }}</label>
                                        </div>
                                    </div>
                                    {{--Vencimiento--}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Vencimiento" class="control-label"><b>Vencimiento</b></label>
                                            <input type="text" name="Vencimiento" class="form-control input-sm " id="vencimiento"  :value="form.vencimiento" v-model="form.vencimiento"
                                                   disabled >
                                        </div>
                                    </div>
                                    {{--Importe--}}
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guardar_traspaso.Importe')}">
                                            <label><b>Importe</b></label>
                                            <input type="text" class="form-control pull-right" id="importe" value="" name="Importe" v-model="form.importe" v-validate="'required|decimal:6'">
                                            <label class="help" v-show="validation_errors.has('form_guardar_traspaso.Importe')">@{{ validation_errors.first('form_guardar_traspaso.Importe') }}</label>
                                        </div>
                                    </div>
                                    {{--Referencia--}}
                                    <div class="col-md-8">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guardar_traspaso.Referencia')}">
                                            <label><b>Referencia</b></label>
                                            <input type="text" class="form-control pull-right" id="referencia" value="" name="Referencia" v-model="form.referencia" v-validate="'required'">
                                            <label class="help" v-show="validation_errors.has('form_guardar_traspaso.Referencia')">@{{ validation_errors.first('form_guardar_traspaso.Referencia') }}</label>
                                        </div>
                                    </div>
                                    {{--Observaciones--}}
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_guardar_traspaso.Observaciones')}">
                                            <label for="comment"><b>Observaciones</b></label>
                                            <textarea class="form-control" rows="8" id="observaciones" name="Observaciones" v-model="form.observaciones" v-validate="'required'"></textarea>
                                            <label class="help" v-show="validation_errors.has('form_guardar_traspaso.Observaciones')">@{{ validation_errors.first('form_guardar_traspaso.Observaciones') }}</label>
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
            @endpermission

            @permission(['consultar_traspaso_cuenta'])
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Traspasos</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped index_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Cuenta Origen</th>
                                        <th>Cuenta Destino</th>
                                        <th>Importe</th>
                                        <th>Referencia</th>
                                        @permission(['eliminar_traspaso_cuenta', 'editar_traspaso_cuenta'])
                                        <th>Acciones</th>
                                        @endpermission
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data.traspasos">
                                            <td >@{{ index + 1  }}</td>
                                            <td>@{{trim_fecha(item.traspaso_transaccion.transaccion_debito.fecha)}}</td>
                                            <td>@{{item.cuenta_origen.numero }} @{{item.cuenta_origen.abreviatura }} (@{{item.cuenta_origen.empresa.razon_social}})</td>
                                            <td>@{{item.cuenta_destino.numero }} @{{item.cuenta_destino.abreviatura }} (@{{item.cuenta_destino.empresa.razon_social}})</td>
                                            <td>@{{item.importe}}</td>
                                            <td>@{{item.traspaso_transaccion.transaccion_debito.referencia}}</td>
                                            @permission(['eliminar_traspaso_cuenta', 'editar_traspaso_cuenta'])
                                            <td>
                                                @permission(['eliminar_traspaso_cuenta'])
                                                <div class="btn-group">
                                                    <button type="button" title="Eliminar" class="btn btn-xs btn-danger" v-on:click="confirm_eliminar(item.id_traspaso)"><i class="fa fa-trash"></i></button>
                                                </div>
                                                @endpermission
                                                @permission(['editar_traspaso_cuenta'])
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
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary pull-right" v-on:click="modal_traspaso()">Crear Traspaso</button>
                </div>
                <div class="col-md-12">

                </div>
            </div>
            <!-- Modal Edit Cuenta -->
            @permission(['editar_traspaso_cuenta'])
            <div id="edit_traspaso_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editTraspasoModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-label="Close" @click="close_edit_traspaso"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                    Editar traspaso
                            </h4>
                        </div>
                        <form  id="form_editar_traspaso" @submit.prevent="validateForm('form_editar_traspaso','confirm_editar')"  data-vv-scope="form_editar_traspaso">
                            <div class="modal-body row">
                                {{--Cuenta Origen Edit--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_guardar_traspaso.Editar Cuenta Origen')}">
                                        <label><b>Cuenta origen</b></label>
                                        <Select class="form-control" name="Editar Cuenta Origen" id="edit_id_cuenta_origen" v-model="traspaso_edit.id_cuenta_origen"  v-validate="'required'">
                                            <option value>[--SELECCIONE--]</option>
                                            <option v-for="(item, index) in cuentas" :value="item.id_cuenta" :selected="traspaso_edit.id_cuenta_destino == item.id_cuenta ? 'selected' : ''">
                                                @{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}})
                                            </option>
                                        </Select>
                                        <label class="help" v-show="validation_errors.has('form_editar_traspaso.Editar Cuenta Origen')">@{{ validation_errors.first('form_editar_traspaso.Editar Cuenta Origen') }}</label>
                                    </div>
                                </div>
                                {{--Cuenta Destino Edit--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_traspaso.Editar Cuenta Destino')}">
                                        <label><b>Cuenta destino</b></label>
                                        <Select class="form-control" name="Editar Cuenta Destino" id="edit_id_cuenta_destino" v-model="traspaso_edit.id_cuenta_destino" v-validate="'required'">
                                            <option value>[--SELECCIONE--]</option>
                                            <option v-for="item in cuentas_disponibles" :value="item.id_cuenta"
                                                    :selected="traspaso_edit.id_cuenta_destino == item.id_cuenta ? 'selected' : ''">
                                                @{{item.numero }} @{{item.abreviatura }} (@{{item.empresa.razon_social}})
                                            </option>
                                        </Select>
                                        <label class="help" v-show="validation_errors.has('form_editar_traspaso.Cuenta Destino')">@{{ validation_errors.first('form_editar_traspaso.Editar Cuenta Destino') }}</label>
                                    </div>
                                </div>
                                {{--Fecha Edit--}}
                                <div class="col-md-4">
                                    <div class="form-group"
                                         :class="{'has-error': validation_errors.has('form_editar_traspaso.Edit Fecha')}">
                                        <label for="Edit Fecha" class="control-label"><b>Fecha</b></label>
                                        <input type="text" name="Edit Fecha" class="form-control input-sm fechas_edit" id="edit_fecha"
                                               v-model="traspaso_edit.fecha"
                                               v-datepicker>
                                        <label class="help"
                                               v-show="validation_errors.has('form_guardar_traspaso.Fecha')">@{{ validation_errors.first('form_guardar_traspaso.Fecha') }}</label>
                                    </div>
                                </div>
                                {{--Cumplimiento Edit--}}
                                <div class="col-md-4">
                                    <div class="form-group"
                                         :class="{'has-error': validation_errors.has('form_editar_traspaso.Editar Cumplimiento')}">
                                        <label for="Edit Cumplimiento" class="control-label"><b>Cumplimiento</b></label>
                                        <input type="text" name="Editar Cumplimiento" class="form-control input-sm fechas_edit" id="edit_cumplimiento"
                                               v-model="traspaso_edit.cumplimiento"
                                               v-datepicker>
                                        <label class="help"
                                               v-show="validation_errors.has('form_editar_traspaso.Editar Cumplimiento')">@{{ validation_errors.first('form_editar_traspaso.Editar Cumplimiento') }}</label>
                                    </div>
                                </div>
                                {{--Vencimiento Edit--}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Edit Vencimiento" class="control-label"><b>Vencimiento</b></label>
                                        <input type="text" name="Edit Vencimiento" class="form-control input-sm fechas_edit" id="edit_vencimiento" v-model="traspaso_edit.vencimiento" v-datepicker>
                                    </div>
                                </div>
                                {{--Importe Edit--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_traspaso.Editar Importe')}">
                                        <label><b>Importe</b></label>
                                        <input type="text" class="form-control pull-right" id="edit_importe"
                                               :value="traspaso_edit.importe"
                                               name="Editar Importe"
                                               v-model="traspaso_edit.importe"
                                               v-validate="'required|decimal:6'">
                                        <label class="help" v-show="validation_errors.has('form_editar_traspaso.Editar Importe')">@{{ validation_errors.first('form_editar_traspaso.Editar Importe') }}</label>
                                    </div>
                                </div>
                                {{--Referencia Edit--}}
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_traspaso.Referencia')}">
                                        <label><b>Referencia</b></label>
                                        <input type="text" class="form-control pull-right" id="edit_referencia" value="" name="Editar Referencia" v-model="traspaso_edit.referencia" v-validate="'required'">
                                        <label class="help" v-show="validation_errors.has('form_editar_traspaso.Referencia')">@{{ validation_errors.first('form_editar_traspaso.Referencia') }}</label>
                                    </div>
                                </div>
                                {{--Observaciones Edit--}}
                                <div class="col-md-12">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_editar_traspaso.Editar Observaciones')}">
                                        <label for="comment"><b>Observaciones</b></label>
                                        <textarea class="form-control" rows="8"
                                                  id="edit_observaciones"
                                                  name="Editar Observaciones"
                                                  v-model="traspaso_edit.observaciones"
                                                  v-validate="'required'">@{{traspaso_edit.observaciones}}</textarea>
                                        <label class="help" v-show="validation_errors.has('form_editar_traspaso.Editar Observaciones')">@{{ validation_errors.first('form_editar_traspaso.Editar Observaciones') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" @click="close_edit_traspaso">Cerrar</button>
                                <button type="submit" class="btn btn-primary" >Guardar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            @endpermission
        </section>
    </traspaso-cuentas-index>

@endsection