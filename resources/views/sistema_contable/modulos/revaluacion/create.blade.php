@extends('sistema_contable.layout')
@section('title', 'Revaluaciones')
@section('contentheader_title', 'REVALUACIONES')


@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.revaluacion.create') !!}

    <revaluacion-create :facturas="{{ $facturas->toJson() }}" inline-template>
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Facturas por Reevaluar</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de Folio</th>
                            <th>Fecha </th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(factura, index) in data.facturas">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ factura.numero_folio }}</td>
                            <td>@{{ (new Date(factura.fecha)).dateFormat() }}</td>
                            <td style="text-align: right">$ @{{  (parseFloat(factura.monto)).formatMoney(2,'.',',') }}</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </revaluacion-create>
@endsection