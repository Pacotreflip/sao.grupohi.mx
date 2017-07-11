@extends('sistema_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIALES')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_material.index') !!}

    <div id="app">
        <global-errors></global-errors>
        <cuenta-material-index
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
                                        <th>SELECCIONAR TIPO DE MATERIAL</th>
                                        <td>
                                            <select class="form-control input-sm" style="width: 40%" v-model="valor" @change="cambio()" >
                                                <option :value="0">[-SELECCIONE-]</option>
                                                <option :value="1">Materiales</option>
                                                <option :value="2">Mano de Obra y Servicios</option>
                                                <option :value="4">Herramienta y Equipo</option>
                                                <option :value="8">Maquinaria</option>
                                            </select>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="valor > 0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Detalle de Cuentas de Material</h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table  class="table table-bordered table-striped">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">NIVEL</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">DESCRIPCION</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Fecha/Hora</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in data.items">
                                                <td>@{{ index }}</td>
                                                <td>@{{ item.nivel }}</td>
                                                <td>@{{ item.descripcion }}</td>
                                                <td>@{{ (new Date(item.FechaHoraRegistro)).dateFormat() }}</td>
                                                <td style="min-width: 90px;max-width: 90px">
                                                    <div class="btn-group">
                                                        <a title="Editar" href="{{ route('sistema_contable.cuenta_material.show') }}" type="button" class="btn btn-xs btn-default">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>NIVEL</th>
                                                <th>DESCRIPCION</th>
                                                <th>Fecha/Hora</th>
                                                <th>ACCIONES</th>
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
        </cuenta-material-index>
    </div>
@endsection