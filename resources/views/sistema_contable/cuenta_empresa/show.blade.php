@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTAS DE EMPRESAS')
@section('contentheader_description', '(DETALLE)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_empresa.show', $empresa) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Datos de la Empresa</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>RAZÓN SOCIAL</th>
                        <td>{{ $empresa->razon_social }}</td>
                    </tr>
                    <tr>
                        <th>RFC</th>
                        <td>{{ $empresa->rfc }}</td>
                    </tr>
                    <tr>
                        <th>USUARIO QUE REGISTRÓ</th>
                        <td>{{$empresa->user_registro ? $empresa->user_registro : '---' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>

    @if($empresa->cuentasEmpresa)
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                <div class="box-header">
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
        </div>
    @endif
@endsection