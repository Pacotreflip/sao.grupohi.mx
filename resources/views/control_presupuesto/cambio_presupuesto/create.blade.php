@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-presupuesto-create inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Tipo de Orden de Cambio
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Cobrabilidad:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_cobrabilidad" v-on:change="form.id_tipo_orden = ''">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_cobrabilidad in tipos_cobrabilidad" :value="tipo_cobrabilidad.id">@{{ tipo_cobrabilidad.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cobrabilidad"><b>Tipo de Orden de Cambio:</b></label>
                                    <select class="form-control input-sm" v-model="form.id_tipo_orden" v-on:change="">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_orden in tipos_orden_filtered" :value="tipo_orden.id">@{{ tipo_orden.descripcion }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <variacion-volumen inline-template v-cloak v-if="form.id_tipo_orden == ">
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Conceptos</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="conceptos_table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Nivel 1</th>
                                            <th>Nivel 2</th>
                                            <th>Nivel 3</th>
                                            <th>Sector</th>
                                            <th>Cuadrante</th>
                                            <th>Especialidad</th>
                                            <th>Partida</th>
                                            <th>Sub Partida o Centa de costo</th>
                                            <th>Concepto</th>
                                            <th>Nivel 10</th>
                                            <th>Nivel 11</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Monto</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Nivel 1</th>
                                            <th>Nivel 2</th>
                                            <th>Nivel 3</th>
                                            <th>Sector</th>
                                            <th>Cuadrante</th>
                                            <th>Especialidad</th>
                                            <th>Partida</th>
                                            <th>Sub Partida o Centa de costo</th>
                                            <th>Concepto</th>
                                            <th>Nivel 10</th>
                                            <th>Nivel 11</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Monto</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </variacion-volumen>
        </section>
    </cambio-presupuesto-create>
@endsection

