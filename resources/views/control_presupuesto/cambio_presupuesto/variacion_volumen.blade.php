<variacion-volumen inline-template v-cloak v-if="form.id_tipo_orden == 4" :filtros="filtros" :niveles="niveles" :id_tipo_orden="form.id_tipo_orden">
    <section>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-sm" @click="get_conceptos()" :disabled="cargando">
                    <span v-if="cargando">
                        <i class="fa fa-spinner fa-spin"></i> Consultando
                    </span>
                    <span v-else>
                        <i class="fa fa-search"></i> Consultar
                    </span>
                </button>
                <button class="btn btn-app pull-right" :disabled="!form.partidas.length || cargando" data-toggle="modal" data-target="#conceptos_modal" @click="validation_errors.clear('form_save_solicitud')">
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
                            <table id="conceptos_table" class="table table-bordered table-striped">
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
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Partidas</h4>
                    </div>
                    <form id="form_save_solicitud" @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"  data-vv-scope="form_save_solicitud">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Número de Tarjeta</th>
                                            <th>Unidad</th>
                                            <th>Cantidad Presupuestada Original</th>
                                            <th width="200px">Cantidad Presupuestada Nueva</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="concepto in form.partidas">
                                            <td>@{{ concepto.descripcion }}</td>
                                            <td>@{{ concepto.numero_tarjeta }}</td>
                                            <td>@{{ concepto.unidad }}</td>
                                            <td class="text-right">@{{ parseInt(concepto.cantidad_presupuestada).formatMoney(2, ',','.') }}</td>
                                            <td>
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Nueva Cantidad Presupuestada')}">
                                                    <input type="number" :name="'Nueva Cantidad Presupuestada'" v-validate="'required|min_value:0|numeric'" class="form-control input-sm" v-model="concepto.cantidad_presupuestada_nueva">
                                                    <label class="help" v-show="validation_errors.has('form_save_solicitud.Nueva Cantidad Presupuestada')">@{{ validation_errors.first('form_save_solicitud.Nueva Cantidad Presupuestada') }}</label>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                            <label><b>Motivo</b></label>
                                            <textarea class="form-control" v-validate="'required|alpha_spaces'" :name="'Motivo'" v-model="form.motivo"></textarea>
                                            <label class="help" v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                        </div>
                                    </div>
                                </div>
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
</variacion-volumen>
