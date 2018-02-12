<variacion-volumen @reset-filtros="filtros = []" inline-template v-cloak v-if="form.id_tipo_orden == 4" :tarjetas="tarjetas" :filtros="filtros" :niveles="niveles" :id_tipo_orden="form.id_tipo_orden" :id_tarjeta="form.id_tarjeta" :bases_afectadas="bases_afectadas">
    <section>
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
                                            <input type="text" :name="'Volúmen del Cambio ' + (i+1)" v-validate="'required|decimal|regex:[^0]+'" class="form-control input-sm" v-model="concepto.variacion_volumen">
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
