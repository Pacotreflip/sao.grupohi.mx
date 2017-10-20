@extends('compras.layout')
@section('title', 'Materiales')
@section('contentheader_title', 'MATERIALES')

@section('main-content')
    {!! Breadcrumbs::render('compras.material.show', $material) !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuenta de Materiales
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-sm-6">
                                    <dl>
                                        <dt>ID</dt>
                                        <dd>{{$material->nivel}}</dd>
                                        <dt>DESCRIPCION</dt>
                                        <dd>{{$material->descripcion}}</dd>
                                    </dl>
                                </div>

                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="false">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Cuentas Configuradas</h3>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="box-body">
                                        <table class="table table-bordered table-striped ">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NIVEL</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>CUENTA</th>
                                                <th>FECHA Y HORA DE REGISTRO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>NIVEL</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>CUENTA</th>
                                                <th>FECHA Y HORA DE REGISTRO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection