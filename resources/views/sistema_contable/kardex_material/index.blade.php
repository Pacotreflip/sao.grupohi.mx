@extends('sistema_contable.layout')
@section('title', 'Kardex de Materiales')
@section('contentheader_title', 'KARDEX DE MATERIALES')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.kardex_material.index') !!}
    <global-errors></global-errors>
    <kardex-material-index
            v-cloak
            inline-template>
        <section>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-10">
                        <select2 class="form-control"  v-model="valor" id="material_select" v-select2>
                            <option value="-1">[--SELECCIONE--]</option>
                            <option v-for="(material, index) in materiales" :value="index" style="text-anchor: @parent">@{{ material.descripcion }}</option>
                        </select2>
                    </div>
                    <div class="col-xs-2">
                        <button :disabled="cargando" class="btn btn-success btn-block" @click="datos">
                            <span v-if="cargando">
                                <i class="fa fa-spin fa-spinner"></i>
                                Buscando...
                            </span>
                            <span v-else>
                                <i class="fa fa-search"></i>
                                Buscar
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" v-if="form.material.id_material">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Información del Material</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong>Descripción</strong>
                            <p class="text-muted">@{{form.material.descripcion}}</p>
                            <hr>
                            <strong>Registró</strong>
                            <p class="text-muted">@{{form.material.usuario_registro}}</p>
                            <hr>
                            <strong>Unidad de Medida</strong>
                            <p class="text-muted">@{{form.material.unidad}}</p>
                            <hr>
                            <strong>Familia</strong>
                            <p class="text-muted">@{{form.material.d_padre}}</p>
                            <hr>
                            <strong>Existencia</strong>
                            <p>@{{ form.totales.existencia }}</p>
                            <hr>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <div class="col-md-9" v-if="form.material.id_material">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Transacciones de Entrada y Salida</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th colspan="2" class="text-center">Entrada</th>
                                        <th colspan="2" class="text-center">Salida</th>
                                        <th colspan="2" class="text-center">Saldos</th>

                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha y Hora de la Transacción</th>
                                        <th>Transacción</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in data.items">
                                        <td>@{{ index +1  }}</td>
                                        <td>@{{ (new Date(item.transaccion.FechaHoraRegistro)).dateFormat() }}</td>
                                        <td>@{{ item.id_transaccion }}</td>
                                        <td v-if="item.transaccion.tipo_transaccion == 33" style="text-align: right"> @{{ parseFloat(item.cantidad) }}</td>
                                        <td v-else ></td>
                                        <td v-if="item.transaccion.tipo_transaccion == 33" style="text-align: right"> $@{{ parseFloat(item.precio_unitario ).formatMoney(2,'.',',')}}</td>
                                        <td v-else ></td>
                                        <td v-if="item.transaccion.tipo_transaccion == 34" style="text-align: right" >@{{ parseFloat(item.cantidad)}}</td>
                                        <td v-else ></td>
                                        <td v-if="item.transaccion.tipo_transaccion == 34" style="text-align: right" >$@{{parseFloat(item.precio_unitario).formatMoney(2,'.',',')}}</td>
                                        <td v-else ></td>
                                        <td style="text-align: right" >@{{ parseFloat(item.cantidad)}}</td>
                                        <td style="text-align: right" >$@{{ (item.cantidad * item.precio_unitario ).formatMoney(2,'.',',')}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-center"><strong>TOTALES</strong></th>
                                        <th style="text-align: right">@{{ form.totales.entrada_material}}</th>
                                        <th style="text-align: right">$@{{ parseFloat(form.totales.entrada_valor).formatMoney(2,'.',',')}}</th>
                                        <th style="text-align: right">@{{ form.totales.salida_material}}</th>
                                        <th style="text-align: right">$@{{ parseFloat(form.totales.salida_valor).formatMoney(2,'.',',')}}</th>
                                        <th style="text-align: right">@{{ form.totales.entrada_material - form.totales.salida_material }}</th>
                                        <th style="text-align: right">$@{{(parseFloat(form.totales.entrada_valor)- parseFloat(form.totales.salida_valor)).formatMoney(2,'.',',')}}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </kardex-material-index>
@endsection
