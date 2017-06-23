@extends('modulo_contable.layout')
@section('title', 'Pólizas Generadas')
@section('contentheader_title', 'PÓLIZAS GENERADA')
@section('contentheader_description', '(EDICIÓN)')

@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_generada.edit', $poliza) !!}

    <div id="app">
        <poliza-generada-edit v-bind:poliza="{{$poliza}}" v-bind:poliza_edit="{{$poliza}}" inline-template v-cloak>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border" style="text-align: right">
                                <h3 class="box-title">Detalle de Póliza: {{$poliza->tipoPolizaContpaq}}</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tr>
                                            <th class="bg-gray-light">Poliza
                                                :<br><label>{{ $poliza->tipoPolizaContpaq}}</label></th>
                                            <th class="bg-gray-light">Fecha de Solicitud
                                                :<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a') }}</label></th>
                                        </tr>
                                        <tr>
                                            <th class="bg-gray-light">Concepto:<br>
                                                <input type="text" class="form-control input-sm" v-model="data.poliza_edit.concepto">
                                            </th>
                                            <th class="bg-gray-light">Usuario
                                                Solicita:<br><label> {{$poliza->user_registro }}</label></th>

                                        </tr>
                                    </table>

                                    <table v-if="data.poliza_edit.poliza_movimientos.length" class="table table-bordered">

                                            <tr>
                                                <th class="bg-gray-light">Cuenta Contable</th>
                                                <th class="bg-gray-light">Nombre Cuenta Contable</th>
                                                <th class="bg-gray-light">Tipo</th>
                                                <th class="bg-gray-light">Debe</th>
                                                <th class="bg-gray-light">Haber</th>
                                                <th class="bg-gray-light">Referencia</th>
                                                <th class="bg-gray-light">Concepto</th>
                                                <th class="bg-gray-light"><button class="btn-xs btn-success"><i class="fa fa-plus" @click="show_add_movimiento" ></i> </button></th>

                                            </tr>
                                                <tr v-for="movimiento in data.poliza_edit.poliza_movimientos">
                                                    <td><input type="text" name="Cuenta Contable" class="form-control input-sm" v-model="movimiento.cuenta_contable"> </td>
                                                    <td>@{{ movimiento.descripcion_cuenta_contable}}</td>
                                                    <td>
                                                        <select name="Tipo" class="form-control input-sm" v-model="movimiento.id_tipo_movimiento_poliza">
                                                            <option :value="1">Debe</option>
                                                            <option :value="2">Haber</option>
                                                        </select>
                                                    </td>
                                                    <td class="bg-gray-light numerico">
                                                        <span v-if="movimiento.id_tipo_movimiento_poliza == 1">
                                                            <input type="number" step="any" class="form-control input-sm" v-model="movimiento.importe">
                                                        </span>
                                                    </td>
                                                    <td class="bg-gray-light numerico">
                                                        <span v-if="movimiento.id_tipo_movimiento_poliza == 2">
                                                            <input type="number" step="any" class="form-control input-sm" v-model="movimiento.importe">
                                                        </span>
                                                    </td>
                                                    <td>@{{movimiento.referencia}}</td>
                                                    <td>@{{movimiento.concepto}}</td>
                                                    <th class="bg-gray-light"><button class="btn-xs btn-danger"><i class="fa fa-remove"></i> </button></th>
                                                </tr>
                                            <tr>

                                                <td colspan="3" class="bg-gray"><b>Sumas Iguales</b></td>
                                                <td class="bg-gray numerico">
                                                    <b>$@{{(poliza.suma_debe)}}</b></td>
                                                <td class="bg-gray numerico">
                                                    <b>$@{{(poliza.suma_haber)}}</b></td>
                                                <td class="bg-gray" colspan="3"></td>
                                            </tr>
                                        </table>
                                        <div class="col-sm-12" style="text-align: right"><h4><b>Total de la Póliza:</b>  $@{{(poliza.total)}}</h4></div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12">
                                    <button :disabled="! cambio" class="btn btn-info pull-right">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Agregar Movimiento -->
                <div id="add_movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addMovimientoModal" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" @click="close_add_movimiento"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Agregar Movimiento</h4>
                            </div>
                            <form id="form_add_movimiento" @submit.prevent="validateForm">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" :class="{'has-error': validation_errors.has('Cuenta Contable')}">
                                            <label for="">Cuenta Contable</label>
                                            <input type="text" v-validate="'required'" class="form-control" name="Cuenta Contable" v-model="form.movimiento.cuenta_contable">
                                            <label class="help" v-show="validation_errors.has('Cuenta Contable')">@{{ validation_errors.first('Cuenta Contable') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" @click="close_add_movimiento">Cerrar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>
        </poliza-generada-edit>
    </div>
@endsection
