@extends('sistema_contable.layout')
@section('title', 'Plantillas de Pre-Pólizas')
@section('contentheader_title', 'PLANTILLAS DE PRE-PÓLIZAS')
@section('contentheader_description', '(DETALLE)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_tipo.show', $poliza_tipo) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos de la Plantilla</h3>
                    </div>


                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>TIPO DE PÓLIZA</th>
                                <td>{{ $poliza_tipo->polizaTipoSAO }}</td>
                            </tr>
                            <tr>
                                <th>USUARIO QUE REGISTRÓ</th>
                                <td>{{ $poliza_tipo->userRegistro }}</td>
                            </tr>
                            <tr>
                                <th>FECHA Y HORA DE REGISTRO</th>
                                <td>{{$poliza_tipo->created_at->format('Y-m-d h:i:s a')}}</td>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                            </tr>
                            <tr>
                                <th>INICIO DE VIGENCIA</th>
                                <td>{{$poliza_tipo->inicio_vigencia->format('Y-m-d h:i:s a')}}</td>
                            </tr>
                            <tr>
                                <th>FIN DE VIGENCIA</th>
                                <td>@if($poliza_tipo->fin_vigencia)
                                        {{$poliza_tipo->fin_vigencia->format('Y-m-d h:i:s a')}}
                                    @else
                                        N/A
                                    @endif</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>

    @if($poliza_tipo->movimientos)
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">Movimientos</h3>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="box-body">
                                    <table class="table table-bordered table-striped ">
                                        <thead>
                                        <tr>
                                            <th>Tipo de Cuenta Contable</th>
                                            <th>Cargo</th>
                                            <th>Abono</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($poliza_tipo->movimientos as $movimieto)
                                            <tr>
                                                <td>{{$movimieto->tipoCuentaContable}}</td>
                                                <td>
                                                    @if($movimieto->tipoMovimiento->id == 1)
                                                        <span class="fa fa-check-circle"></span>
                                                    @endif
                                                </td>
                                                <td>@if($movimieto->tipoMovimiento->id == 2)
                                                        <span class="fa fa-check-circle"></span>
                                                    @endif
                                                </td>
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