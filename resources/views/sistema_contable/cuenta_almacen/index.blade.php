@extends('sistema_contable.layout')
@section('title', 'Cuentas Almacenes')
@section('contentheader_title', 'CUENTAS DE ALMACENES')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_almacen.index') !!}

    <global-errors></global-errors>
    <cuenta-almacen-index
            :almacenes="{{$almacenes}}"
            :datos_contables="{{$currentObra->datosContables}}"
            :url_cuenta_almacen_store="'{{route('sistema_contable.cuenta_almacen.store')}}'"
            :url_cuenta_almacen="'{{route('sistema_contable.cuenta_almacen.index')}}'"
            v-cloak
            inline-template>
        <section>
            <div class="row" >
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cuentas de Almacenes</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="row table-responsive">
                                    <table class="table table-bordered table-striped small index_table" role="grid" aria-describedby="tipo_cuenta_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Almacén</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Tipo de Almacén</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Cuenta Contable</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.almacenes">
                                            <td>@{{ index + 1 }}</td>
                                            <td>@{{ item.descripcion  }}</td>
                                            <td>@{{ item.tipo_almacen  }}</td>
                                            <td v-if="item.cuenta_almacen != null">
                                                @{{ item.cuenta_almacen.cuenta }}
                                            </td>
                                            <td v-else>
                                                ---
                                            </td>
                                            <td style="min-width: 90px;max-width: 90px">
                                                <div class="btn-group">
                                                    <button title="Editar" class="btn btn-xs btn-info" type="button" @click="editar(item)"><i class="fa fa-edit"></i> </button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Almacén</th>
                                                <th>Tipo de Almacén</th>
                                                <th>Cuenta Contable</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br/>
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
                                <span v-if="data.almacen_edit.cuenta_almacen != null">
                                    Actualizar Cuenta Contable
                                </span>
                                <span v-else>
                                    Registrar Cuenta Contable
                                </span>
                            </h4>
                        </div>
                        <form id="form_edit_cuenta" @submit.prevent="validateForm('form_edit_cuenta', data.almacen_edit.cuenta_almacen != null ? 'confirm_update_cuenta' : 'confirm_save_cuenta')"  data-vv-scope="form_edit_cuenta">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><b>Almacén</b></label>
                                            <p>@{{ data.almacen_edit.descripcion }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_cuenta.Cuenta Contable')}">
                                            <label class="control-label"><b>Cuenta Contable</b></label>
                                            <input id="cuenta_contable" :placeholder="datos_contables.FormatoCuenta" type="text" v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp" class="form-control formato_cuenta" name="Cuenta Contable" v-model="form.cuenta_almacen.cuenta">
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
            <!-- Modal Editar Configuración de Cuenta -->
        </section>
    </cuenta-almacen-index>

@endsection