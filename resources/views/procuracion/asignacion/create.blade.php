@extends('procuracion.layout')
@section('title', 'Asignaciones')
@section('contentheader_title', 'ASIGNACIÓN DE COMPRADORES')
@section('breadcrumb')
    {!! Breadcrumbs::render('procuracion.asignacion.index') !!}
@endsection
@section('main-content')
    <global-errors></global-errors>
    <procuracion-asignacion-create
            :url_success="'{{ route('procuracion.asignacion.index') }}'"
            inline-template
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <form id="form_agregar_asignacion"
                              @submit.prevent="validateForm('form_agregar_asignacion', 'agregar_asignacion')"
                              data-vv-scope="form_agregar_asignacion">
                            <div class="box-header with-border">
                                <h3 class="box-title">Formulario de Asginación</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_agregar_asignacion.tipo_transaccion')}">
                                        <label><strong>Tipo de Transacción</strong></label>
                                        <select class="form-control input-sm" name="tipo_transaccion"
                                                v-model="form.tipo_transaccion"  v-validate="'required'"
                                                id="tipo_transaccion">
                                            <option value>[--SELECCIONE--]</option>
                                        </select>
                                        <label class="help" v-show="validation_errors.has('form_agregar_asignacion.tipo_transaccion')">Seleccion un Tipo de Transacción</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_agregar_asignacion.id_transaccion')}" >
                                        <label><strong>Transacción</strong></label>
                                        <select class="form-control input-sm" name="id_transaccion"
                                                v-model="form.id_transaccion"  v-validate="'required'"
                                                id="id_transaccion"
                                                :disabled="cargando_transacciones || !form.tipo_transaccion.length"
                                        >
                                            <option value>[--SELECCIONE--]
                                            </option>
                                        </select>
                                        <label class="help" v-show="validation_errors.has('form_agregar_asignacion.id_transaccion')">Seleccion una Transacción</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_agregar_asignacion.id_usuario_asignado')}" >
                                        <label><strong>Comprador(es)</strong></label>
                                        <select class="form-control input-sm" name="id_usuario_asignado[]"
                                                v-model="form.id_usuario_asignado"  v-validate="'required'"
                                                id="id_usuario_asignado"
                                                :disabled="!form.id_transaccion"
                                        >
                                        </select>
                                        <label class="help" v-show="validation_errors.has('form_agregar_asignacion.id_usuario_asignado')">Seleccion un(os) Comprador(es)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" :disabled="!form.id_usuario_asignado.length">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row" v-show="mostrartable">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Listado de Asiganciones agregadas</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="table_asignacion">
                                    <thead>
                                    <tr>
                                        <th>Tipo de Transacción</th>
                                        <th>Número de Folio de la Transacciones</th>
                                        <th>Concepto</th>
                                        <th>Comprador Asignado</th>
                                        <th width="150">Remover</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-sm btn-primary pull-right" id="guardar_asiognacion" v-on:click="confirm_guardar('guardar_asiognacion')">Guardar</button>
                </div>
                <div class="col-md-12">

                </div>
            </div>
        </section>
    </procuracion-asignacion-create>
@endsection