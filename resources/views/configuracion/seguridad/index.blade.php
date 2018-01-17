@extends('configuracion.layout')
@section('title', 'Seguridad')
@section('contentheader_title', 'SEGURIDAD')
@section('breadcrumb')
    {!! Breadcrumbs::render('configuracion.seguridad.index') !!}
@endsection
@section('main-content')
    <configuracion-seguridad-index inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-sm-12">
                    {{-- @permission('registrar_comprobante_fondo_fijo') --}}
                    <a href="#" class="btn btn-success btn-app" style="float:right" data-toggle="modal" data-target="#create_role_modal" >
                        <i class="glyphicon glyphicon-plus-sign"></i>Nuevo Rol
                    </a>
                    {{-- @endpermission --}}

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Roles
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="roles_table">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Registro</th>
                                        <th>Permisos</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Registro</th>
                                        <th>Permisos</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Asignacion de Roles en Módulo de Seguridad -->
            <div class="modal fade" id="edit_role_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Editar Rol</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label><b>Nombre</b></label>
                                        <input type="text" id="nombre" class="form-control input-sm" v-model="role.display_name">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label><b>Descripción</b></label>
                                        <input type="text" id="nombre" class="form-control input-sm" v-model="role.description">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Permisos</b></label>
                                        <div class="table-responsive" style="max-height: 350px; overflow-y:scroll;">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>---</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="permiso in permisos">
                                                    <td>@{{ permiso.display_name }}</td>
                                                    <td>@{{ permiso.description }}</td>
                                                    <td><input type="checkbox" :checked="asignado(permiso)" v-if="!_.isEmpty(role)"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Creación de Nuevos Roles en Módulo de Seguridad -->
            <div class="modal fade" id="create_role_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Crear Rol</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Nombre</b></label>
                                        <input type="text" id="display_name" class="form-control input-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Nombre Corto</b></label>
                                        <input type="text" id="display_name" class="form-control input-sm" placeholder="nombre_corto_role">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Descripción</b></label>
                                        <input type="text" id="description" class="form-control input-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Permisos Nuevo Rol</b></label>
                                        <div class="table-responsive" style="max-height: 350px; overflow-y:scroll;">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>---</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="permiso in permisos">
                                                    <td>@{{ permiso.display_name }}</td>
                                                    <td>@{{ permiso.description }}</td>
                                                    <td><input type="checkbox"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </configuracion-seguridad-index>

@endsection

