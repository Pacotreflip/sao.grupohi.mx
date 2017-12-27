@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.index') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            {{--@permission(['consultar_movimiento_bancario'])--}}
                            <li><a href="{{ route('control_presupuesto.presupuesto.index') }}">CONTROL PRESUPUESTO</a></li>
                            {{--@endpermission--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

