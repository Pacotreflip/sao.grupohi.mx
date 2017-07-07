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
                    <div class="col-sm-12">
                        <h4 class="box-title">SELECCIONAR MATERIAL</h4>
                        <select class="form-control input-sm" style="width: 40%" v-model="valor" @change="datos()">
                            <option value="-1">[-SELECCIONE-]</option>
                            <option v-for="(material, index) in materiales" :value="index">@{{ material.id_material }} - @{{ material.descripcion }}</option>
                        </select>
                    </div>
                </div>
                <br>

                <div class="row" v-if="valor != -1">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Kardex de Material</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-sm-6">
                                    <dl>
                                        <dt>ID MATERIAL: </dt>
                                        <dd>@{{form.material.id_material}}</dd>
                                        <dt>DESCRIPCION</dt>
                                        <dd>@{{form.material.descripcion}}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-6">
                                    <dl>
                                        <dt>UNIDAD DE MEDIDA</dt>
                                        <dd >@{{form.material.unidad}}</dd>
                                        <dt>FAMILIA</dt>
                                        <dd>@{{form.material.d_padre}}</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-12">

                                    <div class="row table-responsive">
                                        <table  class="table table-bordered table-striped small index_table" role="grid"
                                                aria-describedby="tipo_cuenta_info">
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
                                                    <td>@{{ item.transaccion.FechaHoraRegistro }}</td>
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
                                                    <th>#</th>
                                                    <th></th>
                                                    <th>TOTALES</th>
                                                    <th>@{{ form.totales.entrada_material }}  /  @{{ form.totales.entrada_valor }}</th>
                                                    <th>@{{ form.totales.salida_material }}  /  @{{ form.totales.salida_valor }}</th>
                                                    <th>@{{ form.totales.entrada_material - form.totales.salida_material }}   /   @{{ form.totales.entrada_valor -  form.totales.salida_valor}} </th>
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
@section('scripts-content')
    <script>
        function totalCosto(p1, p2) {
            return p1 * p2;
        }

</script>
@endsection