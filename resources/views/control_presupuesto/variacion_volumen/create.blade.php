@extends('control_presupuesto.layout')
@section('title', 'Cambios al Presupuesto')
@section('contentheader_title', 'VARIACIÓN DE VOLÚMEN <small>(ADITIVAS Y DEDUCTIVAS)</small>')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.variacion_volumen.create') !!}
@endsection
@section('main-content')
    <variacion-volumen-create inline-template v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid" v-if="!cargando_tarjetas">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros para consulta de Conceptos</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Número de Tarjeta</b></label>
                                        <select2 id="tarjetas_select" :disabled="cargando" v-model="id_tarjeta" :options="tarjetas">
                                        </select2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-app pull-right" :disabled="!form.partidas.length || cargando || guardando" data-toggle="modal" data-target="#conceptos_modal" @click="validation_errors.clear('form_save_solicitud')">
                        <span class="badge bg-green" >@{{ form.partidas.length }}</span>
                        <i class="fa fa-list-ol"></i> Partidas
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Seleccione los conceptos que desea afectar en ésta solicitud</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="conceptos_table" class="small table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th v-for="nivel in niveles">@{{ nivel.nombre }}</th>
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Monto</th>
                                        <th>Agregar</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th v-for="nivel in niveles">@{{ nivel.nombre }}</th>
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Monto</th>
                                        <th>Agregar</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="conceptos_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ConceptosModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Partidas</h4>
                        </div>
                        <form  id="form_save_solicitud" @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"  data-vv-scope="form_save_solicitud">
                            <div class="modal-body small">
                                <div class="row">
                                    <div class="table-responsive col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">No. Tarjeta</th>
                                                <th class="text-center">Sector</th>
                                                <th class="text-center">Cuadrante</th>
                                                <th class="text-center">Unidad</th>
                                                <th class="text-center">Volumen</th>
                                                <th class="text-center" width="150px">Volumen del Cambio</th>
                                                <th class="text-center">Importe</th>
                                                <th class="text-center">-</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(concepto, i) in form.partidas" :title="concepto.descripcion">
                                                <td>@{{ i+1 }}</td>
                                                <td>@{{ concepto.numero_tarjeta }}</td>
                                                <td>@{{ concepto.sector }}</td>
                                                <td>@{{ concepto.cuadrante }}</td>
                                                <td>@{{ concepto.unidad }}</td>
                                                <td class="text-right">@{{ parseFloat(concepto.cantidad_presupuestada).formatMoney(2, ',','.') }}</td>
                                                <td>
                                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Volúmen del Cambio ' + (i+1))}">
                                                        <input type="text" :name="'Volúmen del Cambio ' + (i+1)" v-validate="'required|regex:[^0]+|min_value:' + - parseFloat(concepto.cantidad_presupuestada)" class="form-control input-sm" v-model="concepto.variacion_volumen">
                                                        <label class="help" v-show="validation_errors.has('form_save_solicitud.Volúmen del Cambio ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Volúmen del Cambio ' + (i+1)) }}</label>
                                                    </div>
                                                </td>
                                                <td class="text-right">$ @{{ parseFloat(concepto.monto_presupuestado).formatMoney(2, ',', '.') }}</td>
                                                <td><button type="button" class="btn btn-xs btn-default btn_remove_concepto" :id="concepto.id_concepto"><i class="fa fa-minus text-red"></i></button> </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7" class="text-right"><b>SUBTOTAL</b></td>
                                                <td class="text-right"><b>$ @{{ subtotal.formatMoney(2, ',', '.') }}</b></td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Area Solicitante')}">
                                            <label><b>Area Solicitante:</b></label>
                                            <input type="text" class="form-control input-sm" v-validate="'required'" :name="'Area Solicitante'"  v-model="form.area_solicitante">
                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Area Solicitante')">@{{ validation_errors.first('form_save_solicitud.Area Solicitante') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label :class="{'text-red' : validation_errors.has('form_save_solicitud.Presupuesto')}"><b>Presupuestos en donde se aplicarán los cambios</b></label>
                                    </div>
                                    <div class="col-md-4" v-for="base_presupuesto in bases_afectadas">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Presupuesto')}">
                                            <label><b>*** @{{ base_presupuesto.descripcion }}</b></label>
                                            <input type="checkbox" v-validate="'required'" :name="'Presupuesto'" :value="base_presupuesto.id" v-model="form.afectaciones">
                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Presupuesto')">Seleccione por lo menos un presupuesto por afectar.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                            <label><b>Motivo</b></label>
                                            <textarea class="form-control" v-validate="'required'" :name="'Motivo'" v-model="form.motivo"></textarea>
                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p>*** Los presupuestos seleccionados serán afectados una vez que se autorice ésta solicitud.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" :disabled="cargando">
                            <span v-if="cargando">
                                <i class="fa fa-spinner fa-spin"></i> Guardando
                            </span>
                                    <span v-else>
                                <i class="fa fa-save"></i> Guardar
                            </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </variacion-volumen-create>
@endsection

