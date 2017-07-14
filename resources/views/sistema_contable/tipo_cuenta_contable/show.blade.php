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
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>DESCRIPCIÓN</th>
                                <td>{{$tipo_cuenta_contable->descripcion}}</td>
                            </tr>
                            <tr>
                                <th>USUARIO QUE REGISTRÓ</th>
                                <td>{{$tipo_cuenta_contable->userRegistro}}</td>
                            </tr>
                            <tr>
                                <th>NATURALEZA DE CUENTA</th>
                                <td>{{$tipo_cuenta_contable->naturalezaPoliza}}</td>
                            </tr>
                            <tr>
                                <th>FECHA Y HORA DE REGISTRO</th>
                                <td>{{$tipo_cuenta_contable->created_at->format('Y-m-d h:i:s a')}} </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-12">
                        @if($tipo_cuenta_contable->cuentaContable)

                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th colspan="2"><center>CUENTA CONTABLE ASIGNADA</center></th>

                                </tr>
                                <tr>
                                    <th>CUENTA CONTABLE</th>
                                    <td>{{$tipo_cuenta_contable->cuentaContable->cuenta_contable}}</td>
                                </tr>
                                <tr>
                                    <th>PREFIJO</th>
                                    <td>  @if($tipo_cuenta_contable->cuentaContable->prefijo == null)
                                           CUENTA CONTABLE
                                        @else
                                         PREFIJO

                                        @endif</td>
                                </tr>

                                <tr>
                                    <th>FECHA Y HORA DE REGISTRO</th>
                                    <td>{{$tipo_cuenta_contable->cuentaContable->created_at->format('Y-m-d h:i:s a')}} </td>
                                </tr>

                                </tbody>
                            </table>

                        @endif
                    </div>

                </div>
                <!-- /.box-body -->

            </div>
        </div>
    </div>

@endsection