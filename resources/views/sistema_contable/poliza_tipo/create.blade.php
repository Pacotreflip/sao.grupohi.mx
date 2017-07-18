@extends('sistema_contable.layout')
@section('title', 'Plantillas de Pre-Pólizas')
@section('contentheader_title', 'PLANTILLAS DE PRE-PÓLIZAS')
@section('contentheader_description', '(NUEVA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_tipo.create') !!}

    <global-errors></global-errors>
    <poliza-tipo-create
                v-cloak
                v-bind:tipos_movimiento="{{ $tipos_movimiento }}"
                v-bind:tipos_cuentas_contables="{{ $tipos_cuentas_contables }}"
                v-bind:polizas_tipo_sao="{{ $polizas_tipo_sao }}"
                inline-template>
            <section>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos de la Plantilla </h3>
                    </div>
                    <form id="form_save_poliza_tipo" @submit.prevent="validateForm('form_save_poliza_tipo', 'save')"  data-vv-scope="form_save_poliza_tipo">
                        <div class="box-body">
                            <div class="col-md-5">
                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_poliza_tipo.Tipo de Póliza')}">
                                    <label for="id_transaccion_interfaz"><b>Tipo de Póliza</b></label>
                                    <select2 :name="'Tipo de Póliza'" v-validate="'required'" class="form-control" :options="polizas_tipo_sao" v-model="form.poliza_tipo.id_poliza_tipo_sao">
                                        <option disabled value>[-SELECCIONE-]</option>
                                    </select2>
                                    <label class="help" v-show="validation_errors.has('form_save_poliza_tipo.Tipo de Póliza')">@{{ validation_errors.first('form_save_poliza_tipo.Tipo de Póliza') }}</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_poliza_tipo.Inicio de Vigencia')}">
                                    <label for="inicio_vigencia"><b>Inicio de Vigencia</b></label>
                                    <input v-validate="'required'" type="text" id="inicio_vigencia" v-model="form.poliza_tipo.inicio_vigencia" name="Inicio de Vigencia" class="form-control" v-datepicker/>
                                    <label class="help" v-show="validation_errors.has('form_save_poliza_tipo.Inicio de Vigencia')">@{{ validation_errors.first('form_save_poliza_tipo.Inicio de Vigencia') }}</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="add_movimiento"><b>Agregar Movimiento</b></label>
                                    <button type="button" class="btn btn-primary btn-block" @click="show_add_movimiento">
                                        <i class="fa fa-fw fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                        <div class="col-md-12" v-if="check_movimientos">
                            <button type="submit" class="btn btn-primary pull-right" :disabled="guardando">
                                <span v-if="guardando">
                                    <i class="fa fa-spinner fa-spin"></i> Guardando
                                </span>
                                <span v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </span>
                            </button>
                        </div>
                    </div>
                    </form>
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
                                <th>Tipo de Cuenta Contable</th>
                                <th>Tipo de Movimiento</th>
                                <th>Quitar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in form.poliza_tipo.movimientos">
                                <td>@{{ index + 1  }}</td>
                                <td>@{{ getTipoCuentaDescription(item.id_tipo_cuenta_contable) }}</td>
                                <td>@{{ tipos_movimiento[item.id_tipo_movimiento] }}</td>
                                <td><button class="btn-xs btn-danger" @click="remove_movimiento(index)"><i class="fa fa-trash" /></button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- modal Add Movimiento -->
                <div id="modal-add-movimiento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addItemModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" @click="close_add_movimiento" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Agregar Movimiento</h4>
                            </div>
                            <form id="form_save_cuenta" @submit.prevent="validateForm('form_save_cuenta', 'save_cuenta')"  data-vv-scope="form_save_cuenta">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_cuenta.Tipo deCuenta Contable')}">
                                            <label for="id_tipo_cuenta_contable"><b>Tipo de Cuenta Contable</b></label>
                                            <select id="id_tipo_cuenta_contable" name="Tipo deCuenta Contable" v-validate="'required'" class="form-control" v-model="form.movimiento.id_tipo_cuenta_contable">
                                                <option value>[-SELECCIONE-]</option>
                                                <option v-for="tipo_cuenta_contable in tipos_cuentas_contables_disponibles" v-bind:value="tipo_cuenta_contable.id_tipo_cuenta_contable">@{{ tipo_cuenta_contable.descripcion }}</option>
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_save_cuenta.Tipo deCuenta Contable')">@{{ validation_errors.first('form_save_cuenta.Tipo de Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_cuenta.Tipo de Movimiento')}">
                                            <label for="id_tipo_movimiento"><b>Tipo de Movimiento</b></label>
                                            <select id="id_tipo_movimiento" name="Tipo de Movimiento" v-validate="'required'" class="form-control" v-model="form.movimiento.id_tipo_movimiento">
                                                <option value>[-SELECCIONE-]</option>
                                                @foreach($tipos_movimiento as $key => $item)
                                                    <option value="{{$key}}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                            <label class="help" v-show="validation_errors.has('form_save_cuenta.Tipo de Movimiento')">@{{ validation_errors.first('form_save_cuenta.Tipo de Movimiento') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" @click="close_add_movimiento">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </section>
        </poliza-tipo-create>
@endsection
