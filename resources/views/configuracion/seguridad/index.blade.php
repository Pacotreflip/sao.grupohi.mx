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
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Roles
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table" id="roles_table">
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
        </section>
    </configuracion-seguridad-index>

@endsection

