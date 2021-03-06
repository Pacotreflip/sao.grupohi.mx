@extends('sistema_contable.layout')
@section('title', 'Pólizas Generadas')
@section('contentheader_title', 'PREPÓLIZAS GENERADAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.edit', $poliza) !!}
@endsection
@section('main-content')

    <poliza-generada-edit
                :poliza="{{$poliza}}"
                :poliza_edit="{{$poliza}}"
                :datos_contables="{{$currentObra->datosContables}}"
                :url_cuenta_contable_findby="'{{route('sistema_contable.cuenta_contable.findby')}}'"
                :url_poliza_generada_update="'{{route('sistema_contable.poliza_generada.update', $poliza)}}'"
                :cuentas_contables="{{$cuentasContables}}"
                :tipo_cuenta_contable="{{$tipoCuentaContable}}"
                :movimientos_cta="{{$movimientosCuenta}}"
                inline-template
                v-cloak>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <a  class="btn btn-app btn-info pull-right" v-on:click="ingresarCuenta({{$poliza->id_int_poliza}})">
                            <i class="fa fa-dollar"></i> Ingresar cuentas faltantes
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Detalle de Prepóliza</h3>
                            </div>
                            <form id="form_poliza" @submit.prevent="validateForm('form_poliza','confirm_save')"
                                  data-vv-scope="form_poliza">
                                <div class="box-body">
                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="bg-gray-light">Tipo Póliza SAO:<br><label>{{ $poliza->transaccionInterfaz}}</label></th>
                                                <th class="bg-gray-light">Fecha de Prepóliza:<br><label><input type="text" class="form-control input-sm" id="fecha" name="Fecha de Prepóliza" v-validate="'required'" v-model="data.poliza_edit.fecha" v-datepicker></label></th>
                                                <th class="bg-gray-light">Usuario Solicita:<br><label> {{$poliza->usuario_solicita }}</label></th>
                                                <th class="bg-gray-light">Cuadre:<br><label>$ {{number_format($poliza->cuadre,'2','.',',')}}</label></th>

                                            </tr>
                                            <tr>
                                               <th class="bg-gray-light">Estatus:<br>
                                                   <label>
                                                       <span class="label" style="background-color: {{$poliza->estatusPrepoliza->label}}">{{$poliza->estatusPrepoliza}}</span>
                                                   </label>
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
                                                    @if($poliza->transacciones)
                                                    <br><label>{{ $poliza->transacciones->tipoTransaccion}} - {{ $poliza->transacciones->numero_folio}}</label>
                                                    @elseif($poliza->traspaso)
                                                    <br><label>Traspaso - {{ $poliza->traspaso->numero_folio}}</label>
                                                    @endif
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
                                                <td style="white-space: nowrap">@{{ index + 1 }}</td>
                                                <td class="form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.CuentaContable [' + (index + 1) + ']')}">
                                                    <input :disabled="movimiento.id_tipo_cuenta_contable == 1&&poliza_edit.poliza_movimientos[index]?poliza_edit.poliza_movimientos[index].cuenta_contable!=null?true:false:false" :placeholder="datos_contables.FormatoCuenta" type="text"
                                                           v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                           :name="'CuentaContable [' + (index + 1) + ']'"
                                                           class="form-control input-sm formato_cuenta"
                                                           v-model="movimiento.cuenta_contable">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.CuentaContable [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.CuentaContable [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <td style="white-space: nowrap">
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
                                                           type="text" size="5" v-model="movimiento.referencia">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Referencia [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Referencia [' + (index + 1) + ']') }}</label>
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_poliza.Referencia [' + (index + 1) + ']')">@{{ validation_errors.first('form_poliza.Referencia [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <td class="form-group"
                                                    :class="{'has-error': validation_errors.has('form_poliza.Concepto [' + (index + 1) + ']')}">
                                                    <textarea :name="'Concepto [' + (index + 1) + ']'"
                                                           v-validate="'required'" class="form-control input-sm " rows="3" cols="40" wrap="soft"
                                                              v-model="movimiento.concepto"></textarea>
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
                                                <th colspan="4" class="bg-gray text-right" v-bind:class="color">
                                                    <b>Sumas Iguales</b>
                                                </th>
                                                <th class="bg-gray numerico" v-bind:class="color">
                                                    <b>$&nbsp;@{{(parseFloat(suma_debe)).formatMoney(2,'.',',')}}</b>
                                                </th>
                                                <th class="bg-gray numerico" v-bind:class="color">
                                                    <b>$&nbsp;@{{(parseFloat(suma_haber)).formatMoney(2,'.',',')}}</b>
                                                </th>
                                                <th class="bg-gray" colspan="3" v-bind:class="color"></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                        <div class="col-sm-12" style="text-align: right">
                                            <h4><b>Total de la Prepóliza:</b>
                                                $&nbsp;@{{ (parseFloat(data.poliza_edit.total)).formatMoney(2,'.',',')}}</h4>
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
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
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
                                                       v-validate="'required|decimal'" class="form-control"
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


                <!-- Modal Agregar Cuenta -->
                <div id="add_cuenta_modal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="addCuentaModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-lg">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_cuenta_modal">
                                    <span aria-hidden="true">&times;</span></button>

                                 <h4  class="modal-title">Cuentas faltantes de la Prepóliza</h4>

                            </div>
                            <form id="form_cuenta" @submit.prevent="validateForm('form_cuenta','confirm_save_cuenta')"
                                  data-vv-scope="form_cuenta">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                           <thead>
                                           <tr>
                                                <th>No.</th>
                                                <th>Tipo Cuenta Contable</th>
                                                <th>Cuenta Contable</th>
                                            </tr>
                                           </thead>
                                           <tr v-for="(movimiento, index) in data.movimientos">
                                               <td>
                                                   @{{index+1}}
                                               </td>
                                               <td>
                                                    @{{movimiento.tipo_cuenta_contable?movimiento.tipo_cuenta_contable.descripcion:'No registrada'}}
                                                </td>
                                                <td class="form-group" style="white-space: nowrap;width: 200px"  :class="{'has-error': validation_errors.has('form_cuenta.cuenta_contable [' + (index + 1) + ']')}">
                                                    <input :name="'cuenta_contable [' + (index + 1) + ']'"  :placeholder="datos_contables.FormatoCuenta" type="text" style="width: 200px"
                                                           v-validate="'required|regex:' + datos_contables.FormatoCuentaRegExp"
                                                           :name="'CuentaContable [' + (index + 1) + ']'"
                                                           class="form-control input-sm formato_cuenta"
                                                           v-model="movimiento.cuenta_contable">
                                                    <label class="help"  v-show="validation_errors.has('form_cuenta.cuenta_contable [' + (index + 1) + ']')">@{{ validation_errors.first('form_cuenta.cuenta_contable [' + (index + 1) + ']') }}</label>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-md-12">
                                        <button  class="btn btn-info pull-right" type="submit">
                                            Guardar Cambios
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </section>
        </poliza-generada-edit>
@endsection
