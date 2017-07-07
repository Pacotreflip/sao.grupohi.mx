@extends('sistema_contable.layout')
@section('title', 'Cuentas de Conceptos')
@section('contentheader_title', 'CUENTAS DE CONCEPTOS')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_concepto.index') !!}

    <div id="app">
        <cuenta-concepto-index
                :conceptos="{{$conceptos}}"
                :url_concepto_get_by="'{{route('sistema_contable.concepto.getBy')}}'"
                :url_store_cuenta="'{{route('sistema_contable.cuenta_concepto.store')}}'"
                :datos_contables="{{$currentObra->datosContables}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Datos Concepto de la Cuenta -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuentas de Conceptos</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small" v-treegrid id="concepto_tree">
                                        <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Cuenta Contable</th>
                                            <th>Usuario que Registró</th>
                                            <th>Fecha y Hora de Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr  v-for="(concepto, index) in conceptos_ordenados" :class="tr_class(concepto)" :id="tr_id(concepto)" >
                                                <td v-if="concepto.id_padre == null">
                                                    @{{ concepto.descripcion }}
                                                    <a :disabled="cargando" v-if="concepto.tiene_hijos > 0 && ! concepto.cargado" @click="get_hijos(concepto)">
                                                        <span v-if="cargando">
                                                            <i class="fa fa-spin fa-spinner"></i>
                                                        </span>
                                                        <span v-else>
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td  v-else>
                                                    @{{ concepto.descripcion}}
                                                    <a :disabled="cargando" v-if="concepto.tiene_hijos > 0 && ! concepto.cargado" @click="get_hijos(concepto)">
                                                        <span v-if="cargando">
                                                            <i class="fa fa-spin fa-spinner"></i>
                                                        </span>
                                                        <span v-else>
                                                            <i class="fa fa-plus"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td >
                                                    @{{ concepto.cuenta_concepto != null ? concepto.cuenta_concepto.cuenta : '---' }}
                                                </td>
                                                <td>
                                                    @{{ concepto.cuenta_concepto != null ? concepto.cuenta_concepto.usuario_registro : '---' }}
                                                </td>
                                                <td>
                                                    @{{ concepto.cuenta_concepto != null ? (new Date(concepto.cuenta_concepto.created_at)).dateFormat() : '---' }}
                                                </td>
                                                <td>
                                                    <button title="Editar" class="btn-xs btn-info" @click="edit_cuenta(concepto)"> <i class="fa fa-edit"></i></button>
                                                </td>
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
                                    <span v-if="form.concepto_edit.cuenta_concepto != null">
                                        Actualizar Cuenta Contable
                                    </span>
                                    <span v-else>
                                        Registrar Cuenta Contable
                                    </span>
                                </h4>
                            </div>
                            <form id="form_edit_cuenta" @submit.prevent="validateForm('form_edit_cuenta', form.concepto_edit.cuenta_concepto != null ? 'confirm_update_cuenta' : 'confirm_save_cuenta')"  data-vv-scope="form_edit_cuenta">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><b>Concepto</b></label>
                                                <p>@{{ form.concepto }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                                <label class="control-label"><b>Cuenta Contable</b></label>
                                                <input id="cuenta_contable" :placeholder="datos_contables.FormatoCuenta" type="text" v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp" class="form-control" name="Cuenta Contable" v-model="form.cuenta">
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
        </cuenta-concepto-index>
    </div>
@endsection