@extends('sistema_contable.layout')
@section('title', 'Cuentas Contables')
@section('contentheader_title', 'CUENTAS CONTABLES')
@section('contentheader_description', '(CONFIGURACIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_contable.configuracion') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <configuracion-contable
                :obra_update_url="'{{route('sistema_contable.obra.update', $currentObra)}}'"
                :cuenta_store_url="'{{route('sistema_contable.cuenta_contable.store')}}'"
                :tipos_cuentas_contables="{{$tipos_cuentas_contables}}"
                :obra="{{$currentObra}}"
                :cuentas_contables="{{$cuentas_contables}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Información de la Obra -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos de la Obra</h3>
                            </div>
                            <form class="form-horizontal" id="form_datos_obra" @submit.prevent="validateForm('form_datos_obra', 'save_datos_obra')"  data-vv-scope="form_datos_obra">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Base de Datos CONTPAQ') }">
                                            <label for="BDContPaq" class="col-md-3 control-label"><b>Base de Datos CONTPAQ</b></label>
                                            <div class="col-md-9">
                                                <input type="text" v-validate="'required'" name="Base de Datos CONTPAQ" class="form-control" id="BDContPaq" v-model="data.obra.BDContPaq">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Base de Datos CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Base de Datos CONTPAQ') }}</label>
                                            </div>
                                            </div>
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ') }">
                                            <label for="NumobraContPaq" class="col-md-3 control-label"><b>Número de Obra CONTPAQ</b></label>
                                            <div class="col-md-9">
                                                <input type="number" v-validate="'required|numeric'" name="Numero de Obra CONTPAQ" class="form-control" id="NumobraContPaq" v-model="data.obra.NumobraContPaq">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Numero de Obra CONTPAQ') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Formato de Cuentas') }">
                                            <label for="FormatoCuenta" class="col-md-3 control-label"><b>Formato de Cuentas</b></label>
                                            <div class="col-md-9">
                                                <input type="text" v-validate="'required|regex:^\#[\#\-]+\#$'" name="Formato de Cuentas" class="form-control" id="FormatoCuenta" v-model="data.obra.FormatoCuenta">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Formato de Cuentas')">@{{ validation_errors.first('form_datos_obra.Formato de Cuentas') }}</label>
                                            </div>
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
                    <div class="col-md-6">
                        <!-- Configuración de Cuenta -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Configuración de Cuenta</h3>
                            </div>
                            <form class="form-horizontal" id="form_datos_cuenta" @submit.prevent="validateForm('form_datos_cuenta', 'save_datos_cuenta')"  data-vv-scope="form_datos_cuenta">
                            <div class="box-body">
                                <div class="col-md-9">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_cuenta.Tipo de Cuenta') }" >
                                        <label for="BDContPaq" class="control-label">Tipo de Cuenta</label>
                                        <select name="Tipo de Cuenta" class="form-control" v-model="form.cuenta_contable.id_int_tipo_cuenta_contable" v-validate="'required|numeric'">
                                            <option value disabled>[-SELECCIONE-]</option>
                                            <option v-for="(tipo_cuenta_contable, index) in tipos_cuentas_contables_disponibles" :value="index">@{{ tipo_cuenta_contable }}</option>
                                        </select>
                                        <label class="help" v-show="validation_errors.has('form_datos_cuenta.Tipo de Cuenta')">@{{ validation_errors.first('form_datos_cuenta.Tipo de Cuenta') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-2 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="con_prefijo" class="control-label">Con Prefijo</label><br>
                                        <input type="checkbox" name="con_prefijo" v-model="form.cuenta_contable.con_prefijo">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="form.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_datos_cuenta.Prefijo') }">
                                        <label for="prefijo">Prefijo</label>
                                        <input type="text"  v-validate="form.cuenta_contable.con_prefijo ? 'required|numeric' : ''" class="form-control" name="Prefijo" id="prefijo" v-model="form.cuenta_contable.prefijo"/>
                                        <label class="help" v-show="validation_errors.has('form_datos_cuenta.Prefijo')">@{{ validation_errors.first('form_datos_cuenta.Prefijo') }}</label>
                                    </div>
                                    <div v-show="! form.cuenta_contable.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_datos_cuenta.Cuenta') }">
                                        <label for="cuenta">Cuenta</label>
                                        <input type="text"  v-validate="! form.cuenta_contable.con_prefijo ? 'required|regex:' + data.obra.FormatoCuentaRegExp : ''" class="form-control" name="Cuenta" id="cuenta" v-model="form.cuenta_contable.cuenta_contable"/>
                                        <label class="help" v-show="validation_errors.has('form_datos_cuenta.Cuenta')">@{{ validation_errors.first('form_datos_cuenta.Cuenta') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info pull-right" :disabled="guardando" >
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <hr>

                <div v-if="data.cuentas_contables.length" class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuentas Contables Configuradas</h3>
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
                                            <th>Editar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.cuentas_contables">
                                            <td>@{{ index + 1  }}</td>
                                            <td>@{{ item.tipo_cuenta_contable ? item.tipo_cuenta_contable.descripcion : ''}}</td>
                                            <td>@{{ item.prefijo ? item.prefijo : '' }}</td>
                                            <td>@{{ item.cuenta_contable ? item.cuenta_contable : '' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-configurar-cuenta" v-on:click="editar(item)">
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

                <!-- Modal Editar Configuración de Cuenta -->
                <div class="modal fade" id="modal-configurar-cuenta" style="display: none;" id="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Modificar Cuenta Contable</h4>
                            </div>
                            <form class="form-horizontal" id="form_datos_cuenta_update" @submit.prevent="validateForm('form_datos_cuenta_update', 'save_datos_cuenta_update')"  data-vv-scope="form_datos_cuenta_update">
                                <div class="box-body">
                                    <div class="col-md-9">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_cuenta_update.Tipo de Cuenta') }" >
                                            <label for="BDContPaq" class="control-label">Tipo de Cuenta</label>
                                            <select name="Tipo de Cuenta" class="form-control" v-model="form.cuenta_contable_update.id_int_tipo_cuenta_contable" v-validate="'required|numeric'" id="id_int_tipo_cuenta_contable">
                                                <option value disabled>[-SELECCIONE-]</option>
                                                <option v-for="(tipo_cuenta_contable, index) in tipos_cuentas_contables_update" :value="index">@{{ tipo_cuenta_contable }}</option>
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_datos_cuenta_update.Tipo de Cuenta')">@{{ validation_errors.first('form_datos_cuenta_update.Tipo de Cuenta') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="con_prefijo" class="control-label">Con Prefijo</label><br>
                                            <input type="checkbox" name="con_prefijo" v-model="form.cuenta_contable_update.con_prefijo">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="form.cuenta_contable_update.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_datos_cuenta_update.Prefijo') }">
                                            <label for="prefijo">Prefijo</label>
                                            <input type="text"  v-validate="form.cuenta_contable_update.con_prefijo ? 'required|numeric' : ''" class="form-control" name="Prefijo" id="prefijo" v-model="form.cuenta_contable_update.prefijo"/>
                                            <label class="help" v-show="validation_errors.has('form_datos_cuenta_update.Prefijo')">@{{ validation_errors.first('form_datos_cuenta.Prefijo') }}</label>
                                        </div>
                                        <div v-show="! form.cuenta_contable_update.con_prefijo" class="form-group" :class="{'has-error': validation_errors.has('form_datos_cuenta_update.Cuenta') }">
                                            <label for="cuenta">Cuenta</label>
                                            <input type="text"  v-validate="! form.cuenta_contable_update.con_prefijo ? 'required|regex:' + data.obra.FormatoCuentaRegExp : ''" class="form-control" name="Cuenta" id="cuenta" v-model="form.cuenta_contable_update.cuenta_contable"/>
                                            <label class="help" v-show="validation_errors.has('form_datos_cuenta_update.Cuenta')">@{{ validation_errors.first('form_datos_cuenta_update.Cuenta') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-md-12">

                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="closeModal">Cerrar</button>
                                        <button type="submit" class="btn btn-info pull-right" :disabled="guardando"  >
                                            <i class="fa fa-save"></i> Guradar
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
    </div>
@endsection