@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CAMBIO DE INSUMOS <small>(COSTO DIRECTO)</small>')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-insumos-create
            :id_tipo_orden="6"
            @reset-filtros="filtros = []"
            inline-template v-cloak>
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
                                        <select2 id="tarjetas_select" :disabled="cargando" v-model="id_tarjeta"
                                                 :options="tarjetas">
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
                    <button class="btn btn-app pull-right" :disabled="!form.partidas.length || cargando || guardando"
                            data-toggle="modal" data-target="#insumos_modal"
                            @click="validation_errors.clear('form_save_solicitud')">
                        <span class="badge bg-green">@{{ form.agrupadas.length }}</span>
                        <i class="fa fa-list-ol"></i> Partidas Agrupadas
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Conceptos !!</h3>

                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="conceptos_table" class="small table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th v-for="nivel in niveles">@{{ nivel.nombre }}</th>
                                        <th>Unidad</th>
                                        <th>Volumen</th>
                                        <th>Costo</th>
                                        <th>Importe</th>
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

            <div id="insumos_modal" class="modal fade" aria-labelledby="ConceptosModal" data-backdrop="static"
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
                                    <div class="modal-body small" v-if="form.agrupadas.length > 1">
                                        <div class="table-responsive" v-show="concepto.conceptos.MATERIALES.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="materiales" class="col-sm-9 control-label"><h4>
                                                                    MATERIALES</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="materiales" v-on:click="addInsumoTipo(1)"> +
                                                                Materiales
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
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.MATERIALES.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada material [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,1)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada material [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada material [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado material [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    style="width: 90%"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,1)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado material [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado material [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" v-if="insumoEliminado()"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 1)"><i
                                                                    class="fa fa-minus text-red"></i>
                                                        </button>
                                                        <button type="button" v-else
                                                                @click="removeRendimiento(insumo.id_elemento, i, 1)"><i
                                                                    class="fa fa-arrow-circle-o-left text-green"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive" v-show="concepto.conceptos.MANOOBRA.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="mano_obra" class="col-sm-7 control-label"><h4>MANO
                                                                    DE
                                                                    OBRA</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="mano_obra" v-on:click="addInsumoTipo(2)"> + Mano
                                                                Obra
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Rendimiento Original</th>
                                                    <th>Rendimiento Actializado</th>
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.MANOOBRA.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento Actualizado mano de obra [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,2)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Rendimiento Actualizado mano de obra [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Rendimiento Actualizado mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento Actualizado mano de obra [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado mano de obra [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    style="width: 90%"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,2)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado mano de obra [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado mano de obra [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 2)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive"
                                             v-show="concepto.conceptos.HERRAMIENTAYEQUIPO.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="herram_equipo" class="col-sm-7 control-label"><h4>
                                                                    HERRAMIENTA Y EQUIPO</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="herram_equipo" v-on:click="addInsumoTipo(4)"> + H /
                                                                E
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
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.HERRAMIENTAYEQUIPO.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada herramienta [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,4)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada herramienta [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada herramienta [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado herramienta [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    style="width: 90%"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,4)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado herramienta [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado herramienta [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 4)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive" v-show="concepto.conceptos.MAQUINARIA.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="maquinaria" class="col-sm-7 control-label"><h4>
                                                                    MAQUINARIA</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="maquinaria" v-on:click="addInsumoTipo(8)"> +
                                                                Maquinaria
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
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.MAQUINARIA.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada maquinaria [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,8)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada maquinaria [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada maquinaria [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada maquinaria [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado maquinaria [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    style="width: 90%"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,8)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado maquinaria [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado maquinaria [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado maquinaria [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 8)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive" v-show="concepto.conceptos.SUBCONTRATOS.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="subcontrato" class="col-sm-7 control-label"><h4>
                                                                    SUBCONTRATOS</h4></label>
                                                            <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                                    id="subcontrato" v-on:click="addInsumoTipo(5)"> + Subcontrato
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
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.SUBCONTRATOS.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada subcontrato [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,5)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada subcontrato [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada subcontrato [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada subcontrato [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado subcontrato [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    style="width: 90%" :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,5)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado subcontrato [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado subcontrato [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado subcontrato [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 5)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>

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
                                    <div class="modal-body small" v-else>
                                        <div class="table-responsive" v-show="concepto.conceptos.MATERIALES.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <label for="materiales" class="col-sm-9 control-label"><h4>
                                                                    MATERIALES Unitario</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="materiales" v-on:click="addInsumoTipo(1)"> +
                                                                Materiales
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
                                                <tr v-for="(insumo, i) in concepto.conceptos.MATERIALES.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada Material [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 75%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,1)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada Material [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada Material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada Material [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Volumen Actualizado Material [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 75%"
                                                                   :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular_cantidad(insumo.id_elemento, i,1)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Volumen Actualizado Material [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Volumen Actualizado Material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Volumen Actualizado Material [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado Material [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    style="width: 70%"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,1)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado Material [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado Material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado Material [' + (i + 1) + ']') }}</label>
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
                                        <br>
                                        <div class="table-responsive" v-show="concepto.conceptos.MANOOBRA.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="mano_obra" class="col-sm-7 control-label"><h4>MANO
                                                                    DE
                                                                    OBRA</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="mano_obra" v-on:click="addInsumoTipo(2)"> + Mano
                                                                Obra
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Rendimiento Original</th>
                                                    <th>Rendimiento Actualizado</th>
                                                    <th>Volumen Original</th>
                                                    <th>Volumen Actualizado</th>
                                                    <th>Costo Original</th>
                                                    <th>Costo Actualizado</th>
                                                    <th>-</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in concepto.conceptos.MANOOBRA.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento Actualizado Mano de Obra [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,2)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Rendimiento Actualizado Mano de Obra [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Rendimiento Actualizado Mano de Obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento Actualizado Mano de Obra [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Volumen Actualizado Mano de Obra [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular_cantidad(insumo.id_elemento, i,2)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Volumen Actualizado Mano de Obra [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Volumen Actualizado Mano de Obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Volumen Actualizado Mano de Obra [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado Mano de Obra [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    style="width: 90%"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,2)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado Mano de Obra [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado Mano de Obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado Mano de Obra [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 2)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive"
                                             v-show="concepto.conceptos.HERRAMIENTAYEQUIPO.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="herram_equipo" class="col-sm-7 control-label"><h4>
                                                                    HERRAMIENTA Y EQUIPO</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="herram_equipo" v-on:click="addInsumoTipo(4)"> + H /
                                                                E
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
                                                <tr v-for="(insumo, i) in concepto.conceptos.HERRAMIENTAYEQUIPO.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada Herramienta [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,4)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada Herramienta [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada Herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada Herramienta [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Volumen Actualizado Herramienta [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular_cantidad(insumo.id_elemento, i,4)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Volumen Actualizado Herramienta [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Volumen Actualizado Herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Volumen Actualizado Herramienta [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado Herramienta [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    style="width: 90%"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,4)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado Herramienta [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado Herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado Herramienta [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 4)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive" v-show="concepto.conceptos.MAQUINARIA.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="maquinaria" class="col-sm-7 control-label"><h4>
                                                                    MAQUINARIA</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="maquinaria" v-on:click="addInsumoTipo(8)"> +
                                                                Maquinaria
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
                                                <tr v-for="(insumo, i) in concepto.conceptos.MAQUINARIA.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada Maquinaria [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,8)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada Maquinaria [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada Maquinaria [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada Maquinaria [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Volumen Actualizado Maquinaria [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular_cantidad(insumo.id_elemento, i,8)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Volumen Actualizado Maquinaria [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Volumen Actualizado Maquinaria [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Volumen Actualizado Maquinaria [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado Maquinaria [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    style="width: 90%"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,8)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado Maquinaria [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado Maquinaria [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado Maquinaria [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 8)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="table-responsive" v-show="concepto.conceptos.SUBCONTRATOS.insumos">
                                            <table class="table table-striped">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-12"><label for="subcontrato"
                                                                                      class="col-sm-7 control-label"><h4>
                                                                    SUBCONTRATOS</h4></label>
                                                            <button type="button"
                                                                    class="btn btn-default col-sm-3 pull-right"
                                                                    id="subcontrato" v-on:click="addInsumoTipo(5)"> +
                                                                Subcontrato
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
                                                <tr v-for="(insumo, i) in concepto.conceptos.SUBCONTRATOS.insumos" :class="insumo.nuevo?'bg-gray':''">
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada Subcontratos [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                                   :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular(insumo.id_elemento, i,5)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Cantidad Actualizada Subcontratos [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada Subcontratos [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada Subcontratos [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Volumen Actualizado Subcontratos [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                   style="width: 90%"
                                                                   :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                                   @change="recalcular_cantidad(insumo.id_elemento, i,5)"
                                                                   v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                   :name="'Volumen Actualizado Subcontratos [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Volumen Actualizado Subcontratos [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Volumen Actualizado Subcontratos [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                        $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td>
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_save_solicitud.Costo Actualizado Subcontratos [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                                    style="width: 90%"
                                                                    :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                                    :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                                    @change="recalcular_monto(insumo.id_elemento, i,5)"
                                                                    v-validate="insumo.nuevo==true ? 'required|decimal|min_value:0' : 'decimal|min_value:0'"
                                                                    :name="'Costo Actualizado Subcontratos [' + (i + 1) + ']'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Costo Actualizado Subcontratos [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Costo Actualizado Subcontratos [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="removeRendimiento(insumo.id_elemento, i, 5)"><i
                                                                    class="fa fa-minus text-red"></i></button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>

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
                                        v-model="id_material_seleccionado"></select>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="button" class="btn btn-primary" :disabled="guardar" v-on:click="agregar_insumo_nuevo()">
                                    <i class="fa  fa-plus"></i> Agregar

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <material-index></material-index>

        </section>
    </cambio-insumos-create>

@endsection

