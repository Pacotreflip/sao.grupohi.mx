<escalatoria inline-template v-cloak v-if="form.id_tipo_orden == 1" :id_tipo_orden="form.id_tipo_orden">
    <section>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Agregar Escalatoria</h3>
                    </div>
                    <form id="form_add_partida" @submit.prevent="validateForm('form_add_partida', 'add_partida')"  data-vv-scope="form_add_partida">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_add_partida.Descripción')}">
                                        <label><b>Descripción</b></label>
                                        <input v-validate="'required'" :name="'Descripción'" type="text" class="form-control input-sm" v-model="escalatoria.descripcion">
                                        <label class="help" v-show="validation_errors.has('form_add_partida.Descripción')">@{{ validation_errors.first('form_add_partida.Descripción') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_add_partida.Importe')}">
                                        <label><b>Importe</b></label>
                                        <input v-validate="'required'" :name="'Importe'" type="number" step="any" class="form-control input-sm" v-model="escalatoria.importe">
                                        <label class="help" v-show="validation_errors.has('form_add_partida.Importe')">@{{ validation_errors.first('form_add_partida.Importe') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="box-tools">
                                <button type="submit" class="btn-xs btn-primary">
                                <span v-if="guardando">
                                    <i class="fa fa-spin fa-spinner"></i> Guardando
                                </span>
                                    <span v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Partidas</h3>
                        <div class="box-tools pull-right">
                            <button class="btn-default btn" @click="addPartida()"><i class="fa fa-plus text-green"></i></button>
                        </div>
                    </div>
                    <div class="box-body" v-if="form.partidas.length">
                        <div class="table-responsive col-md-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descripción</th>
                                    <th>Importe</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(i, partida) in form.partidas">
                                    <td>@{{ i + 1 }}</td>
                                    <td>@{{ partida.descripcion }}</td>
                                    <td>@{{ partida.importe }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer" v-if="form.partidas.length">
                        <div class="box-tools pull-right">
                            <button class="btn btn-success btn-sm" :disabled="guardando">
                                <span v-if="guardando">
                                    <i class="fa fa-spin fa-spinner"></i> Guardando
                                </span>
                                <v-else>
                                    <i class="fa fa-save"></i> Guardar
                                </v-else>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</escalatoria>
