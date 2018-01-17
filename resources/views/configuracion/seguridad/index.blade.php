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
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Roles y Permisos
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="roles_table">
                                    <thead>
                                    <tr>
                                        <th><input type="text" placeholder="Buscar Permiso" class="input-sm form-control" v-model="searchQuery"></th>
                                        <th v-for="role in roles">
                                            <a href="#">@{{ role.display_name }}</a>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="permission in filteredPermissions">
                                        <th><a href="#">@{{ permission.display_name }}</a></th>
                                        <th v-for="role in roles">
                                            @{{ role.name }}
                                        </th>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th v-for="role in roles">
                                            <a>@{{ role.display_name }}</a>
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </configuracion-seguridad-index>

@endsection

