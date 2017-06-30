@extends('sistema_contable.layout')
@section('title', 'Cuenta de Empresa')
@section('contentheader_title', 'Cuenta Empresa')
@section('contentheader_description', '(DETALLE)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_empresa.show', $empresa) !!}
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $empresa->razon_social}} &nbsp;
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-sm-6">
                            <dl>
                                <dt>ID</dt>
                                <dd>{{$empresa->id_empresa}}</dd>
                                <dt>USUARIO QUE REGISTRÓ</dt>
                                <dd>{{$empresa->user_registro}}</dd>
                                <dt>FECHA Y HORA DE REGISTRO</dt>
                                <dd>{{$empresa->FechaHoraRegistro}} </dd>
                            </dl>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    @if($empresa->cuentasEmpresa)
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
                                            <th>Cuenta contable</th>
                                            <th>Tipo de cuenta</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($empresa->cuentasEmpresa as $index=>$cuenta)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$cuenta->cuenta}}</td>
                                                <td>{{$cuenta->tipoCuentaEmpresa}}</td>

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