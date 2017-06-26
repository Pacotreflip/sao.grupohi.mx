@extends('sistema_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'TIPO CUENTA CONTABLE')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.tipo_cuenta_contable.show', $tipo_cuenta_contable) !!}
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tipo Cuenta Contable&nbsp;
                            @if($tipo_cuenta_contable->cuentaContable->prefijo == null)
                                <span class="label label-success">{{$tipo_cuenta_contable->cuentaContable->cuenta_contable}}</span>
                            @else
                                <span class="label label-success">{{$tipo_cuenta_contable->cuentaContable->prefijo}}</span>
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
                </div>
                <!-- /.box-body -->

            </div>
        </div>
    </div>

@endsection