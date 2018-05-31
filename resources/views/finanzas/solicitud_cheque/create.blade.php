@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SOLICITUD DE CHEQUE')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.solicitud_cheque.create') !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#tab_reposicion_fondo_fijo" data-toggle="tab" aria-expanded="false">REPOSICIÓN DE FONDO FIJO</a></li>
                    <li class="pull-left header"><i class="fa fa-th"></i> Solicitud de Cheque</li>
                </ul>
                <div class="tab-content">
                    <reposicion-fondo-fijo-create  inline-template v-cloak>
                        <div class="tab-pane active" id="tab_reposicion_fondo_fijo">
                            <section>
                                <div class="row">
                                    <form id="form_reposicion_fondo_fijo" @submit.prevent="validateForm('form_reposicion_fondo_fijo', 'save_reposicion')"  data-vv-scope="form_reposicion_fondo_fijo">
                                        <!-- Fecha de la Transaccion -->
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_reposicion_fondo_fijo.Fecha')}">
                                                <label for="fecha"><b>Fecha</b></label>
                                                <input type="text" name="Fecha" class="form-control input-sm"
                                                       id="fecha" v-validate="'required'" v-model="form.fecha"
                                                       v-datepicker>
                                                <label class="help" v-show="validation_errors.has('form_reposicion_fondo_fijo.Fecha')">@{{ validation_errors.first('form_reposicion_fondo_fijo.Fecha') }}</label>
                                            </div>
                                        </div>

                                        <!-- Fecha de Cheque / Cumplimiento -->
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_reposicion_fondo_fijo.Fecha de Cheque')}">
                                                <label for="cumplimiento"><b>Fecha de Cheque</b></label>
                                                <input type="text" name="Fecha de Cheque" class="form-control input-sm"
                                                       id="cumplimiento" v-validate="'required'" v-model="form.cumplimiento"
                                                       v-datepicker>
                                                <label class="help" v-show="validation_errors.has('form_reposicion_fondo_fijo.Fecha de Cheque')">@{{ validation_errors.first('form_reposicion_fondo_fijo.Fecha de Cheque') }}</label>
                                            </div>
                                        </div>

                                        <!-- Fecha de Cobro / Vencimiento -->
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_reposicion_fondo_fijo.Fecha de Cobro')}">
                                                <label for="vencimiento"><b>Fecha de Cobro</b></label>
                                                <input type="text" name="Fecha de Cobro" class="form-control input-sm"
                                                       id="vencimiento" v-validate="'required'" v-model="form.vencimiento"
                                                       v-datepicker>
                                                <label class="help" v-show="validation_errors.has('form_reposicion_fondo_fijo.Fecha de Cobro')">@{{ validation_errors.first('form_reposicion_fondo_fijo.Fecha de Cobro') }}</label>
                                            </div>
                                        </div>

                                        <!-- Comprobante de Fondo Fijo -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="id_antecedente"><b>Comprobante de Fondo Fijo *</b></label>
                                                <select type="text" name="Comprobande de Fondo Fijo" class="form-control input-sm"
                                                        id="id_antecedente" v-validate="'required'" v-model="form.id_antecedente"></select>
                                            </div>
                                        </div>

                                        <div class="col-md-12" v-if="!cargando">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_reposicion_fondo_fijo.Destino')}">
                                                <label for="destino"><b>Destino</b></label>
                                                <select2 v-validate="'required'" :name="'Destino'" id="id_referente_select" :disabled="cargando || form.id_antecedente != ''" v-model="form.id_referente" :options="fondos"></select2>
                                                <label class="help" v-show="validation_errors.has('form_reposicion_fondo_fijo.Destino')">@{{ validation_errors.first('form_reposicion_fondo_fijo.Destino') }}</label>
                                            </div>
                                        </div>

                                        <!-- A favor de -->
                                        <div class="col-md-12">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_reposicion_fondo_fijo.A favor de')}">
                                                <label for="destino"><b>A favor de</b></label>
                                                <input type="text" name="A favor de" class="form-control input-sm"
                                                       id="destino" v-validate="'required'" v-model="form.destino" :readonly="form.id_antecedente != ''">
                                                <label class="help" v-show="validation_errors.has('form_reposicion_fondo_fijo.A favor de')">@{{ validation_errors.first('form_reposicion_fondo_fijo.A favor de') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="observaciones"><b>Oservaciones</b></label>
                                                <textarea class="form-control" v-model="form.observaciones"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-md-offset-9">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_reposicion_fondo_fijo.Importe')}">
                                                <label for="observaciones"><b>Importe PESOS</b></label>
                                                <input style="text-align: right" name="Importe" v-validate="'required'" type="number" step="any" class="form-control input-sm " :readonly="form.id_antecedente != ''" v-model="form.monto">
                                                <label class="help" v-show="validation_errors.has('form_reposicion_fondo_fijo.Importe')">@{{ validation_errors.first('form_reposicion_fondo_fijo.Importe') }}</label>
                                            </div>
                                        </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary pull-right" :disabled="guardando || cargando">
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
                            </section>
                        </div>
                    </reposicion-fondo-fijo-create>
                </div>
            </div>
        </div>
    </div>
@endsection
