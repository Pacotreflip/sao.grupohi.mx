@extends('sistema_contable.layout')
@section('title', 'Revaluaciones')
@section('contentheader_title', 'REVALUACIONES')


@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.revaluacion.create') !!}
    <revaluacion-create :facturas="{{ $facturas->toJson() }}" inline-template>
    <section >

        <div class="box box-solid">
            <form action="{{route('sistema_contable.revaluacion.store')}}" method="POST">
                {!! Form::token() !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Facturas por Reevaluar</h3>
                    <hr>
                    <div class="col-md-6">
                        <label for="tipo_cambio"><strong>Tipo de Cambio</strong></label>
                        <input type="number" step="any" name="tipo_cambio" class="form-control" value="{{$tipo_cambio}}" />
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped small">
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
                                <td>@{{ (new Date(factura.fecha)).dateFormat() }}</td>
                                <td style="text-align: right">$ @{{  (parseFloat(factura.monto)).formatMoney(2,'.',',') }}</td>
                                <td>
                                    <input type="checkbox" :name="'id_transaccion[' + factura.id_transaccion + ']'" checked>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </section>
    </revaluacion-create>
@endsection