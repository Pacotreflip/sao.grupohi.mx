@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
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
                <input name="search" type="button" class="form-control input-sm   btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#agregar_filtro_modal" value="Agregar Filtro" ></input>

                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Tipo de Orden de Cambio
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Cobrabilidad:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_cobrabilidad" v-on:change="form.id_tipo_orden = ''">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_cobrabilidad in tipos_cobrabilidad" :value="tipo_cobrabilidad.id">@{{ tipo_cobrabilidad.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Tipo de Orden de Cambio:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_orden" v-on:change="">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_orden in tipos_orden_filtered" :value="tipo_orden.id">@{{ tipo_orden.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" v-if="filtros.length">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive" v-if="filtros.length">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nivel</th>
                                        <th>Operador</th>
                                        <th>Texto</th>
                                        <th>Acciones</th>
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
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nivel">Nivel</label>
                                        <select id="nivel" class="form-control input-sm" v-model="form.filtro.nivel">
                                            <option v-for="nivel in niveles" :value="nivel.numero">@{{ nivel.nombre }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="operador">Operador</label>
                                        <select class="form-control input-sm" id="operador" v-model="form.filtro.operador">
                                            <option v-for="(key, operador) in operadores" :value="operador">@{{ key }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="texto">Texto</label>
                                        <input type="text" class="form-control input-sm" id="texto" v-model="form.filtro.texto">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" @click="set_filtro()">Agregar Filtro</button>
                        </div>
                    </div>
                </div>
            </div>
            <variacion-volumen inline-template v-cloak v-if="form.id_tipo_orden == 4" :filtros="filtros" :niveles="niveles">
            <section>
                <button type="button" class="btn btn-primary btn-sm" @click="get_conceptos()" :disabled="cargando">
                            <span v-if="cargando">
                                <i class="fa fa-spinner fa-spin"></i> Consultando
                            </span>
                    <span v-else>
                                <i class="fa fa-search"></i> Consultar
                            </span>
                </button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Conceptos</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="conceptos_table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th v-for="nivel in niveles">@{{ nivel.nombre }}</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Monto</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th v-for="nivel in niveles">@{{ nivel.nombre }}</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Monto</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </
            </section>
            </variacion-volumen>
        </section>
    </cambio-presupuesto-create>
@endsection

