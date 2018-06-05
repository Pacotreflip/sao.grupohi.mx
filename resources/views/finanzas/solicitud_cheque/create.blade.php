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
                    @permission('registrar_reposicion_fondo_fijo')
                    <li class=""><a href="#tab_reposicion_fondo_fijo" data-toggle="tab" aria-expanded="false">REPOSICIÓN DE FONDO FIJO</a></li>
                    @endpermission
                    @permission('registrar_pago_cuenta')
                    <li class=""><a href="#tab_pago_cuenta" data-toggle="tab" aria-expanded="false">PAGO A CUENTA</a></li>
                    @endpermission
                    <li class="pull-left header"><i class="fa fa-th"></i> Solicitud de Cheque</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab_reposicion_fondo_fijo">
                        <reposicion-fondo-fijo-create v-cloak>
                        </reposicion-fondo-fijo-create>
                    </div>
                    <pago-cuenta-create inline-template v-cloak>
                        <div class="tab-pane" id="tab_pago_cuenta">
                            <section>
                                <div class="row">
                                    <form id="form_pago_cuenta" @submit.prevent="validateForm('form_pago_cuenta', 'save_pago')"  data-vv-scope="form_pago_cuenta">
                                        <!-- Fecha de la Transaccion -->
                                        <div class="col-md-6 col-md-offset-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.Fecha')}">
                                                <label for="fecha"><b>Fecha</b></label>
                                                <input type="text" name="Fecha" class="form-control input-sm"
                                                       id="fecha" v-validate="'required'" v-model="form.fecha"
                                                       v-datepicker>
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.Fecha')">@{{ validation_errors.first('form_pago_cuenta.Fecha') }}</label>
                                            </div>
                                        </div>

                                        <!-- Fecha de Cheque / Cumplimiento -->
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.Fecha de Cheque')}">
                                                <label for="cumplimiento"><b>Fecha de Cheque</b></label>
                                                <input type="text" name="Fecha de Cheque" class="form-control input-sm"
                                                       id="cumplimiento" v-validate="'required'" v-model="form.cumplimiento"
                                                       v-datepicker>
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.Fecha de Cheque')">@{{ validation_errors.first('form_pago_cuenta.Fecha de Cheque') }}</label>
                                            </div>
                                        </div>

                                        <!-- Fecha de Cobro / Vencimiento -->
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.Fecha de Cobro')}">
                                                <label for="vencimiento"><b>Fecha de Cobro</b></label>
                                                <input type="text" name="Fecha de Cobro" class="form-control input-sm"
                                                       id="vencimiento" v-validate="'required'" v-model="form.vencimiento"
                                                       v-datepicker>
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.Fecha de Cobro')">@{{ validation_errors.first('form_pago_cuenta.Fecha de Cobro') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12" v-if="!cargando">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.Destino')}">
                                                <label for="destino"><b>Destino</b></label>
                                                <select2 v-validate="'required'" :name="'Destino'" id="id_empresa_select" :disabled="cargando" v-model="form.id_empresa" :options="empresas"></select2>
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.Destino')">@{{ validation_errors.first('form_pago_cuenta.Destino') }}</label>
                                            </div>
                                        </div>

                                        <!-- A favor de -->
                                        <div class="col-md-12">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.A favor de')}">
                                                <label for="destino"><b>A favor de</b></label>
                                                <input type="text" name="A favor de" class="form-control input-sm" readonly
                                                       id="destino" v-validate="'required'" v-model="form.destino">
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.A favor de')">@{{ validation_errors.first('form_pago_cuenta.A favor de') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="observaciones"><b>Oservaciones</b></label>
                                                <textarea class="form-control" v-model="form.observaciones"></textarea>
                                            </div>
                                        </div>

                                        <!-- Tipo de Gasto -->
                                        <div class="col-md-12" :class="{'has-error': validation_errors.has('form_pago_cuenta.Tipo de Gasto')}">
                                            <label for="id_costo"><b>Tipo de Gasto</b></label>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.Tipo de Gasto')}">                                
                                                <input class="form-control" v-model="form.id_costo" type="hidden" name="Tipo de Gasto" v-validate="'required'" id="id_costo">
                                                <input type="text" class="form-control" readonly id="costo" placeholder="Seleccionar Tipo de Gasto...">
                                                <span class="input-group-btn">
                                                    <button data-toggle="modal" data-target="#myModal" class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                            <div :class="{'has-error': validation_errors.has('form_pago_cuenta.Tipo de Gasto')}">
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.Tipo de Gasto')">@{{ validation_errors.first('form_pago_cuenta.Tipo de Gasto') }}</label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 col-md-offset-9">
                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_pago_cuenta.Importe')}">
                                                <label for="observaciones"><b>Importe PESOS</b></label>
                                                <input style="text-align: right" name="Importe" v-validate="'required'" type="number" step="any" class="form-control input-sm " v-model="form.monto">
                                                <label class="help" v-show="validation_errors.has('form_pago_cuenta.Importe')">@{{ validation_errors.first('form_pago_cuenta.Importe') }}</label>
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

                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="arbolCostos" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"  aria-label="Close" data-dismiss="modal">
                                                    <span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title">
                                                    <span >
                                                        Costos
                                                    </span>
                                                </h4>
                                            </div>
                                            <div class="modal-body" style="overflow-x: auto;">
                                                <div id="jstree"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </pago-cuenta-create>
                </div>
            </div>
        </div>
    </div>
@endsection
