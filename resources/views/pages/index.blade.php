@extends('layouts.app')
@section('title', 'Inicio')
@section('contentheader_title', 'SISTEMAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('index') !!}
@endsection
@section('main-content')
    <!-- Main content -->
    <section class="content">
        <!-- COLOR PALETTE -->
        <div class="row">

            @if(auth()->user()->canAccessSystem('sistema_contable'))
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h4>Contable</h4>
                            <p>
                                <br/>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-usd fa-fw "></i>
                        </div>

                        <a href="{{route('sistema_contable.index')}}" class="small-box-footer">
                            Ingresar <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endif

            @if(auth()->user()->canAccessSystem('finanzas'))
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>Finanzas</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-area-chart fa-fw "></i>
                    </div>

                    <a href="{{route('finanzas.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->canAccessSystem('formatos'))
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>Formatos</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text-o fa-fw "></i>
                    </div>
                    <a href="{{route('formatos.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->canAccessSystem('tesoreria'))
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue-active">
                    <div class="inner">
                        <h4>Tesorería</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money fa-fw "></i>
                    </div>
                    <a href="{{route('tesoreria.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->canAccessSystem('control_costos'))
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red-active">
                    <div class="inner">
                        <h4>Control de Costos</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock fa-fw "></i>
                    </div>
                    <a href="{{route('control_costos.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->canAccessSystem('control_presupuesto'))
                <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-orange-active">
                    <div class="inner">
                        <h4>Control del Presupuesto</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-lock fa-fw "></i>
                    </div>
                    <a href="{{route('control_presupuesto.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->canAccessSystem('procuracion'))
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy-active">
                        <div class="inner">
                            <h4>Procuración</h4>
                            <p>
                                <br/>
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-lock fa-fw "></i>
                        </div>
                        <a href="{{route('procuracion.index')}}" class="small-box-footer">
                            Ingresar <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endif
           {{-- <div class="col-lg-3 col-xs-6">

                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>Compras</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-credit-card fa-fw "></i>
                    </div>

                    <a href="{{route('compras.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>   --}}


        </div>
    </section>
    <!-- /.bo

@endsection


