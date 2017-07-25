@extends('sistema_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIAL')
@section('contentheader_description', '(DETALLE)')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_material.show', $familia) !!}

    <global-errors></global-errors>
    <cuenta-material-index
                :familia="{{$familia}}"
                :datos_contables="{{$currentObra->datosContables}}"
                :url_cuenta_material_store="'{{route('sistema_contable.cuenta_material.store')}}'"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">

                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cuenta de Materiales
                                    </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="col-sm-6">
                                        <dl>
                                            <dt>ID</dt>
                                            <dd>{{$familia[0]->id_material}}</dd>
                                            <dt>DESCRIPCION</dt>
                                            <dd>{{$familia[0]->descripcion}}</dd>
                                        </dl>
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
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
                                            <table class="table table-bordered table-striped small ">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Cuenta</th>
                                                    <th>Fecha y Hora de Registro</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                    <tr v-for="(cuenta, index) in data.familia">
                                                        <td>@{{index+1}}</td>
                                                        <td width="65%">@{{cuenta.descripcion}}</td>
                                                        <td v-if="cuenta.cuenta_material != null">
                                                            @{{ cuenta.cuenta_material.cuenta }}
                                                        </td>
                                                        <td v-else>
                                                            ---
                                                        </td>
                                                        <td>@{{cuenta.FechaHoraRegistro}}</td>
                                                        <td>
                                                            <div class="btn-group" v-if="cuenta.cuenta_material != null">
                                                                <button title="Editar" class="btn-xs btn btn-info" type="button" @click="editar(cuenta)"><i class="fa fa-edit"></i> </button>
                                                            </div>
                                                            <div class="btn-group" v-else>
                                                                <button title="Registrar" class="btn-xs btn btn-success" type="button" @click="editar(cuenta)"><i class="fa fa-edit"></i> </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Cuenta</th>
                                                        <th>Fecha y Hora de Registro</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Editar Configuración de Cuenta -->
                <!-- Modal Edit Cuenta -->
                <div id="edit_cuenta_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_edit_cuenta"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">
                                    <span v-if="data.cuenta_material_edit.cuenta_material != null">
                                        Actualizar Cuenta Material
                                    </span>
                                    <span v-else>
                                        Registrar Cuenta Material
                                    </span>
                                </h4>
                            </div>
                            <form id="form_edit_cuenta" @submit.prevent="validateForm('form_edit_cuenta', data.cuenta_material_edit.cuenta_material != null ? 'confirm_update_cuenta' : 'confirm_save_cuenta')"  data-vv-scope="form_edit_cuenta">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label"><b>Material</b></label>
                                                <p>@{{ data.cuenta_material_edit.descripcion }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                                <label class="control-label"><b>Cuenta Contable</b></label>
                                                <input id="cuenta_contable" :placeholder="datos_contables.FormatoCuenta"
                                                       type="text" v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                       class="form-control formato_cuenta" name="Cuenta Contable" v-model="form.cuenta_material.cuenta">
                                                <label class="help" v-show="validation_errors.has('form_edit_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_edit_cuenta.Cuenta Contable') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_cuenta.Tipo Cuenta de Material')}">
                                                <label class="control-label"><b>Tipo Cuenta de Material</b></label>
                                                <select class="form-control" v-model="form.cuenta_material.id_tipo_cuenta_material" name="Tipo Cuenta de Material" v-validate="'required'">
                                                    <option value>[-SELECCIONE-]</option>
                                                    <option value="1">Materiales</option>
                                                    <option value="2">Mano de Obra y Servicios</option>
                                                </select>
                                                <label class="help" v-show="validation_errors.has('form_edit_cuenta.Tipo Cuenta de Material')">@{{ validation_errors.first('form_edit_cuenta.Tipo Cuenta de Material') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" @click="close_edit_cuenta">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" >Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Editar Configuración de Cuenta -->




            </section>
        </cuenta-material-index>
@endsection