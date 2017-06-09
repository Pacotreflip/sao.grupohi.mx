@extends('modulo_contable.layout')
@section('title', 'Polizas Tipo')
@section('contentheader_title', 'POLIZAS TIPO')
@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.create') !!}
    <hr>


    <div class="row">
        <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">Póliza Tipo: {{$poliza_tipo->transaccionInterfaz}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>ID</dt>
                    <dd>{{$poliza_tipo->id}}</dd>
                    <dt>Usuario que Registró</dt>
                    <dd>{{$poliza_tipo->userRegistro}}</dd>
                    <dt>Fecha y Hora de Registro</dt>
                    <dd>{{$poliza_tipo->created_at->format('Y-m-d h:i:s a')}}</dd>
                </dl>
            </div>
            <!-- /.box-body -->
        </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Movimientos</h3>

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="box-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Cuenta Contable</th>
                                        <th>Cargo</th>
                                        <th>Abono</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($movimientos as $movimieto)
                                    <tr>
                                        <td>$movimieto</td>
                                        <td></td>
                                        <td></td>
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
@endsection