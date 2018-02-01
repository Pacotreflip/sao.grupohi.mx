@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'SOICITUD DE CAMBIO AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-presupuesto-create
            inline-template
            v-cloak
            :operadores="{{ json_encode($operadores) }}"
    >
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Información de la Solicitud
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Cobrabilidad:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_cobrabilidad" v-on:change="form.id_tipo_orden = ''" :disabled="!tipos_cobrabilidad.length">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_cobrabilidad in tipos_cobrabilidad" :value="tipo_cobrabilidad.id">@{{ tipo_cobrabilidad.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Tipo de Solicitud:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_orden" :disabled="!tipos_orden_filtered.length" v-on:change="obtenerPresupuestos">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_orden in tipos_orden_filtered" :value="tipo_orden.id">@{{ tipo_orden.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('control_presupuesto.cambio_presupuesto.variacion_volumen')
        </section>
    </cambio-presupuesto-create>
@endsection

