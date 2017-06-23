@extends('modulo_contable.layout')
@section('title', 'Pólizas Generadas')
@section('contentheader_title', 'PÓLIZAS GENERADA')
@section('contentheader_description', '(EDICIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_generada.edit', $poliza) !!}

    <div id="app">
        <poliza-generada-edit v-bind:poliza="{{$poliza}}" inline-template v-cloak>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border" style="text-align: right">
                                <h3 class="box-title">Detalle de Póliza: {{$poliza->tipoPolizaContpaq}}</h3>
                            </div>


                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small">
                                        <tr>
                                            <th colspan="5" class="bg-gray-light">Poliza
                                                :<br><label>{{ $poliza->tipoPolizaContpaq}}</label></th>
                                            <th class="bg-gray-light">Fecha de Solicitud
                                                :<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a') }}</label></th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="bg-gray-light">Concepto:<br>
                                                <input type="text" class="form-control" v-model="data.poliza.concepto">
                                            </th>
                                            <th colspan="2" class="bg-gray-light">Usuario
                                                Solicita:<br><label> {{$poliza->user_registro }}</label></th>

                                        </tr>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-app btn-sm btn-success pull-right">
                                                <i class="fa fa-plus"></i> Movimiento
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <table v-if="data.poliza.poliza_movimientos.length" class="table table-bordered small">

                                            <tr>
                                                <th class="bg-gray-light">Cuenta Contable</th>
                                                <th class="bg-gray-light">Nombre Cuenta Contable</th>
                                                <th class="bg-gray-light">Debe</th>
                                                <th class="bg-gray-light">Haber</th>
                                                <th class="bg-gray-light">Referencia</th>
                                                <th class="bg-gray-light">Concepto</th>

                                            </tr>
                                                <tr v-for="movimiento in data.poliza.poliza_movimientos">
                                                    <td>@{{ movimiento.cuenta_contable}}</td>
                                                    <td>@{{ movimiento.descripcion_cuenta_contable}}</td>
                                                    <td class="bg-gray-light numerico">
                                                        <span v-if="movimiento.id_tipo_movimiento_poliza == 1">
                                                            $ @{{(movimiento.importe) }}
                                                        </span>
                                                    </td>
                                                    <td class="bg-gray-light numerico">
                                                        <span v-if="movimiento.id_tipo_movimiento_poliza == 1">
                                                            $ @{{(movimiento.importe) }}
                                                        </span>
                                                    </td>
                                                    <td>@{{movimiento.referencia}}</td>
                                                    <td>@{{movimiento.concepto}}</td>

                                                </tr>
                                            <tr>

                                                <td colspan="2" class="bg-gray"><b>Sumas Iguales</b></td>
                                                <td class="bg-gray numerico">
                                                    <b>$@{{(poliza.suma_debe)}}</b></td>
                                                <td class="bg-gray numerico">
                                                    <b>$@{{(poliza.suma_haber)}}</b></td>
                                                <td class="bg-gray"></td>
                                                <td class="bg-gray"></td>
                                            </tr>

                                        </table>
                                        <div class="col-sm-12" style="text-align: right"><h4><b>Total de la Póliza:</b>  $@{{(poliza.total)}}</h4></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </poliza-generada-edit>
    </div>
@endsection
