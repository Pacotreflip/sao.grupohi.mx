@extends('layouts.app')
@section('title', 'Polizas Tipo')
@section('contentheader_title', 'POLIZAS TIPO')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.create') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <poliza-tipo-create inline-template>
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Información de la Póliza Tipo </h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_transaccion_interfaz">Tipo de Póliza</label>
                                <select id="id_transaccion_interfaz" name="id_transaccion_interfaz" class="form-control" v-select2 v-model="form.poliza_tipo.id_transaccion_interfaz">
                                    @foreach($transacciones_interfaz as $key => $item)
                                        <option value="{{$key}}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_movimiento">Agragar Movimiento</label>
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-add-movimiento" @click="reset_movimiento">
                                    <i class="fa fa-fw fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="form.poliza_tipo.movimientos.length" class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Movimientos</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Cuenta Contable</th>
                                <th>Tipo de Movimiento</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(index, movimiento) in form.poliza_tipo.movimientos">
                                <td>@{{ index + 1  }}</td>
                                <td>@{{ movimiento.cuenta_contable }}</td>
                                <td>@{{ movimiento.tipo }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- modal Add Movimiento -->
                <div class="modal fade" id="modal-add-movimiento" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Agregar Movimiento</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Información del Movimiento </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_cuenta_contable">Cuenta Contable</label>
                                                <select id="id_cuenta_contable" name="id_cuenta_contable" class="form-control" v-select2 v-model="form.movimiento.id_cuenta_contable" v-select2>
                                                    @foreach($cuentas_contables as $key => $item)
                                                        <option value="{{$key}}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_tipo_movimiento">Tipo de Movimiento</label>
                                                <select id="id_tipo_movimiento" name="id_tipo_movimiento" class="form-control" v-select2 v-model="form.movimiento.id_tipo_movimiento" v-select2>
                                                    @foreach($tipos_movimiento as $key => $item)
                                                        <option value="{{$key}}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="add_movimiento">Agregar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </section>
        </poliza-tipo-create>
    </div>
@endsection