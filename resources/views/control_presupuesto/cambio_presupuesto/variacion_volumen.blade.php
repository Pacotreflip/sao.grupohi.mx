<variacion-volumen @reset-filtros="filtros = []" inline-template v-cloak v-if="form.id_tipo_orden == 4" :tarjetas="tarjetas" :filtros="filtros" :niveles="niveles" :id_tipo_orden="form.id_tipo_orden" :id_tarjeta="form.id_tarjeta" :bases_afectadas="bases_afectadas">
    <section>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-app pull-right" :disabled="!form.partidas.length || cargando || guardando" data-toggle="modal" data-target="#conceptos_modal" @click="validation_errors.clear('form_save_solicitud'),mostrar_importes_inicial()">
                    <span class="badge bg-green" >@{{ form.partidas.length }}</span>
                    <i class="fa fa-list-ol"></i> Partidas
                </button>
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
                    <form id="form_save_solicitud" @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"  data-vv-scope="form_save_solicitud">
                    <div class="modal-body small">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Tarjeta</th>
                                    <th>Sector</th>
                                    <th>Cuadrante</th>
                                    <th>Unidad</th>
                                    <th>Volumen</th>
                                    <th width="150px">Variación de volumen</th>
                                    <th>-</th>
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
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Variacion de volumen ' + (i+1))}">
                                            <input type="text" :name="'Variacion de volumen ' + (i+1)" v-validate="'required|decimal|regex:[^0]+'" class="form-control input-sm" v-model="concepto.variacion_volumen">
                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Variacion de volumen ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Variacion de volumen ' + (i+1)) }}</label>
                                        </div>
                                    </td>
                                    <td><button type="button" class="btn btn-xs btn-default btn_remove_concepto" :id="concepto.id_concepto"><i class="fa fa-minus text-red"></i></button> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="box box-solid"  >
                            <div class="box-header with-border">
                                <h3 class="box-title">Subtotal de tarjeta</h3>
                            </div>
                            <div class="box-body">

                        <div class="table-responsive" >

                            <ul class="nav nav-tabs">
                                <li v-for="(base,i) in bases_afectadas" :class="i==0?'active':''" v-on:click="mostrar_importes(base.id_base_presupuesto)" ><a data-toggle="tab" >@{{base.base_datos.descripcion}}</a>
                                </li>
                            </ul>
                            <div class="col-sm-12" class="text-center">
                                <span v-if="consultando"><i class="fa fa-spinner fa-spin"></i> </span>
                                <span v-else></span>
                            </div>

                            <table class="table table-bordered table-striped" id="divDetalle">
                                <thead>
                                <tr>
                                    <th class="text-center">Importe conceptos seleccionados</th>
                                    <th class="text-center">Importe conceptos no seleccionados</th>
                                    <th class="text-center">Importe conceptos de tarjeta</th>
                                </tr>
                                </thead>
                                <tbody>
                                 <tr>
                                     <td class="text-right" >$ @{{(parseFloat(importes.total_seleccionados)).formatMoney(2,'.',',')}}</td>
                                     <td class="text-right" >$ @{{(parseFloat(importes.total_sin_seleccion)).formatMoney(2,'.',',')}}</td>
                                     <td class="text-right" >$ @{{(parseFloat(importes.total_tarjeta)).formatMoney(2,'.',',')}}</td>
                                 </tr>

                                </tbody>
                            </table>
                        </div>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                            <label><b>Motivo</b></label>
                            <textarea class="form-control" v-validate="'required'" :name="'Motivo'" v-model="form.motivo"></textarea>
                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
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
</variacion-volumen>
