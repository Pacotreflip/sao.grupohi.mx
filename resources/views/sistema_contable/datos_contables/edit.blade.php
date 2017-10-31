@extends('sistema_contable.layout')
@section('title', 'Datos Contables')
@section('contentheader_title', 'DATOS CONTABLES')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.datos_contables.edit', $datos_contables) !!}
@endsection
@section('main-content')

    <global-errors></global-errors>
    <datos-contables-edit
                :datos_contables_update_url="'{{route('sistema_contable.datos_contables.update', $datos_contables)}}'"
                :datos_contables="{{$datos_contables}}"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <!-- Datos contables de la Obra -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h1 class="box-title">Datos Contables de la Obra</h1>
                        </div>
                        <form id="form_datos_obra" @submit.prevent="validateForm('form_datos_obra', 'save_datos_obra')"  data-vv-scope="form_datos_obra">
                            <div class="box-body">
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Base de Datos CONTPAQ') }">
                                        <label for="BDContPaq" class="control-label"><b>Base de Datos CONTPAQ</b></label>
                                        <input type="text" v-validate="'required'" name="Base de Datos CONTPAQ" class="form-control" id="BDContPaq" v-model="data.datos_contables.BDContPaq">
                                        <label class="help" v-show="validation_errors.has('form_datos_obra.Base de Datos CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Base de Datos CONTPAQ') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ') }">
                                        <label for="NumobraContPaq" class="control-label"><b>Número de Obra CONTPAQ</b></label>
                                        <input type="number" v-validate="'required|numeric'" name="Numero de Obra CONTPAQ" class="form-control" id="NumobraContPaq" v-model="data.datos_contables.NumobraContPaq">
                                        <label class="help" v-show="validation_errors.has('form_datos_obra.Numero de Obra CONTPAQ')">@{{ validation_errors.first('form_datos_obra.Numero de Obra CONTPAQ') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" :class="{'has-error': validation_errors.has('form_datos_obra.Formato de Cuentas') }">
                                        <label for="FormatoCuenta" class="control-label"><b>Formato de Cuentas</b></label>
                                        <input type="text" v-validate="'required|regex:^\#[\#\-]+\#$'" name="Formato de Cuentas" class="form-control" id="FormatoCuenta" v-model="data.datos_contables.FormatoCuenta">
                                        <label class="help" v-show="validation_errors.has('form_datos_obra.Formato de Cuentas')">@{{ validation_errors.first('form_datos_obra.Formato de Cuentas') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><b>Afectación Contable de Almacenes</b></label><br>
                                        <input type="checkbox"  v-model="data.datos_contables.manejo_almacenes">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><b>Costo por tipo de gasto</b></label><br>
                                        <input type="checkbox" v-model="data.datos_contables.costo_en_tipo_gasto">
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
            </section>
        </datos-contables-edit>
@endsection