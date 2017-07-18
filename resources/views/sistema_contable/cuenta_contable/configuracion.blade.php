@extends('sistema_contable.layout')
@section('title', 'Cuentas Contables')
@section('contentheader_title', 'CUENTAS CONTABLES')
@section('contentheader_description', '(CONFIGURACIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_contable.configuracion') !!}

    <global-errors></global-errors>
    <configuracion-contable
                :datos_contables_update_url="'{{route('sistema_contable.datos_contables.update', $currentObra->datosContables)}}'"
                :cuenta_contable_url="'{{route('sistema_contable.cuenta_contable.index')}}'"
                :tipos_cuentas_contables="{{$tipos_cuentas_contables}}"
                :datos_contables="{{$currentObra->datosContables}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Datos contables de la Obra -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos Contables de la Obra</h3>
                            </div>
                            <form  id="form_datos_obra" @submit.prevent="validateForm('form_datos_obra', 'save_datos_obra')"  data-vv-scope="form_datos_obra">
                                <div class="box-body">
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Base de Datos CONTPAQ') }">
                                            <label for="BDContPaq" class="control-label"><b>Base de Datos CONTPAQ</b></label>
                                            <input type="text" v-validate="'required'" name="Base de Datos CONTPAQ" class="form-control" id="BDContPaq" v-model="data.datos_contables.BDContPaq">
                                            <label class="help" v-show="validation_errors.has('form_datos_obra.Base de Datos CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Base de Datos CONTPAQ') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ') }">
                                            <label for="NumobraContPaq" class="control-label"><b>Número de Obra CONTPAQ</b></label>
                                            <input type="number" v-validate="'required|numeric'" name="Numero de Obra CONTPAQ" class="form-control" id="NumobraContPaq" v-model="data.datos_contables.NumobraContPaq">
                                            <label class="help" v-show="validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Numero de Obra CONTPAQ') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Formato de Cuentas') }">
                                            <label for="FormatoCuenta" class="control-label"><b>Formato de Cuentas</b></label>
                                            <input type="text" v-validate="'required|regex:^\#[\#\-]+\#$'" name="Formato de Cuentas" class="form-control" id="FormatoCuenta" v-model="data.datos_contables.FormatoCuenta">
                                            <label class="help" v-show="validation_errors.has('form_datos_obra.Formato de Cuentas')">@{{ validation_errors.first('form_datos_obra.Formato de Cuentas') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info pull-right" :disabled="guardando">
                                    <span v-if="guardando">
                                        <i class="fa fa-spinner fa-spin"></i> Guardando
                                    </span>
                                            <span v-else>
                                        <i class="fa fa-save"></i> Guardar
                                    </span>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <hr>

                <div v-if="data.tipos_cuentas_contables.length" class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Tipos de Cuentas Contables</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped small">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo de Cuenta</th>
                                            <th>Prefijo</th>
                                            <th>Cuenta</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.tipos_cuentas_contables">
                                            <td>@{{ index + 1  }}</td>
                                            <td>@{{ item.descripcion }}</td>
                                            <td>@{{ item.cuenta_contable ? item.cuenta_contable.prefijo : '' }}</td>
                                            <td>@{{ item.cuenta_contable ? item.cuenta_contable.cuenta_contable : '' }}</td>
                                            <td v-if="item.cuenta_contable != null">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-editar-cuenta" v-on:click="editar(item)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td v-else>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-configurar-cuenta" v-on:click="configurar(item)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
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

                <!-- Modal Editar Cuenta Contable -->
                <div class="modal fade" id="modal-editar-cuenta" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Modificar Cuenta Contable</h4>
                            </div>
                            <form class="form-horizontal" id="form_update_cuenta" @submit.prevent="validateForm('form_update_cuenta', 'update_cuenta')"  data-vv-scope="form_update_cuenta">
                                <div class="box-body">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="tipo_cuenta_contable" class="control-label">Tipo de Cuenta Contable</label>
                                            <input id="tipo_cuenta_contable" type="text" class="form-control" readonly v-model="form.tipo_cuenta_contable_edit.descripcion">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="con_prefijo" class="control-label">Con Prefijo</label><br>
                                            <input type="checkbox" name="con_prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_update_cuenta.Prefijo') }">
                                            <label for="prefijo">Prefijo</label>
                                            <input type="text"  v-validate="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|numeric' : ''" class="form-control" name="Prefijo" id="prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.prefijo"/>
                                            <label class="help" v-show="validation_errors.has('form_update_cuenta.Prefijo')">@{{ validation_errors.first('form_update_cuenta.Prefijo') }}</label>
                                        </div>
                                        <div v-show="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_update_cuenta.Cuenta Contable') }">
                                            <label for="cuenta">Cuenta Contable</label>
                                            <input :placeholder="data.datos_contables.FormatoCuenta" type="text"  v-validate="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|regex:' + data.datos_contables.FormatoCuentaRegExp : ''" class="form-control" name="Cuenta Contable" id="cuenta" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable"/>
                                            <label class="help" v-show="validation_errors.has('form_update_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_update_cuenta.Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="closeModal('modal-editar-cuenta')">Cerrar</button>
                                        <button type="submit" class="btn btn-info pull-right" :disabled="guardando">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
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
                            <form class="form-horizontal" id="form_save_cuenta" @submit.prevent="validateForm('form_save_cuenta', 'save_cuenta')"  data-vv-scope="form_save_cuenta">
                                <div class="box-body">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="tipo_cuenta_contable" class="control-label">Tipo de Cuenta Contable</label>
                                            <input id="tipo_cuenta_contable" type="text" class="form-control" readonly v-model="form.tipo_cuenta_contable_edit.descripcion">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="con_prefijo" class="control-label">Con Prefijo</label><br>
                                            <input type="checkbox" name="con_prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_save_cuenta.Prefijo') }">
                                            <label for="prefijo">Prefijo</label>
                                            <input type="text"  v-validate="form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|numeric' : ''" class="form-control" name="Prefijo" id="prefijo" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.prefijo"/>
                                            <label class="help" v-show="validation_errors.has('form_save_cuenta.Prefijo')">@{{ validation_errors.first('form_save_cuenta.Prefijo') }}</label>
                                        </div>
                                        <div v-show="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_save_cuenta.Cuenta Contable') }">
                                            <label for="cuenta">Cuenta Contable</label>
                                            <input :placeholder="data.datos_contables.FormatoCuenta" type="text"  v-validate="! form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo ? 'required|regex:' + data.datos_contables.FormatoCuentaRegExp : ''" class="form-control" name="Cuenta Contable" id="cuenta" v-model="form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable"/>
                                            <label class="help" v-show="validation_errors.has('form_save_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_save_cuenta.Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="closeModal('modal-configurar-cuenta')">Cerrar</button>
                                        <button type="submit" class="btn btn-info pull-right" :disabled="guardando">
                                            <i class="fa fa-save"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
            </section>
        </configuracion-contable>
@endsection