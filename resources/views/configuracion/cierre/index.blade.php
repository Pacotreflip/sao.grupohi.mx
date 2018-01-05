@extends('configuracion.layout')
@section('title', 'Cierre de Periodo')
@section('contentheader_title', 'CIERRES DE PERIODO')
@section('breadcrumb')
    {!! Breadcrumbs::render('configuracion.cierre.index') !!}
@endsection
@section('main-content')
    <cierre-index inline-template>
        <section>

            <div class="row">
                <div class="col-sm-12">
                    <button @click="generar_cierre" class="btn btn-success btn-app" style="float:right">
                        <i class="glyphicon glyphicon-plus-sign"></i>Cerrar Periodo
                    </button>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultados</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="cierres_table" class="table table-bordered table-stripped">
                                    <thead>
                                    <tr>
                                        <th>Año</th>
                                        <th>Mes</th>
                                        <th>Persona que cerró</th>
                                        <th>Fecha de Cierre</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Año</th>
                                        <th>Mes</th>
                                        <th>Persona que cerró</th>
                                        <th>Fecha de Cierre</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="create_cierre_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Generar Cierre de Periodo</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Fecha</b></label>
                                        <input type="text" id="fecha" class="form-control input-sm" placeholder="Seleccione año y mes del Cierre" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-primary" @click="save_cierre" :disabled="guardando">
                                <span v-if="guardando"><i class="fa fa-spinner fa-spin"></i> Guardando</span>
                                <span v-else><i class="fa fa-save"></i> Guardar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </cierre-index>
@endsection