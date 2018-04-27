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
                    <a class="btn btn-success btn-app pull-right" href="{{route('procuracion.asignacion.create')}}" >
                        <i class="glyphicon glyphicon-plus-sign"></i>
                        Registrar Asignación
                    </a>
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
                                        <th></th>
                                        <th><input id="description" name="description" placeholder="Tipo de Transacción" class="form-control" ></th>
                                        <th><input id="numero_folio" name="numero_folio" placeholder="Folio de la Transacción" class="form-control" ></th>
                                        <th></th>
                                        <th><select class="form-control input-sm" name="id_usuario_asignado"
                                                    class="form-control"
                                                    id="id_usuario_asignado"
                                            ><option value>[--SELECCIONE--]
                                                </option>
                                            </select></th>
                                        <th></th>
                                        <th></th>
                                        @permission(['eliminar_asignacion'])
                                        <th width="150"></th>
                                        @endpermission
                                    </tr>
                                    <tr>
                                        <th>Folio de Asignación</th>
                                        <th>Tipo de Transacción</th>
                                        <th>Folio de la Transacción</th>
                                        <th>Concepto</th>
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
            {{--@permission(['registrar_asignacion'])
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success btn-app pull-right" href="{{route('procuracion.asignacion.create')}}" >
                        <i class="glyphicon glyphicon-plus-sign"></i>
                        Registrar Asignación
                    </a>
                </div>
                <div class="col-md-12">&nbsp;</div>
            </div>
            @endpermission--}}
        </section>
    </procuracion-asignacion-index>
@endsection