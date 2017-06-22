@extends('modulo_contable.layout')
@section('title', 'Póliza General')
@section('contentheader_title', 'PÓLIZA GENERAL')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_general.show',$poliza) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border" style="text-align: right">
                    <h3 class="box-title">Detalle de Póliza: {{$poliza->tipoPolizaContpaq}}</h3>
                </div>


                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <tr>
                                <th>Tipo de Póliza</th>

                                <th>Total</th>
                                <th>Cuadre</th>
                                <th>Estatus</th>
                                <th>Poliza ContPaq</th>
                            </tr>
                            <tr>
                                <td>{{ $poliza->tipoPolizaContpaq}}</td>

                                <td>{{ $poliza->total}}</td>
                                <td>{{ $poliza->cuadre}}</td>
                                <td>1</td>
                                <td>No lanzado</td>
                            </tr>
                            <tr>
                                <th>Cuenta Contable</th>
                                <th>Referencia</th>
                                <th>Concepto</th>
                                <th>Debe</th>
                                <th>Haber</th>
                            </tr>
                            @foreach($poliza->polizaMovimientos as $movimiento)
                                <tr>
                                    <td>{{$movimiento->cuenta_contable}}</td>
                                    <td>ref</td>
                                    <td>pago de algo</td>
                                    <td>150</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td>Sumas Iguales</td>
                                <td></td>
                                <td></td>
                            </tr>

                        </table>

                        <table class="table table-bordered ">
                            <tr>
                                <th>Concepto</th>

                            </tr>
                            <tr>
                                <td>{{$poliza->concepto}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
