@extends('reportes.layout')
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
                        <button v-on:click="pdf(form.id_estimacion)" :disabled="!form.id_estimacion" class="btn btn-info btn-sm pull-right">Ver Informe</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="PDFModal" tabindex="-1" role="dialog" aria-labelledby="PDFModal">
            <div class="modal-dialog modal-lg" id="mdialTamanio">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <h4 class="modal-title">Orden de Pago Estimación</h4>
                    </div>
                    <div class="modal-body modal-lg" style="height: 800px ">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </subcontratos-estimacion>
@endsection