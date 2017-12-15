@extends('control_costos.layout')
@section('title', 'Reclasificación De Costos')
@section('contentheader_title', 'RECLASIFICACIÓN DE COSTOS')
@section('main-content')
    {!! Breadcrumbs::render('control_costos.reclasificacion_costos.index') !!}

<global-errors></global-errors>
<reclasificacion_costos-index
        :url_reclasificacion_costos_index="'{{ route('control_costos.reclasificacion_costos.index') }}'"
        inline-template
        v-cloak>
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultados</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nivel</th>
                                <th>Descripción</th>
                                <th>Costo Total</th>
                                <th width="150">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in filtros">
                                <td >@{{ index + 1  }}</td>
                                <td>@{{ item.nivel }}</td>
                                <td>@{{  item.operador }}</td>
                                <td>@{{  item.texto }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" title="Solicitar" class="btn btn-xs btn-sucess" >Solicitar</i></button>
                                    </div>
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

