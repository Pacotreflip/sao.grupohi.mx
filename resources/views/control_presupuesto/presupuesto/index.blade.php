@extends('control_costos.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.presupuesto.index') !!}
@endsection
@section('main-content')

<global-errors></global-errors>
<control_presupuesto-index
        :max_niveles="{{ $max_niveles  }}"
        :operadores="{{ json_encode($operadores) }}"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#agregar_filtro_modal">Agregar Filtro</button>
            </div>
            <hr>
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
                    <div class="box-footer">
                        <button type="button" class="btn btn-primary btn-sm" @click="get_conceptos()" :disabled="cargando">
                            <span v-if="cargando">
                                <i class="fa fa-spinner fa-spin"></i> Consultando
                            </span>
                            <span v-else>
                                <i class="fa fa-search"></i> Consultar
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultados</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="conceptos_table" class="small table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th v-for="nivel in niveles">
                                        Nivel @{{ nivel.numero }}
                                    </th>
                                    <th>Unidad</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Monto</th>
                                    <th>Monto Presupuestado</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th v-for="nivel in niveles">
                                        Nivel @{{ nivel.numero }}
                                    </th>
                                    <th>Unidad</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Monto</th>
                                    <th>Monto Presupuestado</th>
                                </tr>
                                </tfoot>
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
    </section>
</control_presupuesto-index>

@endsection

