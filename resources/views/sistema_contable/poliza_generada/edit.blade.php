@extends('sistema_contable.layout')
@section('title', 'Pólizas Generadas')
@section('contentheader_title', 'PRE-PÓLIZAS GENERADAS')
@section('contentheader_description', '(EDICIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.edit', $poliza) !!}

    <poliza-generada-edit
                :poliza="{{$poliza}}"
                :poliza_edit="{{$poliza}}"
                :datos_contables="{{$currentObra->datosContables}}"
                :url_cuenta_contable_findby="'{{route('sistema_contable.cuenta_contable.findby')}}'"
                :url_poliza_generada_update="'{{route('sistema_contable.poliza_generada.update', $poliza)}}'"
                :cuentas_contables="{{$cuentasContables}}"
                :tipo_cuenta_contable="{{$tipoCuentaContable}}"
                inline-template
                v-cloak>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Detalle de Pre-Póliza</h3>
                            </div>
                            <form id="form_poliza" @submit.prevent="validateForm('form_poliza','confirm_save')"
                                  data-vv-scope="form_poliza">
                                <div class="box-body">
                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <tr>
                                                <th  class="bg-gray-light">Tipo Póliza SAO:<br><label>{{ $poliza->transaccionInterfaz}}</label></th>
                                                <th class="bg-gray-light">Fecha de Solicitud:<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a')}}</label></th>
                                                <th  class="bg-gray-light">Usuario Solicita:<br><label> {{$poliza->usuario_solicita }}</label></th>
                                                <th class="bg-gray-light">Cuadre:<br><label>$ {{number_format($poliza->cuadre,'2','.',',')}}</label></th>

                                            </tr>
                                            <tr>
                                               <th class="bg-gray-light">Estatus:<br><label>
                                                        @if($poliza->estatus == $poliza::REGISTRADA) <span class="label bg-blue">Registrada</span>@endif
                                                        @if($poliza->estatus == $poliza::LANZADA) <span class="label bg-green">Lanzada</span>@endif
                                                        @if($poliza->estatus == $poliza::NO_LANZADA) <span class="label bg-yellow">No lanzada</span>@endif
                                                        @if($poliza->estatus == $poliza::CON_ERRORES) <span class="label bg-red">Con errores</span>@endif</label>
                                                </th>
                                                <th class="bg-gray-light">
                                                    Póliza Contpaq:<br>
                                                    <label>{{$poliza->poliza_contpaq}}</label>
                                                </th>
                                                <th class="bg-gray-light">
                                                    Tipo de Póliza:
                                                    <br><label> {{ $poliza->tipoPolizaContpaq}}</label>
                                                </th>
                                                <th class="bg-gray-light">
                                                    Transacción Antecedente:
                                                    <br><label> {{ $poliza->transacciones->tipoTransaccion}} - {{ $poliza->transacciones->numero_folio}}</label>
                                                </th>
                                            </tr>
                                            <tr>

                                                <th class="bg-gray-light" colspan="4" class="bg-gray-light form-group" :class="{'has-error': validation_errors.has('form_poliza.Concepto')}">
                                                    Concepto:<br>
                                                    <textarea name="Concepto" type="text" v-validate="'required'"
                                                           class="form-control input-sm"
                                                              v-model="data.poliza_edit.concepto" style="resize: none"></textarea>
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Concepto')">@{{ validation_errors.first('form_poliza.Concepto') }}</label>
                                                </th>

                                            </tr>
                                        </table>

                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="bg-gray-light">#</th>
                                                <th class="bg-gray-light">Cuenta Contable</th>
                                                <th class="bg-gray-light">Tipo Cuenta Contable</th>
                                                <th class="bg-gray-light">Tipo</th>
                                                <th class="bg-gray-light">Debe</th>
                                                <th class="bg-gray-light">Haber</th>
                                                <th class="bg-gray-light">Referencia</th>
                                                <th class="bg-gray-light">Concepto</th>
                                                <th class="bg-gray-light">
                                                    <button class="btn btn-xs btn-success" type="button"
                                                            @click="show_add_movimiento" title="Nuevo"><i class="fa fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(movimiento, index) in data.poliza_edit.poliza_movimientos">
                                                <td>@{{ index + 1 }}</td>
                                                <td class="form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.CuentaContable [' + (index + 1) + ']')}">
                                                    <input :placeholder="datos_contables.FormatoCuenta" type="text"
                                                           v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                           :name="'CuentaContable [' + (index + 1) + ']'"
                                                           class="form-control input-sm formato_cuenta"
                                                           v-model="movimiento.cuenta_contable">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.CuentaContable [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.CuentaContable [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <td>
                                                    @{{movimiento.tipo_cuenta_contable?movimiento.tipo_cuenta_contable.descripcion:'No registrada'}}</td>
                                                <td class="form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.Tipo [' + (index + 1) + ']')}">
                                                    <select :name="'Tipo [' + (index + 1) + ']'"
                                                            v-validate="'required|numeric'"
                                                            class="form-control input-sm"
                                                            v-model="movimiento.id_tipo_movimiento_poliza">
                                                        <option :value="1">Cargo</option>
                                                        <option :value="2">Abono</option>
                                                    </select>
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Tipo [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Tipo [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <td class="bg-gray-light numerico form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.Importe [' + (index + 1) + ']')}">
                                                <span v-if="movimiento.id_tipo_movimiento_poliza == 1">
                                                    <input v-validate="'required'"
                                                           :name="'Importe [' + (index + 1) + ']'" type="number"
                                                           step="any" class="form-control input-sm text-right"
                                                           v-model="movimiento.importe">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Importe [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Importe [' + (index + 1) + ']') }}</label>
                                                </span>
                                                </td>
                                                <td class="bg-gray-light numerico form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.Importe [' + (index + 1) + ']')}">
                                                <span v-if="movimiento.id_tipo_movimiento_poliza == 2">
                                                    <input v-validate="'required'"
                                                           :name="'Importe [' + (index + 1) + ']'" type="number"
                                                           step="any" class="form-control input-sm text-right"
                                                           v-model="movimiento.importe">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Importe [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Importe [' + (index + 1) + ']') }}</label>
                                                </span>
                                                </td>
                                                <td class="form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.Referencia [' + (index + 1) + ']')}">
                                                    <input :name="'Referencia [' + (index + 1) + ']'"
                                                           v-validate="'required'" class="form-control input-sm"
                                                           type="text" v-model="movimiento.referencia">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Referencia [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Referencia [' + (index + 1) + ']') }}</label>
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Referencia [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Referencia [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <td class="form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.Concepto [' + (index + 1) + ']')}">
                                                    <input :name="'Concepto [' + (index + 1) + ']'"
                                                           v-validate="'required'" class="form-control input-sm"
                                                           type="text" v-model="movimiento.concepto">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Concepto [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Concepto [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <th class="bg-gray-light">
                                                    <button class="btn btn-xs btn-danger" type="button"
                                                            @click="confirm_remove_movimiento(index)" title="Eliminar"><i
                                                                class="fa fa-remove"></i></button>
                                                </th>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="4" class="bg-gray text-right">
                                                    <b>Sumas Iguales</b>
                                                </th>
                                                <th class="bg-gray numerico">
                                                    <b>$ @{{(parseFloat(suma_debe)).formatMoney(2,'.',',')}}</b>
                                                </th>
                                                <th class="bg-gray numerico">
                                                    <b>$ @{{(parseFloat(suma_haber)).formatMoney(2,'.',',')}}</b>
                                                </th>
                                                <th class="bg-gray" colspan="3"></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <div class="col-sm-12" style="text-align: right">
                                            <h4><b>Total de la Pre-Póliza:</b>
                                                $ @{{ (parseFloat(data.poliza_edit.total)).formatMoney(2,'.',',')}}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-md-12">
                                        <button :disabled="! cambio" class="btn btn-info pull-right" type="submit">
                                            Guardar Cambios
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Agregar Movimiento -->
                <div id="add_movimiento_modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="addMovimientoModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-lg">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_add_movimiento">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Agregar Movimiento</h4>
                            </div>
                            <form id="form_add_movimiento"
                                  @submit.prevent="validateForm('form_add_movimiento','confirm_add_movimiento')"
                                  data-vv-scope="form_add_movimiento">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_add_movimiento.Tipo de Cuenta')}">
                                                <label for="">Tipo de cuenta</label>
                                                <select name="Tipo de Cuenta" class="form-control"
                                                        v-validate="'required|numeric'"
                                                        v-model="form.movimiento.id_tipo_cuenta_contable"
                                                        v-on:change="obtener_numero_cuenta(form.movimiento.id_tipo_cuenta_contable)">
                                                    <option value disabled>[-SELECCIONE-]</option>
                                                    <option v-for="(tipo_cuenta_contable, index) in tipo_cuenta_contable"
                                                            :value="index">@{{ tipo_cuenta_contable }}</option>
                                                </select>
                                                <label class="help"
                                                       v-show="validation_errors.has('form_add_movimiento.Tipo de Cuenta')">@{{ validation_errors.first('form_add_movimiento.Tipo de Cuenta') }}</label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_add_movimiento.Cuenta Contable')}">
                                                <label for="">Cuenta Contable</label>
                                                <input :placeholder="datos_contables.FormatoCuenta" type="text"
                                                       v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                       class="form-control formato_cuenta" name="Cuenta Contable"
                                                       v-model="form.movimiento.cuenta_contable">
                                                <label class="help"
                                                       v-show="validation_errors.has('form_add_movimiento.Cuenta Contable')">@{{ validation_errors.first('form_add_movimiento.Cuenta Contable') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_add_movimiento.Tipo')}">
                                                <label for="">Tipo</label>
                                                <select name="Tipo" v-validate="'required|numeric'" class="form-control"
                                                        v-model="form.movimiento.id_tipo_movimiento_poliza">
                                                    <option value disabled>[-SELECCIONE-]</option>
                                                    <option :value="1">Cargo</option>
                                                    <option :value="2">Abono</option>
                                                </select>
                                                <label class="help"
                                                       v-show="validation_errors.has('form_add_movimiento.Tipo')">@{{ validation_errors.first('form_add_movimiento.Tipo') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_add_movimiento.Importe')}">
                                                <label for="">Importe</label>
                                                <input type="number" step="any"
                                                       v-validate="'required|decimal|min_value:0'" class="form-control"
                                                       name="Importe" v-model="form.movimiento.importe">
                                                <label class="help"
                                                       v-show="validation_errors.has('form_add_movimiento.Importe')">@{{ validation_errors.first('form_add_movimiento.Importe') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_add_movimiento.Referencia')}">
                                                <label for="">Referencia</label>
                                                <input type="text" v-validate="'required'" class="form-control"
                                                       name="Referencia" v-model="form.movimiento.referencia">
                                                <label class="help"
                                                       v-show="validation_errors.has('form_add_movimiento.Referencia')">@{{ validation_errors.first('form_add_movimiento.Referencia') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 :class="{'has-error': validation_errors.has('form_add_movimiento.Concepto')}">
                                                <label for="">Concepto</label>
                                                <input type="text" v-validate="'required'" class="form-control"
                                                       name="Concepto" v-model="form.movimiento.concepto">
                                                <label class="help"
                                                       v-show="validation_errors.has('form_add_movimiento.Concepto')">@{{ validation_errors.first('form_add_movimiento.Concepto') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" @click="close_add_movimiento">Cerrar
                                    </button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </poliza-generada-edit>
@endsection
