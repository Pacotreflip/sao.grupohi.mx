@extends('sistema_contable.layout')
@section('title', 'Datos Contables')
@section('contentheader_title', 'DATOS CONTABLES')
@section('contentheader_description', '(EDICION)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.datos_contables.edit', $datos_contables) !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <datos-contables-edit
                :datos_contables_update_url="'{{route('sistema_contable.datos_contables.update', $datos_contables)}}'"
                :datos_contables="{{$datos_contables}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Datos contables de la Obra -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Datos Contables de la Obra</h3>
                            </div>
                            <form class="form-horizontal" id="form_datos_obra" @submit.prevent="validateForm('form_datos_obra', 'save_datos_obra')"  data-vv-scope="form_datos_obra">
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Base de Datos CONTPAQ') }">
                                            <label for="BDContPaq" class="col-md-3 control-label"><b>Base de Datos CONTPAQ</b></label>
                                            <div class="col-md-9">
                                                <input type="text" v-validate="'required'" name="Base de Datos CONTPAQ" class="form-control" id="BDContPaq" v-model="data.datos_contables.BDContPaq">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Base de Datos CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Base de Datos CONTPAQ') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ') }">
                                            <label for="NumobraContPaq" class="col-md-3 control-label"><b>Número de Obra CONTPAQ</b></label>
                                            <div class="col-md-9">
                                                <input type="number" v-validate="'required|numeric'" name="Numero de Obra CONTPAQ" class="form-control" id="NumobraContPaq" v-model="data.datos_contables.NumobraContPaq">
                                                <label class="help" v-show="validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Numero de Obra CONTPAQ') }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Formato de Cuentas') }">
                                            <label for="FormatoCuenta" class="col-md-3 control-label"><b>Formato de Cuentas</b></label>
                                            <div class="col-md-9">
                                                <input type="text" v-validate="'required|regex:^\#[\#\-]+\#$'" name="Formato de Cuentas" class="form-control" id="FormatoCuenta" v-model="data.datos_contables.FormatoCuenta">
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
                </div>
            </section>
        </datos-contables-edit>
    </div>
@endsection