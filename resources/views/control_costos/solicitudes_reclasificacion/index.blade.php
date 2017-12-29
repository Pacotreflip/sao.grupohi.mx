@extends('control_costos.layout')
@section('title', 'Reclasificación De Costos')
@section('contentheader_title', 'RECLASIFICACIÓN DE COSTOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_costos.solicitudes_reclasificacion.index') !!}
@endsection
@section('main-content')

<global-errors></global-errors>
<reclasificacion_costos-index
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Solicitudes</h3>
                    </div>
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
    </section>
</reclasificacion_costos-index>

@endsection

