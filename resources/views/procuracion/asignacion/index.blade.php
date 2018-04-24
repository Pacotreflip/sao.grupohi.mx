@extends('procuracion.layout')
@section('title', 'Asignaciones')
@section('contentheader_title', 'ASIGNACIÓN DE COMPRADORES')
@section('breadcrumb')
    {!! Breadcrumbs::render('procuracion.asignacion.index') !!}
@endsection
@section('main-content')
    <global-errors></global-errors>
    <procuracion-asignacion-index
            :permission = "'{{ \Entrust::can(['eliminar_asignacion']) ? 'true' : 'false' }}'"
            :permission_eliminar_asignacion = "'{{ \Entrust::can(['eliminar_asignacion']) ? 'true' : 'false' }}'"
            inline-template
            v-cloak>
        <section>
            @permission(['registrar_asignacion'])
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-sm btn-primary pull-right" href="{{route('procuracion.asignacion.create')}}" >Registrar Asignación</a>
                </div>
                <div class="col-md-12">&nbsp;</div>
            </div>
            @endpermission

            @permission(['consultar_asignacion'])
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Asignaciones</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="asignacion_table">
                                    <thead>
                                    <tr>
                                        <th>Folio de Asignación</th>
                                        <th>Tipo de Transacción</th>
                                        <th>Folio de la Transacciones</th>
                                        <th>Nombre del Comprador Asignado</th>
                                        <th>Fecha de Registro</th>
                                        <th>Persona que Registro</th>
                                        @permission(['eliminar_asignacion'])
                                        <th width="150">Acciones</th>
                                        @endpermission
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endpermission
            @permission(['registrar_asignacion'])
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-sm btn-primary pull-right" href="{{route('procuracion.asignacion.create')}}" >Registrar Asignación</a>
                </div>
                <div class="col-md-12">&nbsp;</div>
            </div>
            @endpermission
        </section>
    </procuracion-asignacion-index>
@endsection