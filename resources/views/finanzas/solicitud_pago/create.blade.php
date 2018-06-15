@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE PAGO')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_pago.create') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    @permission('registrar_reposicion_fondo_fijo')
                    <li class="" id="li_reposicion_fondo_fijo"><a href="#tab_reposicion_fondo_fijo" data-toggle="tab" aria-expanded="false">REPOSICIÓN DE FONDO FIJO</a></li>
                    @endpermission
                    @permission('registrar_pago_cuenta')
                    <li class="" id="li_pago_cuenta"><a href="#tab_pago_cuenta" data-toggle="tab" aria-expanded="false">PAGO A CUENTA</a></li>
                    @endpermission
                    <li class="pull-left header"><i class="fa fa-th"></i> Solicitud de Pago</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab_reposicion_fondo_fijo">
                        <reposicion-fondo-fijo-create v-cloak>
                        </reposicion-fondo-fijo-create>
                    </div>
                    <div class="tab-pane" id="tab_pago_cuenta">
                        <pago-cuenta-create v-cloak>
                        </pago-cuenta-create>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
