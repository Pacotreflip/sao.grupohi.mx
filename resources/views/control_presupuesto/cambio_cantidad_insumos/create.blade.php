@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CAMBIO DE CANTIDAD A INSUMOS <small>(COSTO DIRECTO)</small>')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid" v-if="!cargando_tarjetas">
                <div class="box-header with-border">
                    <h3 class="box-title">Filtros para consulta de Conceptos</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><b>Número de Tarjeta</b></label>
                                <select2 id="tarjetas_select" :disabled="cargando" v-model="id_tarjeta"
                                         :options="tarjetas">
                                </select2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal-body small">
        <select class="form-control" :name="'Item'" data-placeholder="BUSCAR INSUMO"
                id="sel_material"
                v-model="id_material_seleccionado"></select>

    </div>

@endsection