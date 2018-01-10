@extends('control_presupuesto.layout')
@section('title', 'Control presupuesto')
@section('contentheader_title', 'CONTROL DE CAMBIOS AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.index') !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-sm-12">

            <a  href="{{ route('control_presupuesto.cambio_presupuesto.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
            </a>

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Solicitudes de cambio</h3>
                </div>

                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">

                            <table class="table table-bordered table-striped dataTable" role="grid" id="order">
                                <thead>
                                <tr role="row">
                                    <th># Folio</th>
                                    <th>Fondo Fijo</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Referencia</th>
                                    <th>Fecha de Alta</th>
                                    <th>Acciones</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th># Folio</th>
                                    <th>Fondo Fijo</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Referencia</th>
                                    <th>Fecha de Alta</th>
                                    <th>Acciones</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
