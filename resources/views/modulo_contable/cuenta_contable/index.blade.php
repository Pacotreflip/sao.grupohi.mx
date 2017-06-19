@extends('modulo_contable.layout')
@section('title', 'Cuentas Contables')
@section('contentheader_title', 'CUENTAS CONTABLES')
@section('contentheader_description', '(CONFIGURACIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.cuenta_contable.index') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <cuenta-contable-create
                v-cloak
                inline-template>
            <section>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Información general de la Obra</h3>
                    </div>
                    <form id="form_datos_obra">
                        <div class="box-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="BDContPaq" class="control-label">Base de Datos CONTPAQ</label>
                                    <input type="text" class="form-control" id="BDContPaq">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="NumobraContPaq" class="control-label">Número de Obra CONTPAQ</label>
                                    <input type="number" class="form-control" id="NumobraContPaq">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="FormatoCuenta" class="control-label">Formato de Cuentas</label>
                                    <input type="text" class="form-control" id="FormatoCuenta">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info pull-right" @click="confirm_datos_obra" :disabled="guardando">
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
            </section>
        </cuenta-contable-create>
    </div>
@endsection