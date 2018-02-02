<variacion-volumen @reset-filtros="filtros = []" inline-template v-cloak v-if="form.id_tipo_orden == 4" :tarjetas="tarjetas" :filtros="filtros" :niveles="niveles" :id_tipo_orden="form.id_tipo_orden" :id_tarjeta="form.id_tarjeta">
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
                        <div class="box-tools col-sm-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                <label for="tarjetas_select" class="col-sm-5 control-label">Numero de tarjeta: </label>
                                <div class="col-sm-7">
                                    <select2 :disabled="cargando" v-model="id_tarjeta" :options="tarjetas" class="form-control" id="tarjetas_select">
                                    </select2>
                                </div>

                                </div>
                            </div>
                        </div>
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
                                    <th>Número de Tarjeta</th>
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
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Presupuestada Nueva ' + (i+1))}">
                                            <input type="text" :name="'Cantidad Presupuestada Nueva ' + (i+1)" v-validate="'decimal|regex:[^0]+'" class="form-control input-sm" v-model="concepto.cantidad_presupuestada_nueva">
                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Cantidad Presupuestada Nueva ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Cantidad Presupuestada Nueva ' + (i+1)) }}</label>
                                        </div>
                                    </td>
                                    <td><button type="button" class="btn btn-xs btn-default btn_remove_concepto" :id="concepto.id_concepto"><i class="fa fa-minus text-red"></i></button> </td>
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
