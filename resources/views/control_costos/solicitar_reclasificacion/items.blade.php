@extends('control_costos.layout')
@section('title', 'Solicitar Reclasificación - Items')
@section('contentheader_title', 'SOLICITAR RECLASIFICACIÓN - ITEMS')
@section('main-content')
    {!! Breadcrumbs::render('control_costos.solicitar_reclasificacion.index') !!}

<global-errors></global-errors>
<solicitar_reclasificacion-items
        :url_solicitar_reclasificacion_index="'{{ route('control_costos.solicitar_reclasificacion.index') }}'"
        :items="{{ $data_view['items']  }}"
        :id_transaccion="{{ $data_view['id_transaccion']  }}"
        :id_concepto_antiguo="{{ $data_view['id_concepto']  }}"
        :filtros="[]"
        :max_niveles="{{ $data_view['max_niveles']  }}"
        :operadores="{{ json_encode($data_view['operadores'])  }}"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-9">
                &nbsp;<h4>{{ $data_view['transaccion']['descripcion'] }}  {{ $data_view['transaccion']['fecha']->format('Y/m/d')  }} Folio #{{ $data_view['transaccion']['numero_folio']  }}</h4>
            </div>
            <div class="col-md-3">
                <a href="{{ route('control_costos.solicitar_reclasificacion.index') }}" class="btn btn-sm btn-primary pull-right">Solicitar otra clasificación</a>
            </div>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Items</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Importe</th>
                                    <th>Destino Inicio</th>
                                    <th>Destino Final</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in data.items" :class="'items item_' + index +' '+ (item.selected != undefined ? item.selected : '')">
                                    <td>@{{ item.observaciones }}</td>
                                    <td class="text-right">@{{ parseInt(item.cantidad) }}</td>
                                    <td class="text-right">@{{  item.precio_unitario }}</td>
                                    <td class="text-right">@{{  parseInt(item.importe).formatMoney(2, '.', ',') }}</td>
                                    <td><a href="#" v-on:click="open_modal_agregar(item, index)">@{{  item.descripcion }}</a></td>
                                    <td class="destino_final">@{{  item.destino_final }}</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                  <label><b>Motivo</b></label>
                  <textarea class="form-control" rows="3" placeholder="Especifica un motivo" id="Motivo" value="" name="Motivo" v-model="data.motivo"></textarea>

              </div>
            <button class="btn btn-sm btn-primary pull-right" v-on:click="confirm_solicitar()">Solicitar</button>
            <br><br>
             </div>
        </div>
        <div id="agregar_filtro_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AgregarModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document" style="width: 70% !important;">
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
                                        <option v-for="(item, index) in niveles" :value="item.nombre">@{{item.nombre}}</option>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><b>Texto</b></label>
                                    <input type="text" class="form-control pull-right" id="Texto" value="" name="Texto" v-model="data.agrega.texto">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label><b>Agregar</b></label>
                                    <button type="submit" class="btn btn-primary" v-on:click="agregar_filtro()">Agregar</button>
                                </div>
                            </div>

                        </div>
                        <div class="row" v-if="data.filtros.length > 0">
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
                                                        <th v-for="item of niveles_n">
                                                            Nivel @{{  item }}
                                                        </th>
                                                        <th class="text-right">Aplicar a item</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(item, index) in data.resultados">
                                                        <td v-for="i in niveles">
                                                            @{{ item['filtro' + i.numero] }}
                                                        </td>
                                                        <td><a href="#" v-on:click="aplicar(item)">Aplicar</a></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="close_modal_agregar()">Cerrar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </section>
</solicitar_reclasificacion-items>

@endsection

