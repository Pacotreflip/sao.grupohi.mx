@extends('sistema_contable.layout')
@section('title', 'Pólizas Generadas')
@section('contentheader_title', 'PÓLIZAS GENERADAS')
@section('contentheader_description', '(EDICIÓN)')

@section('main-content')

    {!! Breadcrumbs::render('sistema_contable.cuenta_empresa.edit', $empresa) !!}
    <div id="app">
        <cuenta-empresa-edit
                :empresa="{{$empresa}}"
                :tipo_cuenta_empresa="{{$tipo_cuenta_empresa}}"
                :cuenta_store_url="'{{route('sistema_contable.cuenta_empresa.store')}}'"
                :datos_contables="{{$currentObra->datosContables}}"
                inline-template
                v-cloak>
            <section>


                <div class="row">

                    <div class="col-md-12">
                        <div class="box box-success">

                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@{{empresa.razon_social}} &nbsp;
                                    </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="col-sm-6">
                                        <dl>
                                            <dt>ID</dt>
                                            <dd>@{{empresa.id_empresa}}</dd>
                                            <dt>USUARIO QUE REGISTRÓ</dt>
                                            <dd>@{{empresa.user_registro}}</dd>
                                            <dt>FECHA Y HORA DE REGISTRO</dt>
                                            <dd>@{{empresa.FechaHoraRegistro}} </dd>
                                        </dl>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-success btn-app bg-green" style="float:right"
                           v-on:click="create_cuenta_empresa">
                            <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">Cuentas Configuradas</h3>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="box-body">
                                            <table class="table table-bordered table-striped ">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cuenta contable</th>
                                                    <th>Tipo de cuenta</th>
                                                    <td></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(cuenta,index) in data.empresa.cuentas_empresa">
                                                    <td>@{{index+1}}</td>
                                                    <td>@{{cuenta.cuenta}}</td>
                                                    <td>@{{cuenta.tipo_cuenta_empresa.descripcion}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-danger"
                                                                title="eliminar"
                                                                v-on:click="confirm_elimina_cuenta(cuenta)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-xs btn-info" title="edit"
                                                                v-on:click="edit_cuenta_empresa(cuenta)">
                                                            <i class="fa fa-edit"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add Cuenta -->
                <div id="add_movimiento_modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">
                                    <span v-if="nuevo_registro">
                                        Crear Cuenta Empresa
                                    </span>
                                    <span v-else>
                                        Actualizar Cuenta Empresa
                                    </span>

                                </h4>
                            </div>

                        <form id="form_create_cuenta" @submit.prevent="validateForm('form_create_cuenta','confirm_create_cuenta')"
             data-vv-scope="form_create_cuenta">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_create_cuenta.Tipo de Cuenta') }">
                                                <label for="Tipo de Cuenta" class="control-label">Tipo de Cuenta</label>
                                                <select name="Tipo de Cuenta" class="form-control"
                                                        v-model="form.cuenta_empresa_create.id_tipo_cuenta_empresa"
                                                        v-validate="'required|numeric'" id="id_int_tipo_cuenta_empresa">
                                                    <option value value="">[-SELECCIONE-]</option>
                                                    <option v-for="cuenta in cuentas_empresa_disponibles"
                                                            :value="cuenta.id">@{{cuenta.descripcion}}</option>
                                                </select>
                                                <label class="help"
                                                       v-show="validation_errors.has('form_create_cuenta.Tipo de Cuenta')">@{{ validation_errors.first('form_create_cuenta.Tipo de Cuenta') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_create_cuenta.Cuenta Contable')}">
                                                <label class="control-label">Cuenta Contable</label>
                                                <input type="text"
                                                       v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                       class="form-control" name="Cuenta Contable"
                                                       v-model="form.cuenta_empresa_create.cuenta">
                                                <label class="help"
                                                       v-show="validation_errors.has('form_create_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_create_cuenta.Cuenta Contable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            v-on:click="cerrar_dialog">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>


                            </span>


                        </div>
                    </div>
                </div>




                <!-- Modal Edit Cuenta -->
                <div id="edit_movimiento_modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                <label class="control-label">Cuenta Contable</label>
                                                <input type="text" class="form-control" name="Cuenta Contable"
                                                       v-model="form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                                <label class="control-label">Cuenta Contable</label>
                                                <input type="text"
                                                       v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                       class="form-control" name="Cuenta Contable"
                                                       v-model="form.cuenta_empresa_create.cuenta">
                                                <label class="help"
                                                       v-show="validation_errors.has('form_edit_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_edit_cuenta.Cuenta Contable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default"
                                            v-on:click="cerrar_dialog">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>

            </section>
        </cuenta-empresa-edit>
    </div>
@endsection
