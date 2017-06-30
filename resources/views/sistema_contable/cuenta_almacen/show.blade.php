@extends('sistema_contable.layout')
@section('title', 'Cuentas de Almacén')
@section('contentheader_title', 'CUENTAS DE ALMACËN')
@section('contentheader_description', '(DETALLE)')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_almacen.show', $almacen) !!}


    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cuenta de Almacén
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-sm-6">
                            <dl>
                                <dt>ID</dt>
                                <dd>{{$almacen->id_almacen}}</dd>
                                <dt>DESCRIPCION</dt>
                                <dd>{{$almacen->descripcion}}</dd>
                            </dl>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    @if($almacen->cuentaAlmacen)
        <div class="row">
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
                                            <th>CUENTA CONTABLE</th>
                                            <th>USUARIO QUE REGISTRÓ</th>
                                            <th>FECHA Y HORA DE REGISTRO</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($$almacen->cuentaAlmacen as $index=>$cuenta)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$cuenta->cuenta}}</td>
                                                <td>{{$cuenta->registro}}</td>
                                                <td>{{$cuenta->created_at}}</td>
                                                <button type="button" class="btn btn-xs btn-danger" onclick=" delete_tipo_cuenta_contable({{$cuenta->id}})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection