@extends('sistema_contable.layout')
@section('title', 'Tipos de Cuentas Contables')
@section('contentheader_title', 'TIPOS CUENTAS CONTABLES')
@section('contentheader_description', '(DETALLE)')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.tipo_cuenta_contable.show', $tipo_cuenta_contable) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $tipo_cuenta_contable->descripcion }}
                            @if($tipo_cuenta_contable->cuentaContable)
                                <span class="label label-success">Asignada</span>
                            @else
                                <span class="label label-danger">No Asignada</span>
                            @endif
                        </h3>
                    </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-sm-6">
                        <dl>
                            <dt>ID</dt>
                            <dd>{{$tipo_cuenta_contable->id_tipo_cuenta_contable}}</dd>
                            <dt>DESCRIPCIÓN</dt>
                            <dd>{{$tipo_cuenta_contable->descripcion}}</dd>
                            <dt>USUARIO QUE REGISTRÓ</dt>
                            <dd>{{$tipo_cuenta_contable->userRegistro}}</dd>
                            <dt>FECHA Y HORA DE REGISTRO</dt>
                            <dd>{{$tipo_cuenta_contable->created_at->format('Y-m-d h:i:s a')}} </dd>
                        </dl>
                    </div>

                        <div class="col-sm-6">
                         @if($tipo_cuenta_contable->cuentaContable)
                            <dl>
                                <dt>CUENTA CONTABLE ASIGNADA</dt>
                                <dd><br>    </dd>
                                <dt>ID</dt>
                                <dd>{{$tipo_cuenta_contable->cuentaContable->id_int_cuenta_contable}}</dd>
                                @if($tipo_cuenta_contable->cuentaContable->prefijo == null)
                                    <dt>CUENTA CONTABLE</dt>
                                    <dd>{{$tipo_cuenta_contable->cuentaContable->cuenta_contable}}</dd>
                                @else
                                    <dt>PREFIJO</dt>
                                    <dd>{{$tipo_cuenta_contable->cuentaContable->prefijo}}</dd>
                                @endif
                                <dt>FECHA Y HORA DE REGISTRO</dt>
                                <dd>{{$tipo_cuenta_contable->cuentaContable->created_at->format('Y-m-d h:i:s a')}} </dd>
                            </dl>
                         @endif
                        </div>

                </div>
                <!-- /.box-body -->

            </div>
        </div>
    </div>

@endsection