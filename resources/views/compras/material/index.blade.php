@extends('compras.layout')
@section('title', 'Materiales')
@section('contentheader_title', 'MATERIALES')
@section('breadcrumb')
    {!! Breadcrumbs::render('compras.material.index') !!}
@endsection
@section('main-content')
    <div id="app">
        <global-errors></global-errors>
        <material-index
                :material_url="'{{route('compras.material.index')}}'"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-sm-12">
                        <a  href="{{'compras.material.create'}}" class="btn btn-success btn-app" style="float:right">
                            <i class="glyphicon glyphicon-plus-sign"></i>Nueva
                        </a>
                    </div>
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuentas por Material</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcion" class="control-label">Tipo de Material</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control input-sm"  v-model="valor" @change="cambio()" >
                                            <option :value="0">[-SELECCIONE-]</option>
                                            <option :value="1">Materiales</option>
                                            <option :value="2">Mano de Obra y Servicios</option>
                                            <option :value="4">Herramienta y Equipo</option>
                                            <option :value="8">Maquinaria</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-info box-solid" v-show="guardando">
                    <div class="box-header">
                        <h3 class="box-title">Cargando el Tipo de Materiales</h3>
                        <div class="overlay">
                            <i class="fa fa-spinner fa-pulse" style="color: white"></i>
                        </div>
                    </div>
                </div>
                <div v-show="valor > 0 && !guardando">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Detalle de Cuentas de Material</h3>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table  class="table table-bordered table-striped" id="example">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Descripción</th>
                                                <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Fecha/Hora</th>
                                                <th>Acciones</th>
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
                                                <th>Descripción</th>
                                                <th>Fecha/Hora</th>
                                                <th>Acciones</th>
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