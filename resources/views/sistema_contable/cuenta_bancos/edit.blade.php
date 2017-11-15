@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTA BANCARIA')
@section('contentheader_description', '(EDITAR)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuentas_contables_bancarias.edit', $cuenta->id_cuenta) !!}

    <cuenta-bancaria-edit
            :cuenta="{{$cuenta->toJson()}}"
            :tipos="{{$tipos->toJson()}}"
            :cuentas_asociadas="{{$cuentas_asociadas->toJson()}}"
            :cuenta_store_url="'{{route('sistema_contable.cuentas_contables_bancarias.store')}}'"
            :datos_contables="{{$currentObra->datosContables}}"
            inline-template
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Información de la Cuenta</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong>Razón Social</strong>
                            <p class="text-muted">{{ $cuenta->empresa->razon_social }}</p>
                            <hr>
                            <strong>Número</strong>
                            <p class="text-muted">{{ $cuenta->numero }}</p>
                            <hr>
                            <strong>Abreviatura</strong>
                            <p>{{ $cuenta->abreviatura }}</p>
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
                                        @permission(['eliminar_cuenta_contable_bancaria', 'editar_cuenta_contable_bancaria', 'registrar_cuenta_contable_bancaria'])
                                        <th>
                                            @permission('registrar_cuenta_contable_bancaria')
                                            <button title="Registrar Cuenta" class="btn btn-xs btn-success" @click="create_cuenta_bancaria"><i class="fa fa-plus"></i> </button>
                                            @endpermission
                                        </th>
                                        @endpermission
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(cuenta, index) in asociadas">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ cuenta.cuenta }}</td>
                                        <td>@{{ tipo_info(cuenta.id_tipo_cuenta_contable).descripcion }}</td>
                                        @permission(['eliminar_cuenta_contable_bancaria', 'editar_cuenta_contable_bancaria', 'registrar_cuenta_contable_bancaria'])
                                        <td>
                                            @permission('eliminar_cuenta_contable_bancaria')
                                            <button type="button" class="btn btn-xs btn-danger"
                                                    title="Eliminar"
                                                    @click="confirm_elimina_cuenta(cuenta)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            @endpermission
                                            @permission('editar_cuenta_contable_bancaria')
                                            <button type="button" class="btn btn-xs btn-info" title="Editar"
                                                    @click="edit_cuenta_bancaria(cuenta)">
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
            @permission('registrar_cuenta_contable_bancaria')
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
                                                    v-model="form.id_tipo_cuenta_contable"
                                                    v-validate="'required'" id="id_int_tipo_cuenta_empresa">
                                                <option value value="">[-SELECCIONE-]</option>
                                                <option v-for="tipo in obtener_tipos_disponibles()"
                                                        :value="tipo.id_tipo_cuenta_contable">@{{tipo.descripcion}}</option>
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_create_cuenta.Tipo de Cuenta')">@{{ validation_errors.first('form_create_cuenta.Tipo de Cuenta') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_create_cuenta.Cuenta Contable')}">
                                            <label class="control-label"><b>Cuenta Contable</b></label>
                                            <input type="text"
                                                   :placeholder="datos_contables.FormatoCuenta"
                                                   v-validate="'required'"
                                                   class="form-control formato_cuenta" name="Cuenta Contable"
                                                   v-model="form.cuenta">
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
            @endpermission
            <!-- Modal Edit Cuenta -->
            @permission('editar_cuenta_contable_bancaria')
            <div id="edit_movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="close_modal('edit_movimiento_modal')" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">
                                    <span>
                                        Actualizar Cuenta Bancaria
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
                                            <h5>@{{ cuenta_descripcion }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                            <label class="control-label"><b>Cuenta Contable</b></label>
                                            <input type="text"
                                                   :placeholder="datos_contables.FormatoCuenta"
                                                   v-validate="'required'"
                                                   class="form-control formato_cuenta" name="Cuenta Contable"
                                                   v-model="form.cuenta">
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
            @endpermission
        </section>
    </cuenta-bancaria-edit>
@endsection
