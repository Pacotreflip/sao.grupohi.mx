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
        :solicitar_reclasificacion="{{ \Entrust::can(['solicitar_reclasificacion']) ? 'true' : 'false' }}"
        :consultar_reclasificacion="{{ \Entrust::can(['consultar_reclasificacion']) ? 'true' : 'false' }}"
        :autorizar_reclasificacion="{{ \Entrust::can(['autorizar_reclasificacion']) ? 'true' : 'false' }}"
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
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-left">Items</h3>
                        <form class="form-inline">
                            <div class="input-group pull-right">
                                <span class="input-group-addon">Fecha</span>
                                <input type="text" name="Fecha" class="form-control" id="Fecha"
                                       v-model="data.fecha"
                                       v-datepicker>
                            </div>
                        </form>
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
                                    <td class="text-right">$@{{  parseInt(item.precio_unitario).formatMoney(2, '.', ',') }}</td>
                                    <td class="text-right">$@{{  parseInt(item.importe).formatMoney(2, '.', ',') }}</td>
                                    <td>
                                        <a href="#" v-on:click="open_modal_agregar(item, index)" :title="item.concepto.path" v-if="consultar_reclasificacion">[@{{  item.concepto.clave }}] @{{ item.concepto.descripcion }}</a>
                                        <span v-else>[@{{  item.concepto.clave }}] @{{ item.concepto.descripcion }}</span>
                                    </td>
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
            <button class="btn btn-sm btn-primary pull-right" v-on:click="confirm_solicitar()" v-if="solicitar_reclasificacion">Solicitar</button>
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
                                                        <th>Aplicar a item</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(item, index) in data.resultados">
                                                        <td v-for="i in niveles" v-if="i.numero <= niveles_n">
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
        <div id="solicitud_detalles_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="DetallesModal" data-backdrop="static" data-keyboard="false" >
            <div class="modal-dialog modal-lg" role="document" style="width: 70% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Detalles
                            <small class="text-muted"> #@{{ data.solicitud.id }} @{{ new Date(data.solicitud.fecha ? data.solicitud.fecha : data.solicitud.created_at).dateShortFormat() }} Estatus: @{{ data.solicitud.estatus_desc }}</small>
                        </h4>
                    </div>
                    <div class="modal-body show_pdf" v-if="data.show_pdf">
                        <iframe :src="data.show_pdf"  frameborder="0" height="600px" width="99.6%">d</iframe>
                    </div>
                    <div class="modal-body" v-else>
                        <div class="row" v-if="!data.rechazando">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Tipo Transacción</th>
                                            <th>Folio</th>
                                            <th>Item</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                            <th>Costo Origen</th>
                                            <th>Costo Destino</th>
                                            <template v-if="data.editando">
                                                <th>Fecha</th>
                                                <th>Creado por</th>
                                            </template>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.solicitud.partidas">
                                            <td>@{{ item.item.transaccion.tipo_transaccion_string != undefined ? item.item.transaccion.tipo_transaccion_string : '-' }}</td>
                                            <td>#@{{ item.item.transaccion.numero_folio }}</td>
                                            <td >@{{ (item.item.transaccion.tipo_tran.Tipo_Transaccion == 52 ? item.item.contrato.descripcion :  item.item.material.descripcion) }}</td>
                                            <td class="text-right">@{{ item.item.cantidad }}</td>
                                            <td class="text-right">@{{  parseInt(item.item.importe).formatMoney(2, '.', ',') }}</td>
                                            <td ><span :title="item.concepto_original.path">[@{{ item.concepto_original.clave  }}] @{{ item.concepto_original.descripcion }}</span></td>
                                            <td ><span :title="item.concepto_nuevo.path">[@{{ item.concepto_nuevo.clave  }}] @{{ item.concepto_nuevo.descripcion }}</span></td>
                                            <template v-if="data.editando">
                                                <td>@{{  new Date(data.editando.created_at).dateShortFormat() }}</td>
                                                <td>@{{ data.editando.usuario.nombre +' '+ data.editando.usuario.apaterno }}</td>
                                            </template>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="box box-default box-solid" v-if="!data.editando">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Motivo</h3>
                                        </div>
                                        <div class="box-body">
                                            @{{ html_decode(data.solicitud.motivo) }}
                                        </div>
                                    </div>
                                    <div class="col-md-12" v-if="!data.editando">
                                        <div class="pull-right">
                                            <button type='button' title='Formato' class='btn btn-success' v-on:click="allow_editar()" v-if="autorizar_reclasificacion"><i class='fa fa-pencil'>  Editar</i></button>
                                            <button type='button' title='Formato' class='btn btn-info btn_pdf' v-on:click="pdf(data.solicitud.id)"><i class='fa fa-file-pdf-o'>  Formato</i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <template v-if="data.editando">
                                <div class="col-md-12">
                                    <div class="box box-default box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Motivo</h3>
                                        </div>
                                        <div class="box-body">
                                            @{{ html_decode(data.editando.motivo) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <i class="fa fa-thumbs-up"></i>
                                            <h3 class="box-title">Aprobaciones pendientes:</h3>
                                        </div>
                                        <div class="box-body">
                                            <ul class="list-unstyled">
                                                <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <button type='button' title='Formato' class='btn btn-info btn_pdf' v-on:click="pdf(data.solicitud.id)"><i class='fa fa-file-pdf-o'> Formato</i></button>
                                        <button type="button" class="btn btn-success" v-on:click="confirm('aprobar')" v-if="autorizar_reclasificacion"> <i class="fa fa-fw fa-thumbs-up"></i>Aprobar</button>
                                        <button type="button" class="btn btn-danger" v-on:click="rechazar_motivo()" v-if="autorizar_reclasificacion"> <i class="fa fa-fw fa-trash"></i> Rechazar</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="row" v-else>
                            <div class="col-md-12">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Indique el motivo del rechazo de la solicitud</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" placeholder="motivo..." v-model="data.rechazo_motivo"></textarea>
                                        </div>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-danger" v-on:click="confirm('rechazar')" v-if="autorizar_reclasificacion">Rechazar</button>
                                            <button type="button" class="btn btn-default" v-on:click="cancelar_rechazo()">Cancelar</button>
                                        </div>
                                        <div>
                                            El motivo será compartido con los demás responsables de aprobación
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="close_modal_detalles()">Cerrar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </section>
</solicitar_reclasificacion-items>

@endsection

