@extends('sistema_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIALES')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_material.index') !!}
    <hr xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div id="app">


        <global-errors></global-errors>
        <cuenta-material-index
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-info">
                            <div class="box-header with-border ">
                                <h3 class="box-title col-sm-3">Seleccione el Tipo de MAterial</h3>
                                <select class="form-control col-sm-6"  v-model="valor" :change="cambio">
                                    <option :value = 0>[-SELECCIONE-]</option>
                                    <option :value = 1>Materiales</option>
                                    <option :value = 2>Mano de Obra y Servicios</option>
                                    <option :value = 4>Herramienta y Equipo</option>
                                    <option :value = 8>Maquinaria</option>
                                </select>
                            </div>
                        </div>

                        {{ dd(\Ghi\Domain\Core\Models\Material::find(6)->toArray()) }}
                    </div>
                </div>



                @if(true)
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cuentas de Materiales</h3>
                                </div>
                                <div class="box-body">
                                    <div class="col-sm-12">
                                        <div class="row table-responsive">
                                            <table  class="table table-bordered table-striped " role="grid"
                                                    aria-describedby="tipo_cuenta_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Nivel</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Descripción</th>
                                                    <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Unidad</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <!-- // Statement de llenado   -->

                                                    <tr v-for="(item, index) in items" v-if="guardando">
                                                        <td>@{{ index + 1 }}</td>
                                                        <td>@{{ item.nivel  }}</td>
                                                        <td>@{{ item.descripcion }}</td>
                                                        <td>@{{ item.unidad }}</td>
                                                        <td></td>
                                                    </tr>


                                                <!-- // fin de llenado  -->
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nivel</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th></th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </cuenta-material-index>
    </div>
@endsection