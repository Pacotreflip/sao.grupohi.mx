@extends('sistema_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'PLANTILLAS DE PÓLIZA')
@section('contentheader_description', '(NUEVA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_tipo.create') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <poliza-tipo-create
                v-cloak
                v-bind:tipos_movimiento="{{ $tipos_movimiento }}"
                v-bind:cuentas_contables="{{ $cuentas_contables }}"
                v-bind:transacciones_interfaz="{{ $transacciones_interfaz }}"
                inline-template>
            <section>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Información de la Póliza Tipo </h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="id_transaccion_interfaz">Tipo de Póliza</label>
                                <select2 class="form-control" :options="transacciones_interfaz" v-model="form.poliza_tipo.id_transaccion_interfaz" :disabled="form.poliza_tipo.movimientos.length > 0">
                                    <option disabled value>[-SELECCIONE-]</option>
                                </select2>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="inicio_vigencia">Inicio de Vigencia</label>
                                <input type="text" id="inicio_vigencia" v-model="form.poliza_tipo.inicio_vigencia" name="inicio_vigencia" class="form-control" :disabled="form.poliza_tipo.id_transaccion_interfaz == ''" v-datepicker :disabled="form.poliza_tipo.movimientos.length > 0" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="add_movimiento">Agragar Movimiento</label>
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-add-movimiento" @click="reset_movimiento" :disabled="guardando || form.poliza_tipo.id_transaccion_interfaz == ''">
                                    <i class="fa fa-fw fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="form.poliza_tipo.movimientos.length" class="box box-success">
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
                                    <th>Quitar</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item, index) in form.poliza_tipo.movimientos">
                                    <td>@{{ index + 1  }}</td>
                                    <td>@{{ getTipoCuentaDescription(item.id_cuenta_contable) }}</td>
                                    <td>@{{ tipos_movimiento[item.id_tipo_movimiento] }}</td>
                                    <td><button class="btn btn-xs btn-danger" @click="remove_movimiento(index)"><i class="fa fa-trash" /></button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div v-if="check_movimientos">
                    <button type="button" class="btn btn-success" @click="check_duplicity" :disabled="guardando">
                        <span v-if="guardando">
                            <i class="fa fa-spinner fa-spin"></i> Guardando
                        </span>
                        <span v-else>
                            <i class="fa fa-save"></i> Guardar
                        </span>
                    </button>
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
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Información del Movimiento </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_cuenta_contable">Cuenta Contable</label>
                                                <select id="id_cuenta_contable" name="id_cuenta_contable" class="form-control" v-model="form.movimiento.id_cuenta_contable">
                                                    <option value>[-SELECCIONE-]</option>
                                                        <option v-for="cuenta_contable in cuentas_contables_disponibles" v-bind:value="cuenta_contable.id_int_cuenta_contable">@{{ cuenta_contable.tipo_cuenta_contable.descripcion }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_tipo_movimiento">Tipo de Movimiento</label>
                                                <select id="id_tipo_movimiento" name="id_tipo_movimiento" class="form-control" v-model="form.movimiento.id_tipo_movimiento">
                                                    <option value>[-SELECCIONE-]</option>
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
                                <button type="button" class="btn btn-primary" @click="add_movimiento" data-dismiss="modal" :disabled="form.movimiento.id_cuenta_contable == '' || form.movimiento.id_tipo_movimiento == ''">Agregar</button>
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
