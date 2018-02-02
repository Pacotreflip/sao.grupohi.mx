<variacion-insumos @reset-filtros="filtros = []" inline-template v-cloak v-if="form.id_tipo_orden == 6" :tarjetas="tarjetas" :filtros="filtros" :niveles="niveles" :id_tipo_orden="form.id_tipo_orden" :id_tarjeta="form.id_tarjeta">
    <section>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-app pull-right" :disabled="!form.partidas.length || cargando || guardando" data-toggle="modal" data-target="#insumos_modal" @click="validation_errors.clear('form_save_solicitud')">
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

        <div id="insumos_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ConceptosModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insumos</h4>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-sm-12 ">[C.D.1.15.1.1.10.1.1.1.] SUMINISTRO Y COLOCACIÓN DE CONCRETO REFORZADO, DE ACUERDO A LA ESPECIFICACIÓN 03 30 00, PARA CONSTRUCCIÓN DE RAMPAS. PRECIO POR UNIDAD DE CONCEPTO DE TRABAJO TERMINADO, INCLUYE TODO LO NECESARIO PARA </label>
                            </div>
                        </div>
                    </div>
                    <form id="form_save_solicitud" @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"  data-vv-scope="form_save_solicitud">
                        <div class="modal-body large">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="materiales" class="col-sm-9 control-label"><h4>MATERIALES</h4></label>
                                                <button type="button" class="btn btn-default col-sm-3 pull-right" id="materiales"> + Materiales</button>
                                            </div>
                                        </div>

                                    </div>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Unidad</th>
                                        <th>Cantidad Presupuestada</th>
                                        <th>Nueva Cantidad Presupuestada</th>
                                        <th>Precio Unitario</th>
                                        <th>Nuevo Precio Unitario</th>
                                        <th>-</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="mano_obra" class="col-sm-7 control-label"><h4>MANO DE OBRA</h4></label>
                                                <button type="button" class="btn btn-default col-sm-3 pull-right" id="mano_obra"> + Mano Obra</button>
                                            </div>
                                        </div>

                                    </div>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Unidad</th>
                                        <th>Cantidad Presupuestada</th>
                                        <th>Nueva Cantidad Presupuestada</th>
                                        <th>Precio Unitario</th>
                                        <th>Nuevo Precio Unitario</th>
                                        <th>-</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="herram_equipo" class="col-sm-7 control-label"><h4>HERRAMIENTA Y EQUIPO</h4></label>
                                                <button type="button" class="btn btn-default col-sm-3 pull-right" id="herram_equipo"> + H / E</button>
                                            </div>
                                        </div>

                                    </div>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Unidad</th>
                                        <th>Cantidad Presupuestada</th>
                                        <th>Nueva Cantidad Presupuestada</th>
                                        <th>Precio Unitario</th>
                                        <th>Nuevo Precio Unitario</th>
                                        <th>-</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="maquinaria" class="col-sm-7 control-label"><h4>MAQUINARIA</h4></label>
                                                <button type="button" class="btn btn-default col-sm-3 pull-right" id="maquinaria"> + Maquinaria</button>
                                            </div>
                                        </div>

                                    </div>
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Unidad</th>
                                        <th>Cantidad Presupuestada</th>
                                        <th>Nueva Cantidad Presupuestada</th>
                                        <th>Precio Unitario</th>
                                        <th>Nuevo Precio Unitario</th>
                                        <th>-</th>
                                    </tr>
                                    </thead>
                                    <tbody>

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
</variacion-insumos>
