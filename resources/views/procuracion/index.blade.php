@extends('procuracion.layout')
@section('title', 'Procuración')
@section('contentheader_title', 'PROCURACIÓN')
@section('breadcrumb')
    {!! Breadcrumbs::render('procuracion.index') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="subcontratos">
                        <ul class="nav nav-stacked">
                            @permission(['consultar_asignacion'])
                            <li><a href="{{ route('procuracion.asignacion.index') }}">ASIGNACIÓN DE COMPRADORES</a></li>
                            @endpermission
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

