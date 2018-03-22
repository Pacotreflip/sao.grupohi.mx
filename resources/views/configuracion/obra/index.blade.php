@extends('configuracion.layout')
@section('title', 'Configuración del Presupuesto')
@section('contentheader_title', 'CONFIGURACIÓN DE LA OBRA')
@section('breadcrumb')
    {!! Breadcrumbs::render('configuracion.presupuesto.index') !!}
@endsection
@section('main-content')
    <configuracion-presupuesto-index inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Configuración de Logotipo de la obra
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="filtros_nivel">
                                    <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Columns</th>
                                        <th>Descprion</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Order</th>
                                        <th>Columns</th>
                                        <th>Descprion</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal de Asignacion de Roles en Módulo de Seguridad -->
            <div class="modal fade" id="config_edit" tabindex="-1" config="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog  modal-lg" config="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Editar configuracion</h4>
                        </div>
                        <form id="form_update_config" @submit.prevent="validateForm('form_update_config', 'update_config')"  data-vv-scope="form_update_config">
                            <input type="hidden" :name="'id_config'" id="id_config"  v-model="id_config">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group" >
                                            <label><b>Filtro</b></label>
                                            <input type="text" :name="'name_column'" id="name_column" class="form-control input-sm" v-model="name_column" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_update_config.description')}">
                                            <label><b>Descripción</b></label>
                                            <input type="text" :name="'description'" v-validate="'required'" class="form-control input-sm" v-model="description">
                                            <label class="help" v-show="validation_errors.has('form_update_config.description')">@{{ validation_errors.first('form_update_config.description') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cerrar</button>
                                <button type="submit" :disabled="guardando" class="btn btn-primary">
                                <span v-if="guardando">
                                    <i class="fa fa-spin fa-spinner"></i> Guardando
                                </span>
                                    <span v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </configuracion-presupuesto-index>
@endsection