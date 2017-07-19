<div id="app">
    <global-errors></global-errors>
    <material-create
            :familia="{{$familia}}"
            v-cloak
            inline-template>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuenta de Materiales
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-sm-6">
                                    <dl>
                                        <dt>ID</dt>
                                        <dd>{{$familia[0]->nivel}}</dd>
                                        <dt>DESCRIPCION</dt>
                                        <dd>{{$familia[0]->descripcion}}</dd>
                                    </dl>
                                </div>

                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Cuentas Configuradas</h3>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="box-body">
                                        <table class="table table-bordered table-striped ">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NIVEL</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>CUENTA</th>
                                                <th>FECHA Y HORA DE REGISTRO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr v-for="(cuenta, index) in data.familia">
                                                <td>@{{index+1}}</td>
                                                <td>@{{cuenta.nivel}}</td>
                                                <td>@{{cuenta.descripcion}}</td>
                                                <td v-if="cuenta.cuenta_material != null">
                                                    @{{ cuenta.cuenta_material.cuenta }}
                                                </td>
                                                <td v-else>
                                                    ---
                                                </td>
                                                <td>@{{cuenta.FechaHoraRegistro}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button title="Editar" class="btn-xs btn-info" type="button" @click="editar(cuenta)"><i class="fa fa-edit"></i> </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>NIVEL</th>
                                                <th>DESCRIPCIÓN</th>
                                                <th>CUENTA</th>
                                                <th>FECHA Y HORA DE REGISTRO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </material-create>
</div>