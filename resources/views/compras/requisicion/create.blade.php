@extends('compras.layout')
@section('title', 'Requisiciones')
@section('contentheader_title', 'REQUISICIONES')

@section('main-content')
    {!! Breadcrumbs::render('compras.requisicion.create') !!}

    <div id="app">
        <global-errors></global-errors>
        <requisicion-create
                :tipos_requisiciones="{{$tipos_requisiciones}}"
                :departamentos_responsables="{{$departamentos_responsables}}"
                :url_requisicion="'{{route('compras.requisicion.index')}}'"
                v-cloak inline-template>
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h1 class="box-title">Datos de la Requisición</h1>
                    </div>
                    <form id="form_requisicion_save" @submit.prevent="validateForm('form_requisicion_save', 'save')"  data-vv-scope="form_requisicion_save">
                    <div class="box-body">
                        <div class="row">
                            <!-- Departamento Responsable -->
                            <div class="col-md-6">
                                <div class="form-group" :class="{'has-error': validation_errors.has('form_requisicion_save.Departamento Responsable') }">
                                    <label for="id_departamento" class="control-label"><b>Departamento Responsable</b></label>
                                    <select v-validate="'required'" class="form-control" name="Departamento Responsable" id="id_departamento" v-model="form.id_departamento">
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
                                    <select v-validate="'required'" class="form-control" name="Tipo de Requisición" id="id_tipo_requisicion" v-model="form.id_tipo_requisicion">
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
                                    <textarea v-validate="'required'" maxlength="1000" name="Observaciones" class="form-control" style="resize: none" v-model="form.observaciones"></textarea>
                                    <label class="help" v-show="validation_errors.has('form_requisicion_save.Observaciones')">@{{ validation_errors.first('form_requisicion_save.Observaciones') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right" :disabled="guardando">
                            <span v-if="guardando">
                                Guardando <i class="fa fa-spin fa-spinner"></i>
                            </span>
                            <span v-else>
                                Guardar <i class="fa fa-save"></i>
                            </span>
                        </button>
                    </div>
                    </form>
                </div>
            </section>
        </requisicion-create>
    </div>

@endsection