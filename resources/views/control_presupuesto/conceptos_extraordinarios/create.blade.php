@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONCEPTOS EXTRAORDINARIOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.conceptos_extraordinarios.create') !!}
@endsection
@section('main-content')
    <concepto-extraordinario-create
            :id_tipo_orden="3"
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
                            <h3 class="box-title">Seleccione un Extraordinario</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="origen_extraordinario"><b>Origen del Extraordinario</b></label>
                                    <select class="form-control input-sm" v-model="form.id_origen_extraordinario"  :disabled="!tipos_extraordinarios.length || mostrar_tabla" v-on:change="id_opcion = '' ">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_extraordinario in tipos_extraordinarios" :value="tipo_extraordinario.id">@{{ tipo_extraordinario.descripcion }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6" v-if="form.id_origen_extraordinario==1 " >
                                    <label><b>Número de Tarjeta</b></label>
                                    <select2 id="tarjetas_select"  v-model="id_opcion" :disabled="mostrar_tabla"
                                             :options="tarjetas">
                                    </select2>
                                </div>
                                <div class="col-md-6" v-if="form.id_origen_extraordinario==2">
                                    <label for="catalogo_extraordinario"><b>Catalogo Extraordinarios</b></label>
                                    <select class="form-control input-sm" v-model="id_opcion"  :disabled="!tipos_extraordinarios.length || mostrar_tabla">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="cat in catalogo" :value="cat.id">@{{ cat.descripcion }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6" v-if="form.id_origen_extraordinario==3" >
                                    <label for="origen_catalogo"><b>Tipo de Costo</b></label>
                                    <select class="form-control input-sm" v-model="id_opcion" :disabled="mostrar_tabla">
                                        <option value>[--SELECCIONE--]</option>
                                        <option v-for="tipo_costo in tipos_costos" :value="tipo_costo.id">@{{ tipo_costo.descripcion }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-offset-11">
                                    <button type="button" class="btn btn-success" v-on:click="getExtraordinario()" v-show="!mostrar_tabla">
                                        <span v-if="cargando"><i class="fa fa-spinner fa-spin"></i> </span>
                                        <span v-else><i class="fa fa-check"></i> Crear </span>
                                    </button>
                                    <button type="button" class="btn btn-default" v-on:click="validacion_opciones(1)" v-show="mostrar_tabla">Cerrar</button>
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
                        <div class="box-body">
                            <div class="row">
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
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Nombre Concepto"   v-model="form.extraordinario.descripcion"  style="width: 100%; height: 34px">
                                                           </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select2 id="unidad_select"  v-model="form.extraordinario.unidad"
                                                                     :options="unidades">
                                                            </select2>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="form.extraordinario.cantidad_presupuestada" :model="form.extraordinario.cantidad_presupuestada" style="width: 100%; height: 34px">
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Inicia la seccion de los agrupadores de insumos-->
                                <div class="col-md-12">
                                    <h4 class="box-title">Insumos</h4>
                                </div>

                                <div class="form-group" v-if="form.id_origen_extraordinario == 3 && id_opcion == 2">
                                    <div class="col-md-8">
                                        <label for="materiales" class="control-label"><h4>Gastos </h4></label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button"
                                                class="btn btn-default"
                                                id="materiales"
                                                v-on:click="addInsumoTipo(5)" > +Gastos
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
                                                <tr v-for="(insumo, i) in form.extraordinario.GASTOS.insumos" >
                                                    <td>@{{ i+1 }}</td>
                                                    <td>@{{ insumo.descripcion }}</td>
                                                    <td>@{{ insumo.unidad }}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.cantidad_presupuestada" style="width: 100%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.precio_unitario" style="width: 90%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

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
                                                class="btn btn-default"
                                                id="materiales"> +
                                            Materiales
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
                                                            <div class="form-group">
                                                                <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.cantidad_presupuestada" style="width: 100%; height: 25px">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                               $ <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.precio_unitario" style="width: 90%; height: 25px">
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
                                                class="btn btn-default"
                                                id="materiales"> +
                                            M / O
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
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.cantidad_presupuestada" style="width: 100%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.precio_unitario" style="width: 90%; height: 25px">
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
                                                class="btn btn-default"
                                                id="materiales"> +
                                            Herramienta y Equipo
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
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.cantidad_presupuestada" style="width: 100%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.precio_unitario" style="width: 90%; height: 25px">
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
                                                class="btn btn-default"
                                                id="materiales"> +
                                            Maquinaria
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
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.cantidad_presupuestada" style="width: 100%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            $ <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.precio_unitario" style="width: 90%; height: 25px">
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
                                                class="btn btn-default"
                                                id="materiales"> +
                                            Subcontratos
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
                                                        <div class="form-group">
                                                            <input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.cantidad_presupuestada" style="width: 100%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            $<input type="text" step=".01" placeholder="Ingrese Cantidad" :value="insumo.precio_unitario" style="width: 90%; height: 25px">
                                                        </div>
                                                    </td>
                                                    <td>$@{{ parseFloat(insumo.monto_presupuestado).formatMoney(2,'.',',') }}</td>

                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-offset-11">
                                    <button type="button" class="btn btn-success">Crear</button>
                                    <button type="button" class="btn btn-default">Cerrar</button>
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
                                <button type="button" class="btn btn-primary"> <!--:disabled="guardar" v-on:click="agregar_insumo_nuevo()"-->
                                    <i class="fa  fa-plus"></i> Agregar

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Agregar material nuevo al catálogo -->
            <material-index></material-index>

        </section>
    </concepto-extraordinario-create>

@endsection