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
                    <a href="#" class="btn btn-success btn-app" style="float:right" data-toggle="modal" data-target="#create_role_modal" @click="validation_errors.clear('form_save_role')">
                        <i class="glyphicon glyphicon-plus-sign"></i>Nuevo Rol
                    </a>
                    {{-- @endpermission --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Configuración de Usuarios
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="usuarios_roles_table">
                                    <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th style="width:150px">Roles</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Roles</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Administración de Roles y Permisos
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
            <div class="modal fade" id="edit_role_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Editar Rol</h4>
                        </div>
                        <form id="form_update_role" @submit.prevent="validateForm('form_update_role', 'update_role')"  data-vv-scope="form_update_role">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_update_role.Nombre')}">
                                        <label><b>Nombre</b></label>
                                        <input type="text" :name="'Nombre'" v-validate="'required'" id="nombre_edit" class="form-control input-sm" v-model="role.display_name">
                                        <label class="help" v-show="validation_errors.has('form_update_role.Nombre')">@{{ validation_errors.first('form_update_role.Nombre') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_update_role.Descripción')}">
                                        <label><b>Descripción</b></label>
                                        <input type="text" :name="'Descripción'" v-validate="'required'" class="form-control input-sm" v-model="role.description">
                                        <label class="help" v-show="validation_errors.has('form_update_role.Descripción')">@{{ validation_errors.first('form_update_role.Descripción') }}</label>
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
                                                    <td><input type="checkbox" :value="permiso.id"  v-if="!_.isEmpty(role)" v-model="permisos_alta"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cerrar</button>
                            <button type="submit" :disabled="guardando" class="btn btn-primary">
                                <span v-if="guardando">
                                    <i class="fa fa-spin fa-spinner"></i> Guardando
                                </span>
                                <span v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de Creación de Nuevos Roles en Módulo de Seguridad -->
            <div class="modal fade" id="create_role_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Crear Rol</h4>
                        </div>
                        <form id="form_save_role" @submit.prevent="validateForm('form_save_role', 'save_role')"  data-vv-scope="form_save_role">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_save_role.Nombre')}">
                                        <label><b>Nombre</b></label>
                                        <input type="text" :name="'Nombre'" v-validate="'required'" id="display_name" class="form-control input-sm" v-model="role.display_name">
                                        <label class="help" v-show="validation_errors.has('form_save_role.Nombre')">@{{ validation_errors.first('form_save_role.Nombre') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_save_role.Nombre Corto')}">
                                        <label><b>Nombre Corto</b></label>
                                        <input type="text" :name="'Nombre Corto'" v-validate="'required'" id="name" class="form-control input-sm" disabled="disabled" v-model="nombre_corto">
                                        <label class="help" v-show="validation_errors.has('form_save_role.Nombre Corto')">@{{ validation_errors.first('form_save_role.Nombre Corto') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_save_role.Descripción')}">
                                        <label><b>Descripción</b></label>
                                        <input type="text" :name="'Descripción'" v-validate="'required'" class="form-control input-sm" v-model="role.description">
                                        <label class="help" v-show="validation_errors.has('form_save_role.Descripción')">@{{ validation_errors.first('form_save_role.Descripción') }}</label>
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
                                                    <td><input type="checkbox" :value="permiso.id" v-model="permisos_alta"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cerrar</button>
                            <button type="submit" :disabled="guardando" class="btn btn-primary">
                                <span v-if="guardando">
                                    <i class="fa fa-spin fa-spinner"></i> Guardando
                                </span>
                                <span v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de Asignacion de Rol a usuario en Módulo de Seguridad -->
            <div class="modal fade" id="edit_role_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Editar Rol Usuario</h4>
                        </div>
                        <form id="form_update_role_user" @submit.prevent="validateForm('form_update_role_user', 'update_role_user')"  data-vv-scope="form_update_role_user">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group" >
                                            <label><b>Usuario</b></label>
                                            <br><label v-text="usuario.usuario" ></label>

                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group" >
                                            <label><b>Nombre</b></label>
                                            <br><label v-text="usuario.nombre" ></label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><b>Roles</b></label>
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
                                                    <tr v-for="rol in roles">
                                                        <td>@{{ rol.display_name }}</td>
                                                        <td>@{{ rol.description }}</td>
                                                        <td><input type="checkbox" :value="rol.id"  v-if="!_.isEmpty(role)" v-model="rol_usuario_alta"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cerrar</button>
                                <button type="submit" :disabled="guardando" class="btn btn-primary">
                                <span v-if="guardando">
                                    <i class="fa fa-spin fa-spinner"></i> Guardando
                                </span>
                                    <span v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </configuracion-seguridad-index>
@endsection

