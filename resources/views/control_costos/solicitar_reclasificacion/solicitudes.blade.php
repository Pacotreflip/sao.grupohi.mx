@extends('control_costos.layout')
@section('title', 'Solicitudes de Reclasificación')
@section('contentheader_title', 'SOLICITUDES DE RECLASIFICACIÓN')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_costos.solicitudes_reclasificacion.index') !!}
@endsection
@section('main-content')

<global-errors></global-errors>
<solicitar_reclasificacion-index
        :url_solicitar_reclasificacion_index="'{{ route('control_costos.solicitudes_reclasificacion.index') }}'"
        :max_niveles="{{ $data_view['max_niveles']  }}"
        :operadores="{{ json_encode($data_view['operadores'])  }}"
        :filtros="[]"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-sm btn-primary pull-right" v-on:click="open_modal_agregar()">Agregar Filtro</button>
            </div>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div id="agregar_filtro_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AgregarModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" v-on:click="close_modal_agregar()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 v-if="data.condicionante">@{{data.temp_filtro.nivel}} @{{ data.temp_filtro.operador}} @{{ data.temp_filtro.texto}} <b>@{{data.condicionante}}</b> </h5>
                        <h4 v-else class="modal-title">Agregar Filtro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{--Nivel--}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Nivel</b></label>
                                    <Select class="form-control" name="nivel" id="nivel" v-model="data.agrega.nivel">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="(item, index) in getMaxNiveles()" :value="item.nombre">@{{item.nombre}}</option>
                                    </Select>
                                </div>
                            </div>
                            {{--Operador--}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Operador</b></label>
                                    <Select class="form-control" name="operador" id="operador" v-model="data.agrega.operador">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="(item, index) in data.operadores" :value="index">@{{index}}</option>
                                    </Select>
                                </div>
                            </div>
                            {{--Texto--}}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b>Texto</b></label>
                                    <input type="text" class="form-control pull-right" id="Texto" value="" name="Texto" v-model="data.agrega.texto">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="close_modal_agregar()">Cerrar</button>
                        <button type="submit" class="btn btn-primary" v-on:click="agregar_filtro()">Agregar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filtros Agregados</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nivel</th>
                                    <th>Operador</th>
                                    <th>Texto</th>
                                    <th width="150">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in data.filtros">
                                        <td >@{{ index + 1  }}</td>
                                        <td>@{{ item.nivel }}</td>
                                        <td>@{{  item.operador }}</td>
                                        <td>@{{  item.texto }}</td>
                                        <td>
                                            {{--<div class="btn-group">--}}
                                                {{--<button type="button" class="btn btn-xs btn-success" v-on:click="open_modal_agregar('Y', item)" title="concatena un nuevo filtro">Agregar filtro </button>--}}
                                            {{--</div>--}}
                                            <div class="btn-group">
                                                <button type="button" title="Eliminar" class="btn btn-xs btn-danger" v-on:click="confirm_eliminar(index, 'filtro')"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <h5 v-if="item.condicionante">@{{ item.condicionante  }}</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-sm btn-primary pull-right" v-on:click="buscar()">Buscar</button>
                <br><br>
            </div>
        </div>
        <template v-if="data.resultados.length != 0">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultados</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nivel</th>
                                    <th>Descripción</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in data.resultados">
                                    <td >@{{ index + 1  }}</td>
                                    <td>@{{ item.nivel }}</td>
                                    <td>@{{  item.descripcion }}</td>
                                    <td>@{{  item.total }}</td>
                                    <td class="btn-group">
                                        <button type="button" title="Solicitar Reclasificación" class="btn btn-xs btn-success" v-on:click="confirm_solicitar(item)" v-if="!item.solicitado"><i class="fa fa-file-text-o"></i></button>
                                        <button type="button" title="Eliminar" class="btn btn-xs btn-danger" v-on:click="confirm_eliminar(index, 'resultado')"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </template>
    </section>
</solicitar_reclasificacion-index>

@endsection

