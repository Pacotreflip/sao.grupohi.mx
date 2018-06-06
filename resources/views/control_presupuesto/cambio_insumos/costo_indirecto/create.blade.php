@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CAMBIO DE INSUMOS <small>(COSTO INDIRECTO)</small>')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-insumos-indirecto-create
            :id_tipo_orden="7"
            inline-template v-cloak>
        <section>


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros para consulta de Conceptos</h3>
                        </div>
                        <form id="form_insumo_indirecto"
                              data-vv-scope="form_insumo_indirecto">
                            <div class="box-body ">
                                <select class="form-control" :name="'Item'"
                                        data-placeholder="BUSCAR COSTO INDIRECTO"
                                        id="sel_concepto_indirecto"
                                        v-model="id_concepto_indirecto"></select>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12" class="text-center">
                <span v-if="consultando"><i class="fa fa-spinner fa-spin"></i> </span>
                <span v-else></span>
            </div>

            <div class="row" v-if="form.partidas.length>0">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">GASTOS</h3>
                        </div>
                        <form id="form_save_solicitud"
                              @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"
                              data-vv-scope="form_save_solicitud">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right" id="materiales" v-on:click="addInsumoTipo(6)"> +
                                                        Gastos
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>


                                            <th>Costo Original</th>
                                            <th>Costo Actualizado</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in form.partidas" :class="insumo.nuevo?'bg-gray':''">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>


                                            <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Volumen Actualizado [' + (i + 1) + ']')}">
                                                    <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                           style="width: 75%"
                                                           :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular_cantidad(insumo.id_elemento, i,1)"
                                                           v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                           :name="'Volumen Actualizado [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Volumen Actualizado [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Volumen Actualizado [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>


                                            <td>
                                                <button type="button"
                                                        @click="removeRendimiento(insumo.id_elemento, i, 1)"><i
                                                            class="fa fa-minus text-red"></i></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <div class="form-group"
                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Area solicitante')}">
                                    <label><b>Área Solicitante</b></label>
                                    <Input type="text" class="form-control" v-validate="'required'"
                                           :name="'Area solicitante'"
                                           v-model="form.area_solicitante"></Input>
                                    <label class="help"
                                           v-show="validation_errors.has('form_save_solicitud.Area solicitante')">@{{ validation_errors.first('form_save_solicitud.Area solicitante') }}</label>
                                </div>
                                <div class="form-group"
                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                    <label><b>Motivo</b></label>
                                    <textarea class="form-control" v-validate="'required'" :name="'Motivo'"
                                              v-model="form.motivo"></textarea>
                                    <label class="help"
                                           v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                </div>

                            </div>

                            <div class="modal-footer">
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

            <div id="insumos_indirecto_modal" class="modal fade" aria-labelledby="ConceptosModal" data-backdrop="static"
                 data-keyboard="false">
                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Insumos</h4>
                        </div>

                        <div v-for="(concepto, i) in form.partidas">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12" v-if="form.partidas">
                                        <label class="col-sm-12 "></label>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow-y: scroll">

                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div id="add_insumo_modal" class="modal fade" aria-labelledby="addInsumosModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Agregar Insumos</h4>

                            <div class="box-tools pull-right">
                                <a v-on:click="$emit('abrirModalMateriales',tipo_insumo)"
                                   class="btn btn-success btn-app" style="float:right">
                                    <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
                                </a>
                            </div>
                        </div>

                        <form id="form_save_solicitud"
                              @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"
                              data-vv-scope="form_save_solicitud">
                            <div class="modal-body small">
                                <select class="form-control" :name="'Item'" data-placeholder="BUSCAR INSUMO"
                                        id="sel_material"
                                        v-model="id_concepto_indirecto"></select>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="button" class="btn btn-primary" v-on:click="agregar_insumo_nuevo()" :disabled="guardar">
                                    <i class="fa  fa-plus"></i> Agregar

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <material-index></material-index>
        </section>


    </cambio-insumos-indirecto-create>



@endsection
