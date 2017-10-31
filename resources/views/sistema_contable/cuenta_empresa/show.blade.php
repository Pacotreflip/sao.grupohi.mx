@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTAS DE EMPRESAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.cuenta_empresa.show', $empresa) !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de la Empresa</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Razón Social</strong>
                    <p class="text-muted">{{ $empresa->razon_social }}</p>
                    <hr>

                    <strong>RFC</strong>
                    <p class="text-muted">{{ $empresa->rfc }}</p>
                    <hr>

                    <strong>Usuario que Registró</strong>
                    <p>{{ $empresa->user_registro ? $empresa->user_registro : '---' }}</p>
                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        @if($empresa->cuentasEmpresa)
            <div class="col-md-9">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cuentas Configuradas</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cuenta contable</th>
                                    <th>Tipo de cuenta</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($empresa->cuentasEmpresa as $index => $cuenta)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $cuenta->cuenta }}</td>
                                        <td>{{ $cuenta->tipoCuentaEmpresa }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection