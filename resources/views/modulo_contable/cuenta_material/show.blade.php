@extends('modulo_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIALES')
@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.cuenta_material.show') !!}

    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Material&nbsp;

                        </h3>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-6">
                        <dl>
                            <dt>ID</dt>
                            <dd>id</dd>
                            <dt>CAMPO 1</dt>
                            <dd>campo1</dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl>
                            <dt>CAMPO 2</dt>
                            <dd>campo 2</dd>
                            <dt>CAMPO 3</dt>
                            <dd>campo 3 </dd>
                        </dl>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="box box-success">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tipo de Cuenta

                        </h3>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-6">
                        <dl>
                            <dt>ID</dt>
                            <dd>id</dd>
                            <dt>CAMPO 1</dt>
                            <dd>campo1</dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl>
                            <dt>CAMPO 2</dt>
                            <dd>campo 2</dd>
                            <dt>CAMPO 3</dt>
                            <dd>campo 3 </dd>
                        </dl>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="box box-success">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cuenta Contable

                        </h3>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-6">
                        <dl>
                            <dt>ID</dt>
                            <dd>id</dd>
                            <dt>CAMPO 1</dt>
                            <dd>campo1</dd>
                        </dl>
                    </div>
                    <div class="col-sm-6">
                        <dl>
                            <dt>CAMPO 2</dt>
                            <dd>campo 2</dd>
                            <dt>CAMPO 3</dt>
                            <dd>campo 3 </dd>
                        </dl>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

@endsection