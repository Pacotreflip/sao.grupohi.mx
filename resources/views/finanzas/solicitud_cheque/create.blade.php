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
                    <reposicion-fondo-fijo-create class="tab-pane active" id="tab_reposicion_fondo_fijo" inline-template v-cloak>
                        <section>
                            <div class="row">
                                <!-- Fecha de la Transaccion -->
                                <div class="col-md-6 col-md-offset-6">
                                    <div class="form-group">
                                        <label for="fecha"><b>Fecha</b></label>
                                        <input type="text" name="Fecha" class="form-control input-sm"
                                               id="fecha" v-validate="'required'" v-model="form.fecha"
                                               v-datepicker>
                                    </div>
                                </div>

                                <!-- Fecha de Cheque / Cumplimiento -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cumplimiento"><b>Fecha de Cheque</b></label>
                                        <input type="text" name="Fecha de Cheque" class="form-control input-sm"
                                               id="cumplimiento" v-validate="'required'" v-model="form.cumplimiento"
                                               v-datepicker>
                                    </div>
                                </div>

                                <!-- Fecha de Cobro / Vencimiento -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vencimiento"><b>Fecha de Cobro</b></label>
                                        <input type="text" name="Fecha de Cobro" class="form-control input-sm"
                                               id="vencimiento" v-validate="'required'" v-model="form.vencimiento"
                                               v-datepicker>
                                    </div>
                                </div>

                                <!-- Comprobante de Fondo Fijo -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_antecedente"><b>Comprobante de Fondo Fijo *</b></label>
                                        <select type="text" name="Comprobande de Fondo Fijo" class="form-control input-sm"
                                                id="id_antecedente" v-validate="'required'" v-model="form.id_antecedente" @change="test"></select>
                                    </div>
                                </div>

                                <!-- A favor de -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="destino"><b>A favor de</b></label>
                                        <input type="text" name="A favor de" class="form-control input-sm"
                                               id="destino" v-validate="'required'" v-model="form.destino" :readonly="form.id_antecedente.length > 0">
                                    </div>
                                </div>

                                <hr>
                                <div class="col-md-12" v-if="!cargando">
                                    <div class="form-group">
                                        <label for="destino"><b>Destino</b></label>
                                        <select2 id="id_referente_select" :disabled="cargando" v-model="form.id_referente" :options="fondos" @change=""></select2>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="observaciones"><b>Oservaciones</b></label>
                                        <textarea class="form-control" v-model="form.observaciones"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3 col-md-offset-9">
                                    <div class="form-group">
                                        <label for="observaciones"><b>Importe PESOS</b></label>
                                        <input type="number" step="any" class="form-control input-sm" v-model="form.monto">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </reposicion-fondo-fijo-create>
                </div>
            </div>
        </div>
    </div>
@endsection
