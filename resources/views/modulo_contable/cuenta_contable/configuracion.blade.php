@extends('modulo_contable.layout')
@section('title', 'Cuentas Contables')
@section('contentheader_title', 'CUENTAS CONTABLES')
@section('contentheader_description', '(CONFIGURACIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.cuenta_contable.configuracion') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <cuenta-contable
                v-bind:obra_update_url="'{{route('modulo_contable.obra.update', $currentObra)}}'"
                v-bind:cuenta_store_url="'{{route('modulo_contable.cuenta_contable.store')}}'"
                v-bind:obra="{{$currentObra}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Información de la Obra -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos de la Obra</h3>
                            </div>
                            <form class="form-horizontal" id="form_datos_obra" @submit.prevent="validateForm('form_datos_obra')"  data-vv-scope="form_datos_obra">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Base de Datos CONTPAQ') }">
                                            <label for="BDContPaq" class="col-md-3 control-label"><b>Base de Datos CONTPAQ</b></label>
                                            <div class="col-md-9">
                                                <input type="text" v-validate="'required|alpha_num'" name="Base de Datos CONTPAQ" class="form-control" id="BDContPaq" v-model="obra.BDContPaq">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Base de Datos CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Base de Datos CONTPAQ') }}</label>
                                            </div>
                                            </div>
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ') }">
                                            <label for="NumobraContPaq" class="col-md-3 control-label"><b>Número de Obra CONTPAQ</b></label>
                                            <div class="col-md-9">
                                                <input type="number" v-validate="'required|numeric'" name="Numero de Obra CONTPAQ" class="form-control" id="NumobraContPaq" v-model="obra.NumobraContPaq">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Numero de Obra CONTPAQ') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Formato de Cuentas') }">
                                            <label for="FormatoCuenta" class="col-md-3 control-label"><b>Formato de Cuentas</b></label>
                                            <div class="col-md-9">
                                                <input type="text" v-validate="'required|regex:^\#[\#\-]+\#$'" name="Formato de Cuentas" class="form-control" id="FormatoCuenta" v-model="obra.FormatoCuenta">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Formato de Cuentas')">@{{ validation_errors.first('form_datos_obra.Formato de Cuentas') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info pull-right" :disabled="guardando">
                                    <span v-if="guardando">
                                        <i class="fa fa-spinner fa-spin"></i> Guardando
                                    </span>
                                            <span v-else>
                                        <i class="fa fa-save"></i> Guardar
                                    </span>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="col-md-6">
                        <!-- Configuración de Cuenta -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Configuración de Cuenta</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="BDContPaq" class="control-label">Cuenta</label>
                                        <select2 class="form-control" v-model="form.cuenta_contable.id_int_tipo_cuenta_contable">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info pull-right" :disabled="guardando" data-toggle="modal" data-target="#modal-configurar-cuenta">
                                        <i class="fa fa-cogs"></i> Configurar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cuentas Contables Configuradas</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped small">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo de Cuenta</th>
                                            <th>Prefijo</th>
                                            <th>Cuenta</th>
                                            <th>Editar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Iva etc etc</td>
                                            <td>0000</td>
                                            <td>3456-766-55</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-xs btn-info">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Configuración de Cuenta -->
                <div class="modal fade" id="modal-configurar-cuenta" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Configurar Cuenta</h4>
                            </div>
                            <form id="form_configurar_cuenta" @submit.prevent="validateForm('form_configurar_cuenta')"  data-vv-scope="form_configurar_cuenta">
                            <div class="box-body">
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_configurar_cuenta.Prefijo') }">
                                        <label for="prefijo" class="control-label">Prefijo</label>
                                        <input type="number" v-validate="'required|alpha_num'" name="Prefijo" id="prefijo" class="form-control" v-model="form.cuenta_contable.prefijo">
                                        <label class="help" v-show="validation_errors.has('form_configurar_cuenta.Prefijo')">@{{ validation_errors.first('form_configurar_cuenta.Prefijo') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_configurar_cuenta.Cuenta Contable') }">
                                        <label for="cuenta" class="control-label">Cuenta Contable</label>
                                        <input type="number" v-validate="'required|alpha_num'" name="Cuenta Contable" id="Cuenta" class="form-control"  v-model="form.cuenta_contable.cuenta_contable">
                                        <label class="help" v-show="validation_errors.has('form_configurar_cuenta.Cuenta Contable')">@{{ validation_errors.first('form_configurar_cuenta.Cuenta Contable') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-info pull-right" :disabled="guardando">Guardar</button>
                            </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
            </section>
        </cuenta-contable>
    </div>
@endsection