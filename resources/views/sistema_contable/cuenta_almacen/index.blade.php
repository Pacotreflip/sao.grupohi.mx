@extends('sistema_contable.layout')
@section('title', 'Cuentas Almacenes')
@section('contentheader_title', 'CUENTAS DE ALMACENES')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_almacen.index') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <cuenta-almacen-create
                :almacenes="{{$almacenes}}"
                :url_cuenta_almacen_store="{{route('sistema_contable.cuenta_almacen.store')}}"
                :url_cuenta_almacen="{{route('sistema_contable.cuenta_almacen.index')}}"
                v-cloak
                inline-template>
            <section>
            <div class="row" >
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cuentas de Almacenes</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="row table-responsive">
                                    <table  class="table table-bordered table-striped small index_table" role="grid"
                                            aria-describedby="tipo_cuenta_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Almacén</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Cuenta Contable</th>
                                            <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.almacenes">
                                            <td>@{{ index + 1 }}</td>
                                            <td>@{{ item.descripcion  }}</td>
                                            <td v-if="item.cuenta_almacen != null">
                                                @{{ item.cuenta_almacen.cuenta }}
                                            </td>
                                            <td v-else>
                                                Cuenta sin Registrar
                                            </td>
                                            <td style="min-width: 90px;max-width: 90px">
                                                <div class="btn-group">
                                                    <a href="url_cuenta_almacen + '/' + item.id_almacen" type="button" class="btn btn-xs btn-default">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modal-configurar-cuenta-almacen"  v-on:click="editar({{$item}})">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                                    </tr>


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Almacén</th>
                                                <th>Cuenta Contable</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </div>
                </div>
                <!-- Modal Editar Configuración de Cuenta -->
                <div class="modal fade" id="modal-configurar-cuenta-almacen" style="display: none;" id="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Modificar Cuenta de Almacén</h4>
                            </div>
                            <form class="form-horizontal" id="form_cuenta_almacen_update" data-vv-scope="form_cuenta_almacen_update">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div  class="form-group" >
                                            <label for="cuenta">Cuenta</label>
                                            <input  type="text" class="form-control" name="Cuenta" id="cuenta" />
                                            <label class="help"</label>
                                        </div>
                                    </div>


                                    <div class="box-footer">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="closeModal">Cerrar</button>
                                            <button type="submit" class="btn btn-info pull-right"   >
                                                <i class="fa fa-save"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Editar Configuración de Cuenta -->

            </div>



            </section>
        </cuenta-almacen-create>
    </div>

@endsection