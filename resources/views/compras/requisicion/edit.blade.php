@extends('compras.layout')
@section('title', 'Requisiciones')
@section('contentheader_title', 'REQUISICIONES')
@section('breadcrumb')
    {!! Breadcrumbs::render('compras.requisicion.edit', $requisicion) !!}
@endsection
@section('main-content')
    <div id="app">
        <global-errors></global-errors>
        <requisicion-edit
                :requisicion="{{$requisicion}}"
                :materiales="{{$materiales}}"
                :tipos_requisiciones="{{$tipos_requisiciones}}"
                :departamentos_responsables="{{$departamentos_responsables}}"
                :url_requisicion="'{{route('compras.requisicion.index')}}'"
                v-cloak inline-template>
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h1 class="box-title">Datos de la Requisición</h1>
                    </div>
                    <form id="form_requisicion_save" @submit.prevent="validateForm('form_requisicion_update', 'update_requisicion')"  data-vv-scope="form_requisicion_save">
                        <div class="box-body">
                            <div class="row">
                                <!-- Departamento Responsable -->
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_requisicion_save.Departamento Responsable') }">
                                        <label for="id_departamento" class="control-label"><b>Departamento Responsable</b></label>
                                        <select v-validate="'required'" class="form-control" name="Departamento Responsable" id="id_departamento" v-model="form.requisicion.id_departamento">
                                            <option value disabled>[-SELECCIONE-]</option>
                                            <option v-for="departamento in departamentos_responsables" :value="departamento.id">@{{ departamento.descripcion }}</option>
                                        </select>
                                        <label class="help" v-show="validation_errors.has('form_requisicion_save.Departamento Responsable')">@{{ validation_errors.first('form_requisicion_save.Departamento Responsable') }}</label>
                                    </div>
                                </div>
                                <!-- Tipo de Requisición -->
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_requisicion_save.Tipo de Requisición') }">
                                        <label for="id_tipo_requisicion" class="control-label"><b>Tipo de Requisición</b></label>
                                        <select v-validate="'required'" class="form-control" name="Tipo de Requisición" id="id_tipo_requisicion" v-model="form.requisicion.id_tipo_requisicion">
                                            <option value disabled>[-SELECCIONE-]</option>
                                            <option v-for="tipo in tipos_requisiciones" :value="tipo.id">@{{ tipo.descripcion }}</option>
                                        </select>
                                        <label class="help" v-show="validation_errors.has('form_requisicion_save.Tipo de Requisición')">@{{ validation_errors.first('form_requisicion_save.Tipo de Requisición') }}</label>
                                    </div>
                                </div>
                                <!-- Observaciones -->
                                <div class="col-md-12">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_requisicion_save.Observaciones') }">
                                        <label for="observaciones" class="control-label"><b>Observaciones</b></label>
                                        <textarea v-validate="'required'" maxlength="1000" name="Observaciones" class="form-control" style="resize: none" v-model="form.requisicion.observaciones"></textarea>
                                        <label class="help" v-show="validation_errors.has('form_requisicion_save.Observaciones')">@{{ validation_errors.first('form_requisicion_save.Observaciones') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" :disabled="data.guardando">
                            <span v-if="data.guardando">
                                Guardando <i class="fa fa-spin fa-spinner"></i>
                            </span>
                                <span v-else>
                                Guardar <i class="fa fa-save"></i>
                            </span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h1 class="box-title">Partidas</h1>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripcion</th>
                                        <th>No. Parte</th>
                                        <th>Cantidad</th>
                                        <th>Unidad</th>
                                        <th>Fecha</th>
                                        <th>Observaciones</th>
                                        <th><button type="button" class="btn-xs btn-success" @click="show_add_item"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in data.items">
                                        <td>@{{ index+1 }}</td>
                                        <td>@{{ item.material.descripcion}}</td>
                                        <td>@{{ item.material.numero_parte}}</td>
                                        <td>@{{ item.cantidad}}</td>
                                        <td>@{{ item.unidad}}</td>
                                        <td></td>
                                        <td>@{{ item.item_ext.observaciones}}</td>
                                        <td>
                                            <button class="btn-xs btn-danger" type="button" @click="confirm_remove_item(item)"><i class="fa fa-remove"></i> </button>
                                            <button class="btn-xs btn-info" type="button" @click="show_edit_item(item)"><i class="fa fa-edit"></i> </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Agregar Item -->
                <div id="add_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addItemModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-lg">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_add_item"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Agregar Partida</h4>
                            </div>
                            <form id="form_add_item"  data-vv-scope="form_add_item" @submit.prevent="validateForm('form_add_item', 'save_item')" >
                            <div class="modal-body">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group" :class="{'has-error': validation_errors.has('form_add_item.Material')}">
                                              <label for="">Material</label>
                                              <select2 :name="'Material'" v-validate="'required'" v-model="form.item.id_material" :options="materiales_list" >
                                                  <option value disabled>[-SELECCIONE-]</option>
                                              </select2>
                                              <label class="help" v-show="validation_errors.has('form_add_item.Material')">@{{ validation_errors.first('form_add_item.Material') }}</label>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group" :class="{'has-error': validation_errors.has('form_add_item.Cantidad')}">
                                              <label for="">Cantidad</label>
                                              <input type="number" v-validate="'required|numeric|min_value:1'" class="form-control" name="Cantidad" v-model="form.item.cantidad"/>
                                              <label class="help" v-show="validation_errors.has('form_add_item.Cantidad')">@{{ validation_errors.first('form_add_item.Cantidad') }}</label>
                                          </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group" :class="{'has-error': validation_errors.has('form_add_item.Observaciones')}">
                                              <label for="">Observaciones</label>
                                              <textarea style="resize: none" v-validate="'required|max:1000'" class="form-control" name="Observaciones" v-model="form.item.observaciones"></textarea>
                                              <label class="help" v-show="validation_errors.has('form_add_item.Observaciones')">@{{ validation_errors.first('form_add_item.Observaciones') }}</label>
                                          </div>
                                      </div>

                                  </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" @click="close_add_item">Cerrar</button>
                                <button type="submit" class="btn btn-primary" >Guardar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="edit_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="EditItemModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-lg">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_add_item"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Editar Partida</h4>
                            </div>
                            <form id="form_edit_item"  data-vv-scope="form_edit_item"  @submit.prevent="validateForm('form_edit_item', 'edit_item')">
                                <div class="modal-body">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_item.Material')}">
                                                    <label for="">Material</label>
                                                    <select2 :name="'Material'" v-validate="'required'" v-model="form.item.id_material" :options="materiales_list" >
                                                        <option value disabled>[-SELECCIONE-]</option>
                                                    </select2>
                                                    <label class="help" v-show="validation_errors.has('form_edit_item.Material')">@{{ validation_errors.first('form_edit_item.Material') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_item.Cantidad')}">
                                                    <label for="">Cantidad</label>
                                                    <input type="number" v-validate="'required|numeric|min_value:1'" class="form-control" name="Cantidad" v-model="form.item.cantidad"/>
                                                    <label class="help" v-show="validation_errors.has('form_edit_item.Cantidad')">@{{ validation_errors.first('form_edit_item.Cantidad') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_edit_item.Observaciones')}">
                                                    <label for="">Observaciones</label>
                                                    <textarea style="resize: none" v-validate="'required|max:1000'" class="form-control" name="Observaciones" v-model="form.item.observaciones"></textarea>
                                                    <label class="help" v-show="validation_errors.has('form_edit_item.Observaciones')">@{{ validation_errors.first('form_add_item.Observaciones') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" @click="close_add_item">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" >Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
       </requisicion-edit>
    </div>

@endsection