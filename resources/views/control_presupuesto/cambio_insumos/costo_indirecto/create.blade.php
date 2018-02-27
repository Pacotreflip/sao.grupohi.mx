@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'SOLICITUD DE CAMBIO AL PRESUPUESTO COSTO INDIRECTO')
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

                        <div class="box box-body with-border">
                            <form id="form_insumo_indirecto"
                                  data-vv-scope="form_insumo_indirecto">
                                <div class="box-body with-border">
                                    <select class="form-control" :name="'Item'" data-placeholder="BUSCAR COSTO INDIRECTO"
                                            id="sel_concepto_indirecto"
                                            v-model="id_concepto_indirecto"></select>

                                </div>
                                <div class="box-footer with-border">
                                    </button>
                                    <button type="button" class="btn btn-primary" v-on:click="actualizarLista()">
                                        <i class="fa  fa-plus"></i> Buscar

                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Conceptos</h3>

                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="conceptos_table" class="small table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Unidad</th>
                                        <th>Volumen</th>
                                        <th>Costo</th>
                                        <th>Importe</th>
                                        <th>Agregar</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th></th>
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

            <div id="insumos_indirecto_modal" class="modal fade" aria-labelledby="ConceptosModal" data-backdrop="static"
                 data-keyboard="false">
                <div class="modal-dialog modal-lg" >

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
                                        <label class="col-sm-12 ">@{{ concepto.cobrable.descripcion }}</label>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow-y: scroll">
                                <form id="form_save_solicitud"
                                      @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"
                                      data-vv-scope="form_save_solicitud">

                                    <div class="modal-body small" >

                                        <div class="table-responsive" v-show="concepto.conceptos.GASTOS.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12"><label for="gastos"
                                                                                      class="col-sm-7 control-label"><h4>
                                                                    GASTOS</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right" id="gastos"
                                                                    v-on:click="addInsumoTipo(6)"> + Gasto
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Cantidad Original</th>
                                                    <th>Cantidad Actualizada</th>
                                                    <th>Volumen Original</th>
                                                    <th>Volumen Actualizado</th>
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.GASTOS.insumos">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo gastos[' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="0.0"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,6)"
                                                                   v-validate="insumo.nuevo==true ? 'required' : ''"
                                                                   :name="'Rendimiento nuevo gastos[' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo gastos[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo gastos[' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo gastos [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="0.0"
                                                                   style="width: 90%"
                                                                   :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular_cantidad(insumo.id_elemento, i,6)"
                                                                   v-validate="insumo.nuevo==true ? 'required' : ''"
                                                                   :name="'Rendimiento nuevo gastos [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo gastos [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo gastos [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario gastos[' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="0.0"
                                                                    style="width: 90%"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,6)"
                                                                    v-validate="insumo.nuevo==true ? 'required' : ''"
                                                                    :name="'Precio unitario gastos[' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Precio unitario gastos[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario gastos[' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 6)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                            <label><b>Motivo</b></label>
                                            <textarea class="form-control" v-validate="'required'" :name="'Motivo'"
                                                      v-model="form.motivo"></textarea>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                        </div>
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Area solicitante')}">
                                            <label><b>Área Solicitante</b></label>
                                            <textarea class="form-control" v-validate="'required'"
                                                      :name="'Area solicitante'"
                                                      v-model="form.area_solicitante"></textarea>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_save_solicitud.Area solicitante')">@{{ validation_errors.first('form_save_solicitud.Area solicitante') }}</label>
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

                </div>
            </div>


        </section>

    </cambio-insumos-indirecto-create>



@endsection
