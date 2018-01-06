@extends('control_costos.layout')
@section('title', 'Solicitar Reclasificación')
@section('contentheader_title', 'SOLICITAR RECLASIFICACIÓN')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_costos.solicitar_reclasificacion.index') !!}
@endsection
@section('main-content')

<global-errors></global-errors>
<solicitar_reclasificacion-index
        :url_solicitar_reclasificacion_index="'{{ route('control_costos.solicitar_reclasificacion.index') }}'"
        :max_niveles="{{ $data_view['max_niveles']  }}"
        :operadores="{{ json_encode($data_view['operadores'])  }}"
        :filtros="[]"
        :tipos_transacciones="{{ $data_view['tipos_transacciones']  }}"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <div class="btn-group ">
                        <button class="btn btn-sm btn-primary pull-right" v-on:click="open_modal_agregar()">Agregar Filtro</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary pull-right" v-on:click="open_modal_transaccion()">Filtrar por Transacción</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div id="transaccion_filtro_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TransaccionModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" v-on:click="close_modal_transaccion()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Filtro Transacción</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {{--Tipo Transaccion--}}
                            <div class="col-md-5">
                                    <div class="form-group">
                                        <label><b>Tipo Transacción</b></label>
                                        <Select class="form-control" name="tipo_transaccion" id="tipo_transaccion" v-model="data.filtro_tran.tipo">
                                            <option value>[--SELECCIONE--]</option>
                                            <option v-for="(item, index) in tipos_transacciones" :value="item.tipo_transaccion +'-'+ item.opciones">@{{item.descripcion}}</option>
                                        </Select>
                                    </div>
                            </div>
                            {{--Folio--}}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b>Folio</b></label>
                                    <input type="text" class="form-control pull-right" id="Folio" value="" name="Folio" v-model="data.filtro_tran.folio">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="close_modal_transaccion()">Cerrar</button>
                        <button type="submit" class="btn btn-primary" v-on:click="agregar_filtro_tran()">Buscar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                        <h4 class="text-right">Total: @{{ data.total_resultados }}</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th v-for="item of niveles_n">
                                        Nivel @{{  item }}
                                    </th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in data.resultados">
                                    <td >@{{ index + 1  }}</td>
                                    <td v-for="i in niveles">
                                        @{{ item['filtro' + i.numero] }}
                                    </td>
                                    <td><a style="cursor:pointer;" v-on:click="open_modal_tipos_transaccion(item.id_concepto)">@{{  parseInt(item.total).formatMoney(2, '.', ',') }}</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </template>
        <div id="tipos_transaccion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AgregarModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tipos Transacciones</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-if="data.desglosar.length == 0">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tipo Transacción</th>
                                                <th>
                                                    Cantidad
                                                </th>
                                                <th>Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.resumen">
                                            <td >@{{ item.descripcion  }}</td>
                                            <td class="text-right">
                                                @{{ parseInt(item.cantidad) }}
                                            </td>
                                            <td class="text-right">
                                                <a style="cursor:pointer;" v-on:click="desglosar_tipos(item.descripcion, item.opciones)">@{{ parseInt(item.monto).formatMoney(2, '.', ',') }}</a>
                                            </td>
                                        </tr>
                                        <tfoot style="border-top: 2px solid #00a65a;">
                                            <tr>
                                                <td><b>Subtotal:</b></td>
                                                <td class="text-right"><b>@{{ parseInt(data.subtotal) }}</b></td>
                                                <td class="text-right"><a href="#" v-on:click="desglosar_tipos(false, false)"><b>@{{ parseInt(data.subimporte).formatMoney(2, '.', ',') }}</b></a></td>
                                            </tr>
                                        </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">@{{ !data.desglosar_descripcion ? 'Subtotal' : data.desglosar_descripcion }}</h3>
                                        <button type="button" class="close" v-on:click="clean_desglosar()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Tipo transacción</th>
                                                    <th >Fecha</th>
                                                    <th>Folio</th>
                                                    <th>Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(item, index) in data.desglosar">
                                                    <td >@{{ item.descripcion  }}</td>
                                                    <td > @{{ new Date(item.fecha).dateShortFormat() }}</td>
                                                    <td class="text-right"> @{{ item.numero_folio }}</td>
                                                    <td class="text-right"><a href="#" v-on:click="mostrar_items(item.id_transaccion, item.id_concepto)">@{{ parseInt(item.monto).formatMoney(2, '.', ',') }}</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="close_modal_tipos_transaccion()">Cerrar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </section>
</solicitar_reclasificacion-index>

@endsection

