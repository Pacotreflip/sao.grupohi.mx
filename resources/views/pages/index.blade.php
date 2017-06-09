@extends('layouts.app')
@section('title', 'Inicio')
@section('contentheader_title', 'INICIO')
@section('main-content')
    {!! Breadcrumbs::render('index') !!}
    <!-- Main content -->
    <section class="content">
        <!-- COLOR PALETTE -->
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tag"></i>Modulos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4 col-md-2">
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
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>

                    </div>
                    <div class="col-sm-4 col-md-2">
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
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h4>Finanzas</h4>
                                <p>
                                    <br/>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-pie-chart fa-fw "></i>
                            </div>
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h4>Maquinaria</h4>
                                <p>
                                    <br/>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-truck fa-fw "></i>
                            </div>
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-2">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h4>Lista de Raya</h4>
                                <p>
                                    <br/>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list-ul fa-fw "></i>
                            </div>
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h4>Presupuestos</h4>
                                <p>
                                    <br/>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-clipboard fa-fw"></i>
                            </div>
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h4>Interfaz Neodata</h4>
                                <p>
                                    <br/>
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-android fa-fw "></i>
                            </div>
                            <a href="{{route('modulo_contable.index')}}" class="small-box-footer">
                                Acceder<i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->


            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.bo


@endsection


