@extends('sistema_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIALES')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_material.index') !!}
    <hr>
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
                                <h3 class="box-title col-sm-3">Selecciones la Cuenta de Materiales</h3>
                                <select class="form-control col-sm-6">
                                    <option value = 0>[-SELECCIONE-]</option>
                                    <option value = 1>Materiales</option>
                                    <option value = 2>Mano de Obra y Servicios</option>
                                    <option value = 4>Herramienta y Equipo</option>
                                    <option value = 8>Maquinaria</option>
                                </select>
                            </div>
{{ estatus }}
                        </div>
                    </div>
                </div>



                @if(false)
                    <div class="row" v-if="estatus">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cuentas de Materiales</h3>
                                </div>
                                <div class="box-body">
                                    <div class="col-sm-12">
                                        <div class="row table-responsive">
                                            <table  class="table table-bordered table-striped dataTable index_table" role="grid"
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
                                                @foreach($cuentas_material as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->nivel  }}</td>
                                                        <td>{{ $item->descripcion }}</td>
                                                        <td>{{ $item->unidad }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach

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