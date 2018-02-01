@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'SOICITUD DE CAMBIO AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-presupuesto-create
            inline-template
            v-cloak
            :operadores="{{ json_encode($operadores) }}"
    >
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Información de la Solicitud
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Cobrabilidad:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_cobrabilidad" @change="form.id_tipo_orden = ''" :disabled="!tipos_cobrabilidad.length">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_cobrabilidad in tipos_cobrabilidad" :value="tipo_cobrabilidad.id">@{{ tipo_cobrabilidad.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Tipo de Solicitud:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_orden" :disabled="!tipos_orden_filtered.length" v-on:change="obtenerPresupuestos">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_orden in tipos_orden_filtered" :value="tipo_orden.id">@{{ tipo_orden.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" v-if="form.id_tipo_orden != ''">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros para consulta de Conceptos</h3>
                            <div class="box-tools">
                                <button v-if="form.id_tipo_orden != 4" type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#agregar_filtro_modal" @click="validation_errors.clear('form_add_filtro')">Agregar Filtro</button>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><b>Número de Tarjeta</b></label>
                                    <select2 :disabled="cargando" v-model="form.id_tarjeta" :options="tarjetas">
                                    </select2>
                                </div>
                            </div>
                            <div v-if="form.id_tipo_orden != 4">
                                <table class="table table-bordered table-striped" v-if="filtros.length">
                                    <thead>
                                    <tr>
                                        <th>Nivel</th>
                                        <th>Operador</th>
                                        <th>Texto</th>
                                        <th>Eliminar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="filtro in filtros">
                                        <tr v-for="operador in filtro.operadores">
                                            <td>Nivel @{{ filtro.nivel }}</td>
                                            <td>@{{ operador.operador }}</td>
                                            <td>@{{ operador.texto }}</td>
                                            <td>
                                                <button class="btn btn-xs btn-danger" @click="eliminar(filtro, operador)"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                                <div class="text-center" v-else>Ningún filtro aplicado</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="agregar_filtro_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AgregarModal" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Agregar Filtro</h4>
                        </div>
                        <form id="form_add_filtro" @submit.prevent="validateForm('form_add_filtro', 'add_filtro')"  data-vv-scope="form_add_filtro">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_add_filtro.Nivel')}">
                                            <label for="nivel"><b>Nivel</b></label>
                                            <select id="nivel" class="form-control input-sm" v-model="form.filtro.nivel" v-validate="'required'" :name="'Nivel'">
                                                <option value disabled>[--SELECCIONE--]</option>
                                                <option v-for="nivel in niveles" :value="nivel.numero">@{{ nivel.nombre }}</option>
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_add_filtro.Nivel')">@{{ validation_errors.first('form_add_filtro.Nivel') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_add_filtro.Operador')}">
                                            <label for="operador"><b>Operador</b></label>
                                            <select class="form-control input-sm" id="operador" v-model="form.filtro.operador" v-validate="'required'" :name="'Operador'">
                                                <option value disabled>[--SELECCIONE--]</option>
                                                <option v-for="(key, operador) in operadores" :value="operador">@{{ key }}</option>
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_add_filtro.Operador')">@{{ validation_errors.first('form_add_filtro.Operador') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_add_filtro.Texto')}">
                                            <label for="texto"><b>Texto</b></label>
                                            <input type="text" class="form-control input-sm" id="texto" v-model="form.filtro.texto" v-validate="'required'" :name="'Texto'">
                                            <label class="help" v-show="validation_errors.has('form_add_filtro.Texto')">@{{ validation_errors.first('form_add_filtro.Texto') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Agregar Filtro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('control_presupuesto.cambio_presupuesto.variacion_volumen')
        </section>
    </cambio-presupuesto-create>
@endsection

