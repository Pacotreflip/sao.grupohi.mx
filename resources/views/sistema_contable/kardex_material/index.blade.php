@extends('sistema_contable.layout')
@section('title', 'Kardex de Materiales')
@section('contentheader_title', 'KARDEX DE MATERIALES')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.kardex_material.index') !!}

    <hr xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div id="app">
        <global-errors></global-errors>
        <kardex-material-index
                :materiales="{{$materiales}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Kardex de Material</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>SELECCIONAR MATERIAL</th>
                                        <td>
                                            <select class="form-control input-sm" style="width: 40%" v-model="valor" @change="datos()">
                                                <option value="-1">[-SELECCIONE-]</option>
                                                <option v-for="(material, index) in materiales" :value="index">@{{ material.id_material }} - @{{ material.descripcion }}</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>UNIDAD DE MEDIDA</th>
                                        <td>@{{form.material.unidad}}</td>
                                    </tr>
                                    <tr>
                                        <th>FAMILIA</th>
                                        <td>@{{form.material.d_padre}}</td>
                                    </tr>
                                    <tr>
                                        <th>EXISTENCIA</th>
                                        <td>@{{ form.totales.existencia }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="valor > -1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Detalle de Kardex Material</h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table  class="table table-bordered table-striped">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Fecha/Hora</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Transacción</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">ENTRADA<br>Cantidad / Precio</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">SALIDA<br>Cantidad / Precio</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">SALDOS<br>Cantidad / Precio</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in data.items">
                                                <td>@{{ index }}</td>
                                                <td>@{{ (new Date(item.transaccion.FechaHoraRegistro)).dateFormat() }}</td>
                                                <td>@{{ item.id_transaccion }}</td>
                                                <td v-if="item.transaccion.tipo_transaccion == 33">@{{ parseFloat(item.cantidad) }} / @{{ parseFloat(item.precio_unitario )}}</td>
                                                <td v-else ></td>
                                                <td v-if="item.transaccion.tipo_transaccion == 34">@{{ parseFloat(item.cantidad) }} / @{{ parseFloat(item.precio_unitario ) }}</td>
                                                <td v-else ></td>
                                                <td>@{{ parseFloat(item.cantidad) }}  /  @{{ item.cantidad * item.precio_unitario }}</td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>TOTALES</th>
                                                <th>@{{ form.totales.entrada_material }}  /  @{{ parseFloat(form.totales.entrada_valor) }}</th>
                                                <th>@{{ form.totales.salida_material }}  /  @{{ parseFloat(form.totales.salida_valor) }}</th>
                                                <th>@{{ form.totales.entrada_material - form.totales.salida_material }}   /   @{{ parseFloat((form.totales.entrada_valor * form.totales.entrada_material) -  (form.totales.salida_valor * form.totales.salida_material))}} </th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </kardex-material-index>
    </div>
@endsection