@extends('formatos.layout')
@section('title', 'Formatos')
@section('contentheader_title', 'FORMATOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('formatos.index') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#subcontratos" data-toggle="tab" aria-expanded="true">Subcontratos</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            <li><a href="{{ route('formatos.subcontratos.estimacion') }}">ORDEN DE PAGO ESTIMACIÓN</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

