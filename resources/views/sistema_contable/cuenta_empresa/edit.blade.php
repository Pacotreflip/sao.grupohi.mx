@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTAS DE EMPRESAS')
@section('contentheader_description', '(EDITAR)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_empresa.edit', $empresa) !!}

    <cuenta-empresa-edit
            :empresa="{{$empresa}}"
            :tipo_cuenta_empresa="{{$tipo_cuenta_empresa}}"
            :cuenta_store_url="'{{route('sistema_contable.cuenta_empresa.store')}}'"
            :datos_contables="{{$currentObra->datosContables}}"
            inline-template
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Información de la Empresa</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong>Razón Social</strong>
                            <p class="text-muted">{{ $empresa->razon_social }}</p>
                            <hr>

                            <strong>RFC</strong>
                            <p class="text-muted">{{ $empresa->rfc }}</p>
                            <hr>

                            <strong>Usuario que Registró</strong>
                            <p>{{ $empresa->user_registro ? $empresa->user_registro : '---' }}</p>
                            <hr>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cuentas Configuradas</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cuenta contable</th>
                                        <th>Tipo de cuenta</th>
                                        @permission(['eliminar_cuenta_empresa', 'editar_cuenta_empresa', 'registrar_cuenta_empresa'])
                                        <th>
                                            @permission('registrar_cuenta_empresa')
                                            <button title="Registrar Cuenta" class="btn btn-xs btn-success" @click="create_cuenta_empresa"><i class="fa fa-plus"></i> </button>
                                            @endpermission
                                        </th>
                                        @endpermission
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(cuenta, index) in data.empresa.cuentas_empresa">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ cuenta.cuenta }}</td>
                                        <td>@{{ cuenta.tipo_cuenta_empresa.descripcion }}</td>
                                        @permission(['eliminar_cuenta_empresa', 'editar_cuenta_empresa', 'registrar_cuenta_empresa'])
                                        <td>
                                            @permission('eliminar_cuenta_empresa')
                                            <button type="button" class="btn btn-xs btn-danger"
                                                    title="Eliminar"
                                                    @click="confirm_elimina_cuenta(cuenta)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            @endpermission
                                            @permission('editar_cuenta_empresa')
                                            <button type="button" class="btn btn-xs btn-info" title="Editar"
                                                    @click="edit_cuenta_empresa(cuenta)">
                                                <i class="fa fa-edit"></i>
                                            </button>
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

            <!-- Modal Add Cuenta -->
            <div id="add_movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="close_modal('add_movimiento_modal')" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">
                                    <span v-if="nuevo_registro">
                                        Registrar Cuenta Contable
                                    </span>
                                <span v-else>
                                        Actualizar Cuenta Contable
                                    </span>

                            </h4>
                        </div>
                        <form id="form_create_cuenta" @submit.prevent="validateForm('form_create_cuenta','confirm_create_cuenta')" data-vv-scope="form_create_cuenta">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_create_cuenta.Tipo de Cuenta') }">
                                            <label for="Tipo de Cuenta" class="control-label"><b>Tipo de Cuenta</b></label>
                                            <select name="Tipo de Cuenta" class="form-control"
                                                    v-model="form.cuenta_empresa_create.id_tipo_cuenta_empresa"
                                                    v-validate="'required|numeric'" id="id_int_tipo_cuenta_empresa">
                                                <option value value="">[-SELECCIONE-]</option>
                                                <option v-for="cuenta in cuentas_empresa_disponibles"
                                                        :value="cuenta.id">@{{cuenta.descripcion}}</option>
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_create_cuenta.Tipo de Cuenta')">@{{ validation_errors.first('form_create_cuenta.Tipo de Cuenta') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_create_cuenta.Cuenta Contable')}">
                                            <label class="control-label"><b>Cuenta Contable!!</b></label>
                                            <input type="text"
                                                   :placeholder="datos_contables.FormatoCuenta"
                                                   v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                   class="form-control formato_cuenta" name="Cuenta Contable"
                                                   v-model="form.cuenta_empresa_create.cuenta">
                                            <label class="help"
                                                   v-show="validation_errors.has('form_create_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_create_cuenta.Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" @click="close_modal('add_movimiento_modal')">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Cuenta -->
            <div id="edit_movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="close_modal('edit_movimiento_modal')" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">
                                    <span>
                                        Actualizar Cuenta Empresa
                                    </span>

                            </h4>
                        </div>
                        <form id="form_edit_cuenta"
                              @submit.prevent="validateForm('form_edit_cuenta','confirm_edit_cuenta')"
                              data-vv-scope="form_edit_cuenta">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><b>Tipo de Cuenta</b></label>
                                            <p>@{{ form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                            <label class="control-label"><b>Cuenta Contable!!</b></label>
                                            <input type="text"
                                                   :placeholder="datos_contables.FormatoCuenta"
                                                   v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                   class="form-control formato_cuenta" name="Cuenta Contable"
                                                   v-model="form.cuenta_empresa_create.cuenta">
                                            <label class="help"
                                                   v-show="validation_errors.has('form_edit_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_edit_cuenta.Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        @click="close_modal('edit_movimiento_modal')">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </cuenta-empresa-edit>

    <script src="jquery.js" type="text/javascript"></script>
    <script src="jquery.maskedinput.js" type="text/javascript"></script>
@endsection
