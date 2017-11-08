@extends('tesoreria.layout')
@section('title', 'Tesorería')
@section('contentheader_title', 'TESORERÍA')
@section('main-content')
    {!! Breadcrumbs::render('tesoreria.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            @permission(['consultar_traspaso_cuenta'])
                            <li><a href="{{ route('tesoreria.traspaso_cuentas.index') }}">TRASPASO ENTRE CUENTAS BANCARIAS</a></li>
                            @endpermission
                            @permission(['consultar_movimiento_bancario'])
                            <li><a href="{{ route('tesoreria.movimientos_bancarios.index') }}">MOVIMIENTOS BANCARIOS</a></li>
                            @endpermission
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

