@extends('layouts.app')
@section('title', 'Inicio')
@section('contentheader_title', 'SISTEMAS')
@section('main-content')
    <!-- Main content -->
    <section class="content">
        <!-- COLOR PALETTE -->
        <div class="row">
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
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>Reportes</h4>
                        <p>
                            <br/>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text-o fa-fw "></i>
                    </div>
                    <a href="{{route('reportes.index')}}" class="small-box-footer">
                        Ingresar <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

           <!-- <div class="col-lg-3 col-xs-6">

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
            </div>   -->


        </div>
    </section>
    <!-- /.bo


@endsection


