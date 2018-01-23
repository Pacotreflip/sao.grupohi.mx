@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-presupuesto-create inline-template v-cloak>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cobrabilidad"><b>Cobrabilidad:</b></label>
                    <select class="form-control input-sm" v-model="form.id_tipo_cobrabilidad">
                        <option v-for="tipo_cobrabilidad in tipos_cobrabilidad" value="tipo_cobrabilidad.id">@{{ tipo_cobrabilidad.descripcion }}</option>
                    </select>
                </div>
            </div>
        </div>
    </cambio-presupuesto-create>
@endsection

