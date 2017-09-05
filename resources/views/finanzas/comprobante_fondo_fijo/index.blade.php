@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SISTEMA DE FINANZAS')
@section('contentheader_description', '(INDEX)')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.comprobante_fondo_fijo.index') !!}

    <div class="row">
        <div class="col-sm-12">

            <a  href="{{ route('finanzas.comprobante_fondo_fijo.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
            </a>

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Comprobantes de Fondo Fijo</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped index_table">
                            <thead>
                            <tr>
                                <th># Folio</th>
                                <th>Fondo Fijo</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Referencia</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comprobantes_fondo_fijo as $item)
                                <tr>
                                    <td>{{ $item->numero_folio}}</td>
                                    <td>{{ $item->FondoFijo}}</td>
                                    <td class="text-right">${{ number_format($item->monto, 2, ",", ".") }}</td>
                                    <td>{{ $item->fecha->format("Y-m-d")}}</td>
                                    <td>{{ $item->referencia }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
