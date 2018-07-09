@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONCEPTOS EXTRAORDINARIOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.conceptos_extraordinarios.create') !!}
@endsection
@section('main-content')
    <concepto-extraordinario-create
            :id_tipo_orden="3"
            :conceptos="{{$conceptos}}"
            :unidades="{{ json_encode($unidades) }}"
            :tipos_extraordinarios="{{ json_encode($tipos_extraordinarios) }}"
            :tarjetas="{{ json_encode($tarjetas) }}"
            :catalogo="{{ json_encode($catalogo) }}"
            inline-template v-cloak xmlns="http://www.w3.org/1999/html">
        <section>

            <!-- Seccion de opciones de extraordinario -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <div class="col-md-10"><h3 class="box-title">Seleccione un Extraordinario</h3></div>
                            <div class="col-md-2"><button type="button" class="btn btn-primary pull-right" :disabled="modificar_estructura" v-show="form.id_origen_extraordinario == ''" v-on:click="modificar_estructura = !modificar_estructura"> Modificar Estructura Presupuestal</button></div>

                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="origen_extraordinario"><b>Origen del Extraordinario</b></label>
                                    <select class="form-control input-sm" v-model="form.id_origen_extraordinario"  :disabled="!tipos_extraordinarios.length || mostrar_tabla || modificar_estructura" v-on:change="form.id_opcion = '' ">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_extraordinario in tipos_extraordinarios" :value="tipo_extraordinario.id">@{{ tipo_extraordinario.descripcion }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6" v-if="form.id_origen_extraordinario==1 " >
                                    <label><b>Número de Tarjeta</b></label>
                                    <select2 id="tarjetas_select"  v-model="form.id_opcion" :disabled="mostrar_tabla"
                                             :options="tarjetas">
                                    </select2>
                                </div>
                                <div class="col-md-6" v-if="form.id_origen_extraordinario==2">
                                    <label for="catalogo_extraordinario"><b>Catálogo Extraordinarios</b></label>
                                    <select class="form-control input-sm" v-model="form.id_opcion"  :disabled="!tipos_extraordinarios.length || mostrar_tabla">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="cat in catalogo" :value="cat.id">@{{ cat.descripcion }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6" v-if="form.id_origen_extraordinario==3" >
                                    <label for="origen_catalogo"><b>Tipo de Costo</b></label>
                                    <select class="form-control input-sm" v-model="form.id_opcion" :disabled="mostrar_tabla">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_costo in tipos_costos" :value="tipo_costo.id">@{{ tipo_costo.descripcion }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12 col-sm-6">
                                    <button type="button" class="btn btn-success pull-right" v-on:click="getExtraordinario()" v-show="!mostrar_tabla" :disabled="form.id_opcion == ''">
                                        <span v-if="cargando"><i class="fa fa-spinner fa-spin"></i> </span>
                                        <span v-else><i class="fa fa-check"></i> Crear </span>
                                    </button>
                                    <button type="button" class="btn btn-default pull-right" v-on:click="validacion_opciones()" v-show="mostrar_tabla">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seccion de presentacion del extraordinario con insumos y sus agrupadores costo directo e indirecto-->
            <div class="row" >
                <div class="col-md-12">
                    <div class="box box-solid" v-if="mostrar_tabla">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos del Concepto</h3>
                        </div>

                        <form id="form_save_solicitud"
                              @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"
                              data-vv-scope="form_save_solicitud">

                            <div class="box-body">
                            <div class="row">
                                <div class="form-group" v-if="tipo_costo()">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="concepto_table" class=" table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="width: 60%">Descripción</th>
                                                    <th style="width: 10%">Unidad</th>
                                                    <th style="width: 10%">Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Descripcion Concepto')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Nombre Concepto"   v-model="form.extraordinario.descripcion"  style="width: 100%; height: 34px"  v-validate="'required'"
                                                                   :name="'Descripcion Concepto'" class="form-control">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Descripcion Concepto')">@{{ validation_errors.first('form_save_solicitud.Descripcion Concepto') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select2 id="unidad_select"  v-model="form.extraordinario.unidad = 'PESOS'"
                                                                     :options="unidades" :disabled="true">
                                                            </select2>
                                                        </div>
                                                    </td>

                                                    <td >$@{{ parseFloat(form.extraordinario.monto_presupuestado).formatMoney(2,'.',',') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" v-else>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="concepto_table" class=" table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="width: 60%">Descripción</th>
                                                    <th style="width: 10%">Unidad</th>
                                                    <th style="width: 10%">Cantidad</th>
                                                    <th style="width: 10%">Importe</th>
                                                    <th style="width: 10%">Monto</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Concepto Descripcion')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Nombre Concepto"   v-model="form.extraordinario.descripcion"  style="width: 100%; height: 34px"
                                                                   class="form-control" v-validate="'required'"
                                                                   :name="'Concepto Descripcion'">
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Concepto Descripcion')">@{{ validation_errors.first('form_save_solicitud.Concepto Descripcion') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Concepto Unidad')}">
                                                            <select2 id="unidad_select"  v-model="form.extraordinario.unidad" class="form-control" v-validate="'required'"
                                                                     :name="'Concepto Unidad'"
                                                                     :options="unidades">
                                                            </select2>
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_save_solicitud.Concepto Unidad')">@{{ validation_errors.first('form_save_solicitud.Concepto Unidad') }}</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Concepto Cantidad')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" class="form-control" v-validate="'required|decimal:3|min_value:0'"
                                                                   :name="'Concepto Cantidad'"
                                                                   :options="unidades"
                                                                   style="width: 100%; height: 34px"
                                                                   v-model="form.extraordinario.cantidad_presupuestada"
                                                                   @change="recalcular_concepto()">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Concepto Cantidad')">@{{ validation_errors.first('form_save_solicitud.Concepto Cantidad') }}</label>
                                                        </div>
                                                    </td>
                                                    <td >$@{{ parseFloat(form.extraordinario.precio_unitario).formatMoney(2,'.',',') }}</td>
                                                    <td >$@{{ parseFloat(form.extraordinario.monto_presupuestado).formatMoney(2,'.',',') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Inicia la seccion de los agrupadores de insumos-->
                                <div class="col-md-12">
                                    <h4 class="box-title">Insumos</h4>
                                </div>

                                <div class="form-group" v-if="tipo_costo()">
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Gastos </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default pull-right"
                                                id="materiales" style="width: 50%"
                                                v-on:click="addInsumoTipo(6)" > +Gastos
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" v-if="form.extraordinario.GASTOS">
                                            <table id="concepto_table" class="small table table-bordered table-striped">
                                                <thead>
                                                <col width="10">
                                                <col width="300">
                                                <col width="80">
                                                <col width="80">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in form.extraordinario.GASTOS.insumos" >
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>

                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Insumo Cantidad [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad"  v-validate="'required|decimal:3|min_value:0'"
                                                                    :name="'Insumo Cantidad [' + (i + 1) + ']'"
                                                                    v-model="insumo.monto_presupuestado" style="width: 80%; height: 25px"
                                                                    :class="'m_p_gas_' + i"
                                                                    @change="recalcular_insumo(i,6)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Insumo Cantidad [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Insumo Cantidad [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" v-else>
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Materiales </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default pull-right"
                                                id="materiales" style="width: 50%"
                                                v-on:click="addInsumoTipo(1)"> +Materiales
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" v-if="form.extraordinario.MATERIALES">
                                            <table id="concepto_table" class="small table table-bordered table-striped">
                                                <thead>
                                                    <col width="10">
                                                    <col width="300">
                                                    <col width="80">
                                                    <col width="80">
                                                    <col width="80">
                                                    <col width="80">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Unidad</th>
                                                        <th>Rendimiento U. T.</th>
                                                        <th>Costo Unitario</th>
                                                        <th>Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(insumo, i) in form.extraordinario.MATERIALES.insumos" >
                                                        <td>@{{ i+1 }}</td>
                                                        <td>@{{ insumo.descripcion }}</td>
                                                        <td>@{{ insumo.unidad }}</td>
                                                        <td>
                                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Material Cantidad [' + (i + 1) + ']')}">
                                                                <input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                       :name="'Material Cantidad [' + (i + 1) + ']'"
                                                                       v-model="insumo.cantidad_presupuestada" style="width: 100%; height: 25px"
                                                                       :class="'c_p_mat_' + i"
                                                                       @change="recalcular_insumo(i,1)">
                                                                <label class="help" v-show="validation_errors.has('form_save_solicitud.Material Cantidad [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Material Cantidad [' + (i + 1) + ']') }}</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Material Importe [' + (i + 1) + ']')}">
                                                               $ <input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                        :name="'Material Importe [' + (i + 1) + ']'"
                                                                        v-model="insumo.precio_unitario" style="width: 90%; height: 25px"
                                                                        :class="'p_u_mat_' + i"
                                                                        @change="recalcular_insumo(i,1)">
                                                                <label class="help" v-show="validation_errors.has('form_save_solicitud.Material Importe [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Material Importe [' + (i + 1) + ']') }}</label>
                                                            </div>
                                                        </td>
                                                        <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Mano de Obra </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default pull-right"
                                                id="materiales" style="width: 50%"
                                                v-on:click="addInsumoTipo(2)"> +M / O
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" v-if="form.extraordinario.MANOOBRA" >
                                            <table id="concepto_table" class="small table table-bordered table-striped">
                                                <thead>
                                                <col width="10">
                                                <col width="300">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Rendimiento U. T.</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in form.extraordinario.MANOOBRA.insumos" >
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Mano de Obra Cantidad [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" v-model="insumo.cantidad_presupuestada" style="width: 100%; height: 25px" v-validate="'required|decimal:3|min_value:0'"
                                                                   :name="'Mano de Obra Cantidad [' + (i + 1) + ']'"
                                                                   :class="'c_p_mdo_' + i"
                                                                   @change="recalcular_insumo(i,2)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Mano de Obra Cantidad [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Mano de Obra Cantidad [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Mano de Obra Importe [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                    :name="'Mano de Obra Importe [' + (i + 1) + ']'"
                                                                    v-model="insumo.precio_unitario" style="width: 90%; height: 25px"
                                                                    :class="'p_u_mdo_' + i"
                                                                    @change="recalcular_insumo(i,2)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Mano de Obra Importe [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Mano de Obra Importe [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Herramienta y Equipo </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default pull-right"
                                                id="materiales" style="width: 50%"
                                                v-on:click="addInsumoTipo(4)"> +Herramienta y Equipo
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" v-if="form.extraordinario.HERRAMIENTAYEQUIPO">
                                            <table id="concepto_table" class="small table table-bordered table-striped">
                                                <thead>
                                                <col width="10">
                                                <col width="300">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Rendimiento U. T.</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in form.extraordinario.HERRAMIENTAYEQUIPO.insumos" >
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Herramienta y Equipo Cantidad [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                   :name="'Herramienta y Equipo Cantidad [' + (i + 1) + ']'"
                                                                   v-model="insumo.cantidad_presupuestada" style="width: 100%; height: 25px"
                                                                   :class="'c_p_hye_' + i"
                                                                   @change="recalcular_insumo(i,4)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Herramienta y Equipo Cantidad [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Herramienta y Equipo Cantidad [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Herramienta y Equipo Importe [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                    :name="'Herramienta y Equipo Importe [' + (i + 1) + ']'"
                                                                    v-model="insumo.precio_unitario" style="width: 90%; height: 25px"
                                                                    :class="'p_u_hye_' + i"
                                                                    @change="recalcular_insumo(i,4)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Herramienta y Equipo Importe [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Herramienta y Equipo Importe [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Maquinaria </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default pull-right"
                                                id="maquinaria" style="width: 50%"
                                                v-on:click="addInsumoTipo(8)" > +Maquinaria
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" v-if="form.extraordinario.MAQUINARIA">
                                            <table id="concepto_table" class="small table table-bordered table-striped">
                                                <thead>
                                                <col width="10">
                                                <col width="300">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Rendimiento U. T.</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in form.extraordinario.MAQUINARIA.insumos" >
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Maquinaria Cantidad [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                   :name="'Maquinaria Cantidad [' + (i + 1) + ']'"
                                                                   v-model="insumo.cantidad_presupuestada" style="width: 100%; height: 25px"
                                                                   :class="'c_p_maq_' + i"
                                                                   @change="recalcular_insumo(i,8)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Maquinaria Cantidad [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Maquinaria Cantidad [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Maquinaria Importe [' + (i + 1) + ']')}">
                                                            $ <input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                     :name="'Maquinaria Importe [' + (i + 1) + ']'"
                                                                     v-model="insumo.precio_unitario" style="width: 90%; height: 25px"
                                                                     :class="'p_u_maq_' + i"
                                                                     @change="recalcular_insumo(i,8)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Maquinaria Importe [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Maquinaria Importe [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Subcontratos </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default pull-right"
                                                id="materiales" style="width: 50%"
                                                v-on:click="addInsumoTipo(5)"> +Subcontratos
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive" v-if="form.extraordinario.SUBCONTRATOS">
                                            <table id="concepto_table" class="small table table-bordered table-striped">
                                                <thead>
                                                <col width="10">
                                                <col width="300">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <col width="80">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Unidad</th>
                                                    <th>Rendimiento U. T.</th>
                                                    <th>Costo Unitario</th>
                                                    <th>Importe</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(insumo, i) in form.extraordinario.SUBCONTRATOS.insumos" >
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Subcontratos Cantidad [' + (i + 1) + ']')}">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:3|min_value:0'"
                                                                   :name="'Subcontratos Cantidad [' + (i + 1) + ']'"
                                                                   v-model="insumo.cantidad_presupuestada" style="width: 100%; height: 25px"
                                                                   :class="'c_p_sub_' + i"
                                                                   @change="recalcular_insumo(i,5)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Subcontratos Cantidad [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Subcontratos Cantidad [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Subcontratos Importe [' + (i + 1) + ']')}">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" v-validate="'required|decimal:6|min_value:0|max_value:999999999999'"
                                                                    :name="'Subcontratos Importe [' + (i + 1) + ']'"
                                                                    v-model="insumo.precio_unitario" style="width: 90%; height: 25px"
                                                                    :class="'p_u_sub_' + i"
                                                                    @change="recalcular_insumo(i,5)">
                                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Subcontratos Importe [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Subcontratos Importe [' + (i + 1) + ']') }}</label>
                                                        </div>
                                                    </td>
                                                    <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Area de campos de solicitante y motivo -->

                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Buscar')}">
                                    <div class="col-md-12">
                                        <label for="buscar" class="control-label"><b>Agregar extraordinario en la siguiente ruta del presupuesto: </b></label>
                                    </div>
                                    <div class="col-md-11">
                                        <textarea class="form-control"  v-validate="'required'" :name="'Buscar'" style="width: 100%" v-model="form.path_base" disabled="true"></textarea>
                                        <label class="help" v-show="validation_errors.has('form_save_solicitud.Buscar')">@{{ validation_errors.first('form_save_solicitud.Buscar') }}</label>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button"
                                                class="btn btn-success pull-right"
                                                id="buscar"
                                                data-toggle="modal" data-target="#seleccion_concepto_modal"> Buscar
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group"
                                         :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                        <label><b>Motivo</b></label>
                                        <textarea class="form-control" v-validate="'required'" :name="'Motivo'" maxlength="125"
                                                  v-model="form.motivo"></textarea>
                                        <label class="help"
                                               v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                    </div>
                                    <div class="form-group"
                                         :class="{'has-error': validation_errors.has('form_save_solicitud.Area solicitante')}">
                                        <label><b>Área Solicitante</b></label>
                                        <textarea class="form-control" v-validate="'required'" maxlength="125"
                                                  :name="'Area solicitante'"
                                                  v-model="form.area_solicitante"></textarea>
                                        <label class="help"
                                               v-show="validation_errors.has('form_save_solicitud.Area solicitante')">@{{ validation_errors.first('form_save_solicitud.Area solicitante') }}</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                            <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12 col-sm-6">
                                    <button type="button" class="btn btn-default pull-right" v-on:click="validacion_opciones()">Cerrar</button>
                                    <button type="submit" class="btn btn-primary pull-right" :disabled="cargando">
                                            <span v-if="cargando">
                                                <i class="fa fa-spinner fa-spin"></i> Guardando
                                            </span>
                                        <span v-else>
                                                <i class="fa fa-save"></i> Guardar
                                            </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Seccion para agregar partidas al presupuesto -->
            <div class="row" v-show="modificar_estructura">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <div class="col-md-10"><h3 class="box-title">Modificar Estructura Presupuestal</h3></div>
                            <div class="col-md-2"><button type="button" class="btn btn-default pull-right" v-on:click="modificar_estructura = !modificar_estructura" >Cerrar</button></div>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" v-treegrid id="concepto_tree">
                                            <thead>
                                                <tr>
                                                    <th>Concepto</th>
                                                    <th>Agregar Partida</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr  v-for="(concepto, index) in conceptos_ordenados" :class="tr_class(concepto)" :id="tr_id(concepto)" >
                                                    <td v-if="concepto.id_padre == null">
                                                        @{{ concepto.descripcion }}
                                                        <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="concepto.tiene_hijos > 0 && ! concepto.cargado" @click="get_hijos(concepto)">
                                                                    <span v-if="cargando">
                                                                        <i class="fa fa-spin fa-spinner"></i>
                                                                    </span>
                                                            <span v-else>
                                                                        <i class="fa fa-plus"></i>
                                                                    </span>
                                                        </button>
                                                    </td>
                                                    <td  v-else>
                                                        @{{ concepto.descripcion}}
                                                        <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="concepto.tiene_hijos > 0 && ! concepto.cargado && concepto.hijos_cobrables == 0" @click="get_hijos(concepto)">
                                                                    <span v-if="cargando">
                                                                        <i class="fa fa-spin fa-spinner"></i>
                                                                    </span>
                                                            <span v-else>
                                                                        <i class="fa fa-plus"></i>
                                                                    </span>
                                                        </button>
                                                    </td>
                                                    <td >
                                                        <button type="button" class="btn btn-success " @click="modal_agregar_partidas(concepto)">
                                                            <span v-if="cargando"><i class="fa fa-spinner fa-spin"></i> </span>
                                                            <span v-else><i class="fa fa-plus large"></i></span>
                                                        </button>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para agregar un insumo por agrupador-->

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


            <!-- Modal para agregar una partida al presupuesto-->

            <div id="add_partida_modal" class="modal fade" aria-labelledby="addPartidaModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header with-border">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Agregar Partidas al Presupuesto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>Partidas pertenecientes a:  @{{ concepto_base.descripcion }}</h4></label>
                                </div>
                                <div class="col-md-12">
                                    <table id="concepto_table" class=" table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th style="width: 60%">Descripción</th>
                                            <th style="width: 10%">Importe</th>
                                        </tr>
                                        </thead>
                                        <tbody v-show="!cargando">
                                        <tr v-for="(partida, index) in partidas_concepto">
                                            <td>@{{ partida.descripcion }}</td>
                                            <td class="text-right">$ @{{ parseFloat(partida.monto_presupuestado).formatMoney(2,'.',',') }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="callout callout-info">
                                        <p>Para agregar una partida en @{{ concepto_base.descripcion }} solo ingrese una descripción</p>
                                    </div>
                                    <form id="form_save_partida" @submit.prevent="validateForm('form_save_partida', 'save_partida')"
                                          data-vv-scope="form_save_partida">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_partida.Partida Descripcion')}">
                                            <input type="text" placeholder="Ingrese Descripción de la Partida"  style="width: 100%; height: 34px"
                                                   class="form-control" v-validate="'required'"
                                                   v-model="partida_descripcion" :disabled="cargando"
                                                   :name="'Partida Descripcion'">
                                            <label class="help"
                                                   v-show="validation_errors.has('form_save_partida.Partida Descripcion')">@{{ validation_errors.first('form_save_partida.Partida Descripcion') }}</label>
                                        </div>
                                        <button type="button" class="btn btn-default pull-right" v-on:click="close_modal_partida()" style="margin-left: 5px">Cerrar</button>
                                        <button type="submit" class="btn btn-primary pull-right">
                                            <span v-if="cargando"><i class="fa fa-spinner fa-spin"></i> </span>
                                            <span v-else><i class="fa fa-plus large">Agregar</i></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Modal para seleccionar el lugar donde posicionar el extraordnario en el arbol de conceptos -->

            <div id="seleccion_concepto_modal" class="modal fade" aria-labelledby="addExtraordinarioModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Agregar Extraordinario</h4>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" v-treegrid id="concepto_tree">
                                        <thead>
                                            <tr>
                                                <th>Concepto</th>
                                                <th>Asignar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr  v-for="(concepto, index) in conceptos_ordenados" :class="tr_class(concepto)" :id="tr_id(concepto)" >
                                                <td v-if="concepto.id_padre == null">
                                                    @{{ concepto.descripcion }}
                                                    <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="validar_botones_arbol(concepto,1)" @click="get_hijos(concepto)">
                                                                <span v-if="cargando">
                                                                    <i class="fa fa-spin fa-spinner"></i>
                                                                </span>
                                                        <span v-else>
                                                                    <i class="fa fa-plus"></i>
                                                                </span>
                                                    </button>
                                                </td>
                                                <td  v-else>
                                                    @{{ concepto.descripcion}}
                                                    <button style="border: 0; background-color: transparent" :disabled="cargando" v-if="validar_botones_arbol(concepto, 1)" @click="get_hijos(concepto)">
                                                                <span v-if="cargando">
                                                                    <i class="fa fa-spin fa-spinner"></i>
                                                                </span>
                                                        <span v-else>
                                                                    <i class="fa fa-plus"></i>
                                                                </span>
                                                    </button>
                                                </td>
                                                <td v-if="concepto.hijos_cobrables > 0  || concepto.tiene_hijos == 0" class="-align-center">
                                                    <button type="button" class="btn btn-success fa fa-check small" @click="confirmacion_ruta(concepto)">Agregar</button>
                                                </td>
                                                <td v-else>
                                                    ---
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agregar material nuevo al catálogo -->
            <material-index></material-index>

        </section>
    </concepto-extraordinario-create>
    <section></section>
@endsection