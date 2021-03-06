@extends('sistema_contable.layout')
@section('title', 'Cuentas Generales')
@section('contentheader_title', 'CUENTAS GENERALES')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.cuenta_contable.index') !!}
@endsection
@section('main-content')

    <global-errors></global-errors>
    <cuenta-contable-index
                :cuenta_contable_url="'{{route('sistema_contable.cuenta_contable.index')}}'"
                :tipos_cuentas_contables="{{$tipos_cuentas_contables}}"
                :datos_contables="{{$currentObra->datosContables}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuentas Generales</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo de Cuenta</th>
                                            <th>Prefijo</th>
                                            <th>Cuenta</th>
                                            @permission(['editar_cuenta_general', 'registrar_cuenta_general'])
                                            <th>Acciones</th>
                                            @endpermission
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.tipos_cuentas_contables">
                                            <td>@{{ index + 1  }}</td>
                                            <td>@{{ item.descripcion }}</td>
                                            <td>@{{ item.cuenta_contable ? item.cuenta_contable.prefijo : '' }}</td>
                                            <td>@{{ item.cuenta_contable ? item.cuenta_contable.cuenta_contable : '' }}</td>
                                            @permission(['editar_cuenta_general', 'registrar_cuenta_general'])
                                            <td v-if="item.cuenta_contable != null">
                                                @permission('editar_cuenta_general')
                                                <div class="btn-group">
                                                    <button title="Editar" type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-editar-cuenta" v-on:click="editar(item)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </div>
                                                @endpermission
                                            </td>
                                            <td v-else>
                                                @permission('registrar_cuenta_general')
                                                <div class="btn-group">
                                                    <button title="Registrar" type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-configurar-cuenta" v-on:click="configurar(item)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
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

                <!-- Modal Editar Cuenta Contable -->
                <div class="modal fade" id="modal-editar-cuenta" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Modificar Cuenta Contable</h4>
                            </div>
                            <form  id="form_update_cuenta" @submit.prevent="validateForm('form_update_cuenta', 'update_cuenta')"  data-vv-scope="form_update_cuenta">
                                <div class="modal-body">
                                    <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="tipo_cuenta_contable" class="control-label"><b>Tipo de Cuenta Contable</b></label>
                                            <p>@{{ form.tipo_cuenta_contable_edit.descripcion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="con_prefijo" class="control-label"><b>Con Prefijo</b></label><br>
                                            <input type="checkbox" name="con_prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_update_cuenta.Prefijo') }">
                                            <label for="prefijo"><b>Prefijo</b></label>
                                            <input type="text"  v-validate="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|numeric' : ''" class="form-control" name="Prefijo" id="prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.prefijo"/>
                                            <label class="help" v-show="validation_errors.has('form_update_cuenta.Prefijo')">@{{ validation_errors.first('form_update_cuenta.Prefijo') }}</label>
                                        </div>
                                        <div v-show="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_update_cuenta.Cuenta Contable') }">
                                            <label for="cuenta"><b>Cuenta Contable</b></label>
                                            <input :placeholder="datos_contables.FormatoCuenta" type="text"  v-validate="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|regex:' + datos_contables.FormatoCuentaRegExp : ''" class="form-control formato_cuenta" name="Cuenta Contable" id="cuenta" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable"/>
                                            <label class="help" v-show="validation_errors.has('form_update_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_update_cuenta.Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal('modal-editar-cuenta')">Cerrar</button>
                                        <button type="submit" class="btn btn-primary" :disabled="guardando">Guardar</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>

                <!-- Modal Configurar Cuenta Contable -->
                <div class="modal fade" id="modal-configurar-cuenta" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Configurar Cuenta Contable</h4>
                            </div>
                            <form id="form_save_cuenta" @submit.prevent="validateForm('form_save_cuenta', 'save_cuenta')"  data-vv-scope="form_save_cuenta">
                                <div class="modal-body">
                                    <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="tipo_cuenta_contable" class="control-label"><b>Tipo de Cuenta Contable</b></label>
                                            <p>@{{ form.tipo_cuenta_contable_edit.descripcion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="con_prefijo" class="control-label"><b>Con Prefijo</b></label><br>
                                            <input type="checkbox" name="con_prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_save_cuenta.Prefijo') }">
                                            <label for="prefijo"><b>Prefijo</b></label>
                                            <input type="text"  v-validate="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|numeric' : ''" class="form-control" name="Prefijo" id="prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.prefijo"/>
                                            <label class="help" v-show="validation_errors.has('form_save_cuenta.Prefijo')">@{{ validation_errors.first('form_save_cuenta.Prefijo') }}</label>
                                        </div>
                                        <div v-show="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_save_cuenta.Cuenta Contable') }">
                                            <label for="cuenta"><b>Cuenta Contable</b></label>
                                            <input :placeholder="datos_contables.FormatoCuenta" type="text"  v-validate="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|regex:' + datos_contables.FormatoCuentaRegExp : ''" class="form-control formato_cuenta" name="Cuenta Contable" id="cuenta" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable"/>
                                            <label class="help" v-show="validation_errors.has('form_save_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_save_cuenta.Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default" data-dismiss="modal" id="closeModal('modal-configurar-cuenta')">Cerrar</button>
                                        <button type="submit" class="btn btn-primary" :disabled="guardando">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
            </section>
        </cuenta-contable-index>
@endsection