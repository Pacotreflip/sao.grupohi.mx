@extends('sistema_contable.layout')
@section('title', 'Revaluaciones')
@section('contentheader_title', 'REVALUACIONES')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.revaluacion.create') !!}
    <revaluacion-create
            :facturas="{{ $facturas->toJson() }}"
            :url_revaluacion="'{{route('sistema_contable.revaluacion.store')}}'"
            inline-template
            v-cloak>
    <section >

        <div class="box box-solid">
            <form id="form_facturas"  @submit.prevent="validateForm('form_facturas','confirm_save_facturas')"  data-vv-scope="form_facturas" >
                {!! Form::token() !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Facturas por Revaluar</h3>
                    <hr>
                    <div class="col-md-3">
                        <div class="form-group" :class="{'has-error': validation_errors.has('form_facturas.tipo_cambio')}">
                            <label for="tipo_cambio"><strong>Tipo de Cambio</strong></label>
                            <input type="number" step="any" name="tipo_cambio" class="form-control"   v-validate="'required|decimal|min_value:0'"  value="{{number_format($tipo_cambio,4)}}"/>
                            <label class="help" v-show="validation_errors.has('form_facturas.tipo_cambio')">@{{ validation_errors.first('form_facturas.tipo_cambio') }}</label>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Empresa</th>
                                <th>Referencia</th>
                                <th>Contrarecibo</th>

                                <th>Observaciones</th>
                                <th>Fecha </th>
                                <th>Monto</th>
                                <th>Seleccionar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(factura, index) in data.facturas">
                                <td>@{{ index + 1 }}</td>

                                <td>@{{factura.empresa.razon_social}}</td>
                                <td>@{{factura.referencia}}</td>
                                <td>@{{factura.id_antecedente}}</td>
                                <td>@{{factura.observaciones}}</td>
                                <td>@{{ (new Date(factura.fecha)).dateShortFormat() }}</td>
                                <td style="text-align: right">$ @{{  (parseFloat(factura.monto)).formatMoney(2,'.',',') }}</td>
                                <td>
                                    <input type="checkbox" :name="'id_transaccion[' + factura.id_transaccion + ']'" checked v-icheck>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right" :disabled="guardando">
                        <span v-if="guardando">
                            <i class="fa fa-spin fa-spinner"></i> Guardando
                        </span>
                        <span v-else>
                            <i class="fa fa-save"></i> Guardar
                        </span>
                    </button>
                </div>
            </form>
        </div>
        </section>
    </revaluacion-create>
@endsection