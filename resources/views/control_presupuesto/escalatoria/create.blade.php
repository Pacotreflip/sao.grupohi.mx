@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'SOLICITUD DE CAMBIO AL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <escalatoria-create inline-template v-cloak :id_tipo_orden="{{$tipo_orden}}"
                        bases_afectadas="{{$presupuestos->toJson()}}">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Agregar Escalatoria a la Solicitud</h3>
                            <div class="box-tools pull-right">
                                <button class="btn-default btn" @click="addPartida()"><i class="fa fa-plus text-green"></i></button>
                            </div>
                        </div>
                        <form id="form_save_solicitud" @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"  data-vv-scope="form_save_solicitud">
                            <div class="box-body" v-if="form.partidas.length">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Importe</th>
                                            <th>--</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(partida, i) in form.partidas">
                                            <td>@{{ i + 1 }}</td>
                                            <td>
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Descripción ' + (i+1))}">
                                                    <input v-validate="'required'" :name="'Descripción ' + (i+1)" type="text" class="form-control input-sm" v-model="partida.descripcion">
                                                    <label class="help" v-show="validation_errors.has('form_save_solicitud.Descripción ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Descripción ' + (i+1)) }}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Importe ' + (i+1))}">
                                                    <input v-validate="'required'" :name="'Importe ' + (i+1)" type="number" step="any" class="form-control input-sm" v-model="partida.importe">
                                                    <label class="help" v-show="validation_errors.has('form_save_solicitud.Importe ' + (i+1))">@{{ validation_errors.first('form_save_solicitud.Importe ' + (i+1)) }}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn-default btn btn-xs" @click="removePartida(i)"><i class="fa fa-minus text-red"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="form-group" :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                                    <label><b>Motivo</b></label>
                                                    <textarea class="form-control" v-validate="'required'" :name="'Motivo'" v-model="form.motivo"></textarea>
                                                    <label class="help" v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer" v-if="form.partidas.length">
                                <div class="box-tools pull-right">
                                    <button type="submit" class="btn btn-success btn-sm" :disabled="guardando">
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
        </section>
    </escalatoria-create>

@endsection

