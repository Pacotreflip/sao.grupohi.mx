<variacion-insumos @reset-filtros="filtros = []" inline-template v-cloak v-if="form.id_tipo_orden == 6"
                   :tarjetas="tarjetas" :filtros="filtros" :niveles="niveles" :id_tipo_orden="form.id_tipo_orden"
                   :id_tarjeta="form.id_tarjeta">
    <section>
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

        <div id="insumos_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ConceptosModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
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
                        <form id="form_save_solicitud"
                              @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"
                              data-vv-scope="form_save_solicitud">
                            <div class="modal-body small" v-show="form.agrupadas.length > 1">
                                <div class="table-responsive" v-show="concepto.conceptos.MATERIALES.insumos">
                                    <table class="table table-striped">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="materiales" class="col-sm-9 control-label"><h4>
                                                            MATERIALES</h4></label>
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="materiales" v-on:click="addInsumoTipo(1)"> + Materiales
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.MATERIALES.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,1)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo material [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>
                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario material [' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%" :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,1)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario material [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario material [' + (i + 1) + ']') }}</label>
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
                                                    <label for="mano_obra" class="col-sm-7 control-label"><h4>MANO DE
                                                            OBRA</h4></label>
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="mano_obra" v-on:click="addInsumoTipo(2)"> + Mano Obra
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.MANOOBRA.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,2)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo mano de obra [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>
                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario mano de obra [' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%" :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,2)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario mano de obra [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario mano de obra [' + (i + 1) + ']') }}</label>
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
                                <div class="table-responsive" v-show="concepto.conceptos.HERRAMIENTAYEQUIPO.insumos">
                                    <table class="table table-striped">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="herram_equipo" class="col-sm-7 control-label"><h4>
                                                            HERRAMIENTA Y EQUIPO</h4></label>
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="herram_equipo" v-on:click="addInsumoTipo(4)"> + H / E
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.HERRAMIENTAYEQUIPO.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo herramienta[' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,4)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo herramienta[' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo herramienta[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo herramienta[' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>
                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario herramienta [' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%" :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,4)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario herramienta [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario herramienta [' + (i + 1) + ']') }}</label>
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
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="maquinaria" v-on:click="addInsumoTipo(8)"> + Maquinaria
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.MAQUINARIA.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo maquinaria[' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,8)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo maquinaria[' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo maquinaria[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo maquinaria[' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>
                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario maquinaria[' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%" :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,8)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario maquinaria[' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario maquinaria[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario maquinaria[' + (i + 1) + ']') }}</label>
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

                                <div class="form-group"
                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                    <label><b>Motivo</b></label>
                                    <textarea class="form-control" v-validate="'required'" :name="'Motivo'"
                                              v-model="form.motivo"></textarea>
                                    <label class="help"
                                           v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                </div>
                            </div>

                            <div class="modal-body small" v-show="form.agrupadas.length === 1">
                                <div class="table-responsive" v-show="concepto.conceptos.MATERIALES.insumos">
                                    <table class="table table-striped">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="materiales" class="col-sm-9 control-label"><h4>
                                                            MATERIALES Unitario</h4></label>
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="materiales" v-on:click="addInsumoTipo(1)"> + Materiales
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Cantidad Presupuestara Actual</th>
                                            <th>Cantidad Presupuestara Nueva</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.MATERIALES.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,1)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo material [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular_cantidad(insumo.id_elemento, i,1)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo material [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo material [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario material [' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%"
                                                            :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                            :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,1)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario material [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario material [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario material [' + (i + 1) + ']') }}</label>
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
                                                    <label for="mano_obra" class="col-sm-7 control-label"><h4>MANO DE
                                                            OBRA</h4></label>
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="mano_obra" v-on:click="addInsumoTipo(2)"> + Mano Obra
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Cantidad Presupuestara Actual</th>
                                            <th>Cantidad Presupuestara Nueva</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.MANOOBRA.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,2)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo mano de obra [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular_cantidad(insumo.id_elemento, i,2)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo mano de obra [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo mano de obra [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario mano de obra [' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%"
                                                            :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                            :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,2)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario mano de obra [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario mano de obra [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario mano de obra [' + (i + 1) + ']') }}</label>
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
                                <div class="table-responsive" v-show="concepto.conceptos.HERRAMIENTAYEQUIPO.insumos">
                                    <table class="table table-striped">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="herram_equipo" class="col-sm-7 control-label"><h4>
                                                            HERRAMIENTA Y EQUIPO</h4></label>
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="herram_equipo" v-on:click="addInsumoTipo(4)"> + H / E
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Cantidad Presupuestara Actual</th>
                                            <th>Cantidad Presupuestara Nueva</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.HERRAMIENTAYEQUIPO.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo herramienta[' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,4)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo herramienta[' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo herramienta[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo herramienta[' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo herramienta [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular_cantidad(insumo.id_elemento, i,4)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo herramienta [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo herramienta [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario herramienta [' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%"
                                                            :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                            :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,4)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario herramienta [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario herramienta [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario herramienta [' + (i + 1) + ']') }}</label>
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
                                                    <button type="button" class="btn btn-default col-sm-3 pull-right"
                                                            id="maquinaria" v-on:click="addInsumoTipo(8)"> + Maquinaria
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Unidad</th>
                                            <th>Rendimiento Actual</th>
                                            <th>Rendimiento Nuevo</th>
                                            <th>Cantidad Presupuestara Actual</th>
                                            <th>Cantidad Presupuestara Nueva</th>
                                            <th>Precio Unitario Actual</th>
                                            <th>Precio Unitario Nuevo</th>
                                            <th>-</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(insumo, i) in concepto.conceptos.MAQUINARIA.insumos">
                                            <td>@{{ i+1 }}</td>
                                            <td>@{{ insumo.descripcion }}</td>
                                            <td>@{{ insumo.unidad }}</td>
                                            <td>@{{ parseFloat(insumo.rendimiento_actual).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo maquinaria[' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :class="'rendimiento'+insumo.id_elemento+'_' + i"
                                                           :id="'c_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular(insumo.id_elemento, i,8)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo maquinaria[' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo maquinaria[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo maquinaria[' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td>@{{ parseFloat(insumo.cantidad_presupuestada).formatMoney(3,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Rendimiento nuevo maquinaria [' + (i + 1) + ']')}">
                                                    <input type="number" step=".01" placeholder="0.0" style="width: 90%"
                                                           :id="'r_p_'+insumo.id_elemento+'_' + i"
                                                           @change="recalcular_cantidad(insumo.id_elemento, i,8)"
                                                           v-validate="insumo.nuevo==true ? 'required' : ''"
                                                           :name="'Rendimiento nuevo maquinaria [' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Rendimiento nuevo maquinaria [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Rendimiento nuevo maquinaria [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>

                                            <td :id="'p_u_'+ insumo.id_elemento+ '_' + i">
                                                $@{{ parseFloat(insumo.precio_unitario).formatMoney(2,'.',',') }}</td>
                                            <td>
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Precio unitario maquinaria[' + (i + 1) + ']')}">
                                                    $<input type="number" step=".01" placeholder="0.0"
                                                            style="width: 90%"
                                                            :class="'pre_unit'+insumo.id_elemento+'_' + i"
                                                            :id="'m_p_'+insumo.id_elemento+'_' + i"
                                                            @change="recalcular_monto(insumo.id_elemento, i,8)"
                                                            v-validate="insumo.nuevo==true ? 'required' : ''"
                                                            :name="'Precio unitario maquinaria[' + (i + 1) + ']'">
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Precio unitario maquinaria[' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Precio unitario maquinaria[' + (i + 1) + ']') }}</label>
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

            <div id="add_insumo_modal" class="modal fade" role="dialog" aria-labelledby="addInsumosModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Agregar Insumos</h4>

                            <div class="box-tools pull-right">
                                <a v-on:click="$emit('abrirModalMateriales',tipo_insumo)" class="btn btn-success btn-app" style="float:right">
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
                                <button type="button" class="btn btn-default" v-on:click="cancelar_add_insumo()">
                                    Cancelar
                                </button>
                                <button type="button" class="btn btn-primary" v-on:click="agregar_insumo_nuevo()">
                                    <i class="fa  fa-plus"></i> Agregar

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <material-index></material-index>
        </div>

    </section>
</variacion-insumos>
