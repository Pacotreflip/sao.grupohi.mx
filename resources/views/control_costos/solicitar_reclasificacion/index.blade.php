@extends('control_costos.layout')
@section('title', 'Solicitar Reclasificación')
@section('contentheader_title', 'SOLICITAR RECLASIFICACIÓN')
@section('main-content')
    {!! Breadcrumbs::render('control_costos.solicitar_reclasificacion.index') !!}

<global-errors></global-errors>
<solicitar_reclasificacion-index
        :url_solicitar_reclasificacion_index="'{{ route('control_costos.solicitar_reclasificacion.index') }}'"
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
                        <h4 class="modal-title">Agregar Filtro</h4>
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
                                    <tr v-for="(item, index) in filtros">
                                        <td >@{{ index + 1  }}</td>
                                        <td>@{{ item.nivel }}</td>
                                        <td>@{{  item.operador }}</td>
                                        <td>@{{  item.texto }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" title="Eliminar" class="btn btn-xs btn-danger" v-on:click="eliminar_filtro(item)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-sm btn-primary pull-right" v-on:click="buscar()">Buscar</button>
            </div>
        </div>
        <div class="row" v-if="data.resultados.length != 0">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reclasificaciones</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo Transaccion</th>
                                <th>Cantidad</th>
                                <th>Costo Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in transacciones">
                                <td >@{{ index + 1  }}</td>
                                <td>@{{ item.nivel }}</td>
                                <td>@{{  item.operador }}</td>
                                <td>@{{  item.texto }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</solicitar_reclasificacion-index>

@endsection

