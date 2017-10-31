@extends('sistema_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIALES')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.cuenta_material.index') !!}
@endsection
@section('main-content')

    <global-errors></global-errors>
    <cuenta-material-index
            v-cloak
            inline-template
            :material_url="'{{route('material.index')}}'"
            :datos_contables="{{$currentObra->datosContables}}"
            :url_store_cuenta="'{{route('sistema_contable.cuenta_material.store')}}'"
            :tipos_cuenta_material="{{$tipos_cuenta_material->toJson()}}">
        <section>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-10">
                        <select class="form-control" v-model="form.tipo_material">
                            <option value disabled>[--SELECCIONE--]</option>
                            <option value="1">Materiales</option>
                            <option value="2">Mano de Obra y Servicios</option>
                            <option value="4">Herramienta y Equipo</option>
                            <option value="8">Maquinaria</option>
                        </select>
                    </div>
                    <div class="col-xs-2">
                        <button class="btn btn-success btn-block" @click="fetch_materiales" :disabled="cargando">
                                <span v-if="cargando">
                                    <i class="fa fa-spin fa-spinner"></i>
                                    Buscando...
                                </span>
                            <span v-else>
                                    <i class="fa fa-search"></i>
                                    Buscar
                                </span>
                        </button>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info" v-if="materiales.length">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cuentas de Materiales</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" v-treegrid id="material_tree">
                                    <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Cuenta Contable</th>
                                        <th>Tipo de Cuenta de Material</th>
                                        <th>Usuario que Registró</th>
                                        <th>Fecha y Hora de Registro</th>
                                        @permission(['editar_cuenta_material', 'registrar_cuenta_material'])
                                        <th>Acciones</th>
                                        @endpermission
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(material, index) in materiales_ordenados" :class="tr_class(material)" :id="tr_id(material)" >
                                        <td v-if="material.id_padre == null">
                                            @{{ material.descripcion }}
                                            <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="material.tiene_hijos > 0 && ! material.cargado" @click="get_hijos(material)">
                                                <span v-if="cargando">
                                                    <i class="fa fa-spin fa-spinner"></i>
                                                </span>
                                                <span v-else>
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            </button>
                                        </td>
                                        <td  v-else>
                                            @{{ material.descripcion }}
                                            <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="material.tiene_hijos > 0 && ! material.cargado" @click="get_hijos(material)">
                                                <span v-if="cargando">
                                                    <i class="fa fa-spin fa-spinner"></i>
                                                </span>
                                                <span v-else>
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            </button>
                                        </td>
                                        <td >
                                            @{{ material.cuenta_material != null ? material.cuenta_material.cuenta : '---' }}
                                        </td>
                                        <td>
                                            @{{ material.cuenta_material != null ? material.cuenta_material.tipo_cuenta_material.descripcion : '---' }}
                                        </td>
                                        <td>
                                            @{{ material.cuenta_material != null ? material.cuenta_material.usuario_registro : '---' }}
                                        </td>
                                        <td>
                                            @{{ material.cuenta_material != null ? (new Date(material.cuenta_material.created_at)).dateFormat() : '---' }}
                                        </td>
                                        @permission(['editar_cuenta_material', 'registrar_cuenta_material'])
                                        <td v-if="material.cuenta_material != null">
                                            @permission('editar_cuenta_material')
                                            <button title="Editar" class="btn btn-xs btn-info" @click="edit_cuenta(material)"> <i class="fa fa-edit"></i></button>
                                            @endpermission
                                        </td>
                                        <td v-else>
                                            @permission('registrar_cuenta_material')
                                            <button title="Registrar" class="btn btn-xs btn-success" @click="edit_cuenta(material)"> <i class="fa fa-edit"></i></button>
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

            <!-- Modal Edit Cuenta -->
            <div id="edit_cuenta_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-label="Close" @click="close_edit_cuenta"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <span v-if="form.material_edit.cuenta_material != null">
                                    Actualizar Cuenta Contable
                                </span>
                                <span v-else>
                                    Registrar Cuenta Contable
                                </span>
                            </h4>
                        </div>
                        <form id="form_edit_cuenta" @submit.prevent="validateForm('form_edit_cuenta', form.material_edit.cuenta_material != null ? 'confirm_update_cuenta' : 'confirm_save_cuenta')"  data-vv-scope="form_edit_cuenta">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"><b>Material</b></label>
                                            <p>@{{ form.material }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_tipo_cuenta_material"><strong>Tipo de Cuenta de Material</strong></label>
                                            <select name="Tipo de Cuenta de Material" class="form-control" v-model="form.id_tipo_cuenta_material">
                                                <option value disabled>[--SELECCIONE--]</option>
                                                <option v-for="tipo in tipos_cuenta_material" :value="tipo.id">@{{ tipo.descripcion }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                            <label class="control-label"><b>Cuenta Contable</b></label>
                                            <input id="cuenta_contable" :placeholder="datos_contables.FormatoCuenta" type="text" v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp" class="form-control formato_cuenta" name="Cuenta Contable" v-model="form.cuenta">
                                            <label class="help" v-show="validation_errors.has('form_edit_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_edit_cuenta.Cuenta Contable') }}</label>
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
        </section>
    </cuenta-material-index>
@endsection