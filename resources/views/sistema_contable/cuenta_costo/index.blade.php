@extends('sistema_contable.layout')
@section('title', 'Cuentas de Costos')
@section('contentheader_title', 'CUENTAS DE COSTOS')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_costo.index') !!}

    <cuenta-costo-index
            :costos="{{$costos->toJson()}}"
            :datos_contables="{{$currentObra->datosContables}}"
            :url_costo_get_by="'{{route('sistema_contable.costo.getBy')}}'"
            :url_costo_find_by="'{{route('sistema_contable.costo.findBy')}}'"
            :url_cuenta_costo_index="'{{ route('sistema_contable.cuenta_costo.index') }}'"
            v-cloak
            inline-template>
        <section>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-10">
                        <select class="form-control" id="costo_select" data-placeholder="BUSCAR costo" v-select2></select>
                    </div>
                    <input name="id_costo" id="id_costo" class="form-control" type="hidden"/>
                    <div class="col-xs-2">
                        <button class="btn btn-success btn-block" :disabled="cargando" @click="buscar_nodos">
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
                    <!-- Datos costo de la Cuenta -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cuentas de costos</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" v-treegrid id="costo_tree">
                                    <thead>
                                    <tr>
                                        <th>costo</th>
                                        <th>Cuenta Contable</th>
                                        <th>Usuario que Registró</th>
                                        <th>Fecha y Hora de Registro</th>
                                        {{--@permission(['editar_cuenta_costo', 'registrar_cuenta_costo'])--}}
                                        <th>Acciones</th>
                                        {{--@endpermission--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  v-for="(costo, index) in costos_ordenados" :class="tr_class(costo)" :id="tr_id(costo)" >
                                        <td v-if="costo.id_padre == null">
                                            @{{ costo.descripcion }}
                                            <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="costo.tiene_hijos > 0 && ! costo.cargado" @click="get_hijos(costo)">
                                                            <span v-if="cargando">
                                                                <i class="fa fa-spin fa-spinner"></i>
                                                            </span>
                                                <span v-else>
                                                                <i class="fa fa-plus"></i>
                                                            </span>
                                            </button>
                                        </td>
                                        <td  v-else>
                                            @{{ costo.descripcion}}
                                            <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="costo.tiene_hijos > 0 && ! costo.cargado" @click="get_hijos(costo)">
                                                            <span v-if="cargando">
                                                                <i class="fa fa-spin fa-spinner"></i>
                                                            </span>
                                                <span v-else>
                                                                <i class="fa fa-plus"></i>
                                                            </span>
                                            </button>
                                        </td>
                                        <td >
                                            @{{ costo.cuenta_costo != null ? costo.cuenta_costo.cuenta : '---' }}
                                        </td>
                                        <td>
                                            @{{ costo.cuenta_costo != null ? costo.cuenta_costo.usuario_registro : '---' }}
                                        </td>
                                        <td>
                                            @{{ costo.cuenta_costo != null ? (new Date(costo.cuenta_costo.created_at)).dateFormat() : '---' }}
                                        </td>
                                        @permission(['editar_cuenta_costo', 'registrar_cuenta_costo', 'eliminar_cuenta_costo'])
                                        <td>
                                            @permission('editar_cuenta_costo')
                                                <button v-if="costo.cuenta_costo != null" title="Editar" class="btn btn-xs btn-info" @click="edit_cuenta(costo)"> <i class="fa fa-edit"></i></button>
                                                <button v-else title="Registrar" class="btn btn-xs btn-success" @click="edit_cuenta(costo)"> <i class="fa fa-edit"></i></button>
                                            @endpermission
                                            @permission(['eliminar_cuenta_costo'])
                                            <div class="btn-group" v-if="costo.cuenta_costo != null">
                                                <button v-if="costo.cuenta_costo != null"type="button" title="Eliminar" class="btn btn-xs btn-danger" v-on:click="confirm_delete_cuenta(costo.cuenta_costo.id_cuenta_costo)"><i class="fa fa-trash"></i></button>
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

            <!-- Modal Edit Cuenta -->
            <div id="edit_cuenta_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-label="Close" @click="close_edit_cuenta"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                    <span v-if="form.costo_edit.cuenta_costo != null">
                                        Actualizar Cuenta Contable
                                    </span>
                                <span v-else>
                                        Registrar Cuenta Contable
                                    </span>
                            </h4>
                        </div>
                        <form id="form_edit_cuenta" @submit.prevent="validateForm('form_edit_cuenta', form.costo_edit.cuenta_costo != null ? 'confirm_update_cuenta' : 'confirm_save_cuenta')"  data-vv-scope="form_edit_cuenta">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><b>costo</b></label>
                                            <p>@{{ form.costo }}</p>
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
        </cuenta-costo-index>
@endsection
