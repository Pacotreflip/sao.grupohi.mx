@extends('modulo_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'PLANTILLAS DE PÓLIZA')
@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.show', $poliza_tipo) !!}
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $poliza_tipo->transaccion }} &nbsp;  @if($poliza_tipo->vigente)
                                <span class="label label-success">Vigente</span>
                            @else
                                <span class="label label-danger">No Vigente</span>
                            @endif</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="col-sm-6">
                            <dl>
                                <dt>ID</dt>
                                <dd>{{$poliza_tipo->id}}</dd>
                                <dt>USUARIO QUE REGISTRÓ</dt>
                                <dd>{{$poliza_tipo->userRegistro}}</dd>
                                <dt>FECHA Y HORA DE REGISTRO</dt>
                                <dd>{{$poliza_tipo->created_at->format('Y-m-d h:i:s a')}}</dd>
                                <dt>VIGENCIA</dt>
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl>
                                <dt>INICIO DE VIGENCIA</dt>
                                <dd>{{$poliza_tipo->inicio_vigencia->format('Y-m-d')}}</dd>
                                <dt>FIN DE VIGENCIA</dt>
                                <dd>@if($poliza_tipo->fin_vigencia){{$poliza_tipo->fin_vigencia->format('Y-m-d')}}@else
                                        N/A @endif</dd>
                            </dl>
                        </div>

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
                                            <th>Cuenta Contable</th>
                                            <th>Cargo</th>
                                            <th>Abono</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($poliza_tipo->movimientos as $movimieto)
                                            <tr>
                                                <td>{{$movimieto->cuentaContable->tipoCuentaContable}}</td>
                                                <td>@if($movimieto->tipoMovimiento->id==1)<span
                                                            class="fa fa-check-circle"></span>@endif</td>
                                                <td>@if($movimieto->tipoMovimiento->id==2)<span
                                                            class="fa fa-check-circle"></span>@endif</td>
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