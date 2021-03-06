@extends('sistema_contable.layout')
@section('title', 'Datos Contables')
@section('contentheader_title', 'DATOS CONTABLES')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.datos_contables.edit', $datos_contables) !!}
@endsection
@section('main-content')

    <global-errors></global-errors>
    <datos-contables-edit
            :referencia="'{{$referencia}}'"
            :datos_contables_update_url="'{{route('sistema_contable.datos_contables.update', $datos_contables)}}'"
            :datos_contables="{{$datos_contables}}"
            v-cloak
            inline-template>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <!-- Datos contables de la Obra -->
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h1 class="box-title">{{ $currentObra->nombre }}</h1>
                        </div>
                        <form id="form_datos_obra" @submit.prevent="validateForm('form_datos_obra', 'save_datos_obra')"  data-vv-scope="form_datos_obra">
                            <div class="box-body">
                                <div class="alert alert-warning col-md-12">
                                    <strong>Atención</strong> @{{mostrar_mensaje()}}
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Base de Datos CONTPAQ') }">
                                        <label for="BDContPaq" class="control-label"><b>Base de Datos CONTPAQ</b></label>
                                        <input type="text" v-validate="'required'" name="Base de Datos CONTPAQ" class="form-control" id="BDContPaq" v-model="data.datos_contables.BDContPaq" :disabled="editando()">
                                        <label class="help" v-show="validation_errors.has('form_datos_obra.Base de Datos CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Base de Datos CONTPAQ') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ') }">
                                        <label for="NumobraContPaq" class="control-label"><b>Número de Obra CONTPAQ</b></label>
                                        <input type="number" v-validate="'required|numeric'" name="Numero de Obra CONTPAQ" class="form-control" id="NumobraContPaq" v-model="data.datos_contables.NumobraContPaq" :disabled="editando()">
                                        <label class="help" v-show="validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Numero de Obra CONTPAQ') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Formato de Cuentas') }">
                                        <label for="FormatoCuenta" class="control-label"><b>Formato de Cuentas</b></label>
                                        <input type="text" v-validate="'required|regex:^\#[\#\-]+\#$'" name="Formato de Cuentas" class="form-control" id="FormatoCuenta" v-model="data.datos_contables.FormatoCuenta" :disabled="editando()">
                                        <label class="help" v-show="validation_errors.has('form_datos_obra.Formato de Cuentas')">@{{ validation_errors.first('form_datos_obra.Formato de Cuentas') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"><b>¿Tendrá Afectación Contable de Almacenes?</b></label>
                                        <ul class="list-unstyled">
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="manejo" data-value="1" name="manejo_si" :value="toBoolean('1')" id="manejo_si"
                                                       v-model="data.datos_contables.manejo_almacenes"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.manejo_almacenes, true)"
                                                       v-icheck
                                                />
                                                Si
                                            </li>
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="manejo" data-value="0" name="manejo_no" :value="toBoolean('0')" id="manejo_no"
                                                       v-model="data.datos_contables.manejo_almacenes"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.manejo_almacenes, false)"
                                                       v-icheck />
                                                No
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"><b>Aplicación de Costo</b></label>
                                        <ul class="list-unstyled">
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="gasto" data-value="1" name="gasto_si" :value="toBoolean('1')" id="gasto_si"
                                                       v-model="data.datos_contables.costo_en_tipo_gasto"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.costo_en_tipo_gasto, true)"
                                                       v-icheck
                                                />
                                                Por Tipo de Gasto
                                            </li>
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="gasto" data-value="0" name="gasto_no" :value="toBoolean('0')" id="gasto_no"
                                                       v-model="data.datos_contables.costo_en_tipo_gasto"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.costo_en_tipo_gasto, false)"
                                                       v-icheck
                                                />
                                                Por Conceptos Presupuesto
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"><b>Retención de Fondo de Garantía</b></label><br>
                                        <ul class="list-unstyled">
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="retencion_antes_iva" data-value="1" name="retencion_antes_iva_si" :value="toBoolean('1')" id="retencion_antes_iva_si"
                                                       v-model="data.datos_contables.retencion_antes_iva"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.retencion_antes_iva, true)"
                                                       v-icheck
                                                />
                                                Antes de IVA
                                            </li>
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="retencion_antes_iva" data-value="0" name="retencion_antes_iva_no" :value="toBoolean('0')" id="retencion_antes_iva_no"
                                                       v-model="data.datos_contables.retencion_antes_iva"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.retencion_antes_iva, false)"
                                                       v-icheck
                                                />
                                                Después de IVA
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"><b>Aplicación de Deductivas</b></label><br>
                                        <ul class="list-unstyled">
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="deductiva_antes_iva" data-value="1" name="deductiva_antes_iva_si" :value="toBoolean('1')" id="deductiva_antes_iva_si"
                                                       v-model="data.datos_contables.deductiva_antes_iva"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.deductiva_antes_iva, true)"
                                                       v-icheck
                                                />
                                                Antes de IVA
                                            </li>
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="deductiva_antes_iva" data-value="0" name="deductiva_antes_iva_no" :value="toBoolean('0')" id="deductiva_antes_iva_no"
                                                       v-model="data.datos_contables.deductiva_antes_iva"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.deductiva_antes_iva, false)"
                                                       v-icheck
                                                />
                                                Después de IVA
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"><b>Amortización de Anticipo</b></label><br>
                                        <ul class="list-unstyled">
                                            <li>
                                                <input type="radio" class="checkboxes" data-name="amortizacion_antes_iva" data-value="1" name="amortizacion_antes_iva_si" :value="toBoolean('1')" id="amortizacion_antes_iva_si"
                                                       v-model="data.datos_contables.amortizacion_antes_iva"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.amortizacion_antes_iva, true)"
                                                       v-icheck
                                                />
                                                Antes de IVA
                                            </li>
                                            <li>
                                                <input type="radio"  class="checkboxes" data-name="amortizacion_antes_iva" data-value="0" name="amortizacion_antes_iva_no" :value="toBoolean('0')" id="amortizacion_antes_iva_no"
                                                       v-model="data.datos_contables.amortizacion_antes_iva"
                                                       :disabled="editando()"
                                                       :checked="checkBox(data.datos_contables.amortizacion_antes_iva, false)"
                                                       v-icheck
                                                />
                                                Después de IVA
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-12" v-show="!editando()">
                                    <button type="submit" class="btn btn-info pull-right" :disabled="guardando">
                                        <span v-if="guardando">
                                            <i class="fa fa-spinner fa-spin"></i> Guardando
                                        </span>
                                        <span v-else>
                                            <i class="fa fa-save"></i> Guardar
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </datos-contables-edit>
@endsection