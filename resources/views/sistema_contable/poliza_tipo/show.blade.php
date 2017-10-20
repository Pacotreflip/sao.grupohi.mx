@extends('sistema_contable.layout')
@section('title', 'Plantillas de Prepólizas')
@section('contentheader_title', 'PLANTILLAS DE PREPÓLIZAS')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_tipo.show', $poliza_tipo) !!}

    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de la Plantilla</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Tipo de Póliza</strong>
                    <p class="text-muted">{{ $poliza_tipo->polizaTipoSAO }}</p>
                    <hr>

                    <strong>Usuario que Registró</strong>
                    <p class="text-muted">{{ $poliza_tipo->userRegistro }}</p>
                    <hr>

                    <strong>Fecha y Hora de Registro</strong>
                    <p>{{$poliza_tipo->created_at->format('Y-m-d h:i:s a')}}</p>
                    <hr>

                    <strong>Inicio de Vigencia</strong>
                    <p>{{$poliza_tipo->inicio_vigencia->format('Y-m-d h:i:s a')}}</p>
                    <hr>

                    <strong>Fin de Vigencia</strong>
                    <p>{{ $poliza_tipo->fin_vigencia ? $poliza_tipo->fin_vigencia->format('Y-m-d h:i:s a') : 'N/A' }}</p>
                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        @if($poliza_tipo->movimientos)
            <div class="col-md-9">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Movimientos</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
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
                                        <td class="text-center">
                                            @if($movimieto->tipoMovimiento->id == 1)
                                                <span class="fa fa-check-circle"></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($movimieto->tipoMovimiento->id == 2)
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
        @endif
    </div>
@endsection