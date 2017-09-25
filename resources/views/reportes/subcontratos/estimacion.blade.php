@extends('compras.layout')
@section('title', 'Reportes')
@section('contentheader_title', 'ORDEN DE PAGO ESTIMACIÓN')


@section('main-content')
    {!! Breadcrumbs::render('reportes.subcontratos.estimacion') !!}
    <subcontratos-estimacion
            inline-template
            v-cloak
            :subcontratos_url="'{{route('subcontrato.index')}}'"
            :estimaciones_url="'{{route('estimacion.index')}}'"
    >
        <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Datos de Consulta</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Contratista</strong></label>
                            <select class="form-control input-sm" name="id_empresa" v-model="form.id_empresa" v-on:change="fetchSubcontratos(form.id_empresa)">
                                <option value>[--SELECCIONE--]</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id_empresa}}">{{$empresa->razon_social}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Subcontrato</strong></label>
                            <select class="form-control input-sm" v-model="form.id_subcontrato" :disabled="!subcontratos.length" v-on:change="fetchEstimaciones(form.id_subcontrato)">
                                <option value>[--SELECCIONE--]</option>
                                <option v-for="subcontrato in subcontratos" :value="subcontrato.id_transaccion">@{{ subcontrato.referencia }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Estimación</strong></label>
                            <select class="form-control input-sm" v-model="form.id_estimacion" :disabled="!estimaciones.length">
                                <option value>[--SELECCIONE--]</option>
                                <option v-for="estimacion in estimaciones" :value="estimacion.id_transaccion">@{{ estimacion.numero_folio + ' - ' + estimacion.observaciones }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12">
                        <button :disabled="!form.id_estimacion" class="btn btn-info btn-sm pull-right">Ver Informe</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </subcontratos-estimacion>
@endsection