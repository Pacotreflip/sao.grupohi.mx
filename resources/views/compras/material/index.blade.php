@extends('compras.layout')
@section('title', 'Materiales')
@section('contentheader_title', 'MATERIALES')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('compras.material.index') !!}
    <div id="app">
        <global-errors></global-errors>
        <material-index
                :material_url="'{{route('compras.material.index')}}'"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                div class="row">
                                <div class="col-sm-12">
                                    <a  href="{{ route('compras.material.create') }}" class="btn btn-success btn-app" style="float:right">
                                        <i class="glyphicon glyphicon-plus-sign"></i>Nueva
                                    </a>
                                </div>
                                <h3 class="box-title">Compras Material</h3>
                            </div>
                            <div class="box-body">
                                <
                                </div>
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
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">Detalle de Cuentas de Material</h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table  class="table table-bordered table-striped small index_table" id="example">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">DESCRIPCION</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Fecha/Hora</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in data.items">
                                                <td>@{{ index + 1 }}</td>
                                                <td>@{{ item.descripcion }}</td>
                                                <td>@{{ (new Date(item.FechaHoraRegistro)).dateFormat() }}</td>
                                                <td style="min-width: 90px;max-width: 90px">
                                                    <div class="btn-group">
                                                        <a :href="material_url + '/' + item.id_material" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                                        <a href="" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
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
        </material-index>
    </div>

@endsection