@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTA BANCARIA')
@section('contentheader_description', '(DETALLE)')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.cuentas_contables_bancarias.show', $cuenta->id_cuenta) !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de la Cuenta</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Razón Social</strong>
                    <p class="text-muted">{{ $cuenta->empresa->razon_social }}</p>
                    <hr>
                    <strong>Número</strong>
                    <p class="text-muted">{{ $cuenta->numero }}</p>
                    <hr>
                    <strong>Abreviatura</strong>
                    <p>{{ $cuenta->abreviatura }}</p>
                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        @if($cuenta->cuentas_asociadas)
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
                                @foreach($cuenta->cuentas_asociadas as $index => $c)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $c->cuenta }}</td>
                                        <td>{{ $c->tipoCuentaContable->descripcion }}</td>
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