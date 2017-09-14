@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'COMPROBANTE DE FONDO FIJO')
@section('contentheader_description', '(EDIT)')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.comprobante_fondo_fijo.create') !!}

    <comprobante-fondo-fijo-edit
            :url_comprobante_fondo_fijo_update="'{{route('finanzas.comprobante_fondo_fijo.update',$comprobante_fondo_fijo)}}'"
            :url_comprobante_fondo_fijo_show="'{{route('finanzas.comprobante_fondo_fijo.show',$comprobante_fondo_fijo)}}'"
            :comprobante_items="{{$items}}"
            :comprobante="{{$comprobante_fondo_fijo}}"
            inline-template
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">

                    <form id="form_fondo_fijo" @submit.prevent="validateForm('form_fondo_fijo','confirm_save_fondo')"
                          data-vv-scope="form_fondo_fijo">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <div class="col-md-12">

                                    <h3 class="box-title">Información del Comprobante</h3>

                                    <div class="form-group pull-right "
                                         :class="{'has-error': validation_errors.has('form_fondo_fijo.Fecha')}">
                                        <label for="Fecha" class="control-label"><strong>Fecha</strong></label>
                                        <input type="text" name="Fecha" class="form-control input-sm " id="fecha"
                                               v-validate="'required'" v-model="form.comprobante.fecha"
                                               v-datepicker>
                                        <label class="help"
                                               v-show="validation_errors.has('form_fondo_fijo.Fecha')">@{{ validation_errors.first('form_fondo_fijo.Fecha') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Fondo Fijo')}">
                                            <label for="descripcion" class="control-label"><strong>Fondo
                                                    Fijo</strong></label>

                                            <select name="Fondo Fijo" class="form-control input-sm"
                                                    v-validate="'required'"
                                                    v-model="form.comprobante.id_referente">
                                                <option value>[--SELECCIONE--]</option>
                                                @foreach($fondos as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_fondo_fijo.Fondo Fijo')">@{{ validation_errors.first('form_fondo_fijo.Fondo Fijo') }}</label>

                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Referencia')}">
                                            <label for="Referencia"
                                                   class="control-label"><strong>Referencia</strong></label>
                                            <input type="text" name="Referencia" class="form-control input-sm"
                                                   v-model="form.comprobante.referencia" v-validate="'required'">
                                            <label class="help"
                                                   v-show="validation_errors.has('form_fondo_fijo.Referencia')">@{{ validation_errors.first('form_fondo_fijo.Referencia') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Cumplimiento')}">
                                            <label for="Cumplimiento"
                                                   class="control-label"><strong>Cumplimiento</strong></label>
                                            <input type="text" name="Cumplimiento" class="form-control input-sm "
                                                   id="cumplimiento" v-validate="'required'" v-model="form.comprobante.cumplimiento"
                                                   v-datepicker>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_fondo_fijo.Cumplimiento')">@{{ validation_errors.first('form_fondo_fijo.Cumplimiento') }}</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Naturaleza')}">
                                            <label for="Naturaleza"
                                                   class="control-label"><strong>Naturaleza</strong></label>
                                            <select name="Naturaleza" class="form-control input-sm"
                                                    v-model="form.comprobante.id_naturaleza" v-validate="'required'">
                                                <option value>[--SELECCIONE--]</option>
                                                <option value="0">Gastos Varios</option>
                                                <option value="1">Materiales / Servicios</option>
                                            </select>
                                            <label class="help"
                                                   v-show="validation_errors.has('form_fondo_fijo.Naturaleza')">@{{ validation_errors.first('form_fondo_fijo.Naturaleza') }}</label>
                                        </div>
                                    </div>


                                    <div class="col-md-8">
                                        <div class="form-group"
                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Concepto')}">
                                            <label for="Concepto"
                                                   class="control-label"><strong>Concepto</strong></label>
                                            <select class="form-control" id="concepto_select"
                                                     :data-placeholder="form.comprobante.concepto.path"
                                                    v-select2></select>
                                            <input id="id_concepto" class="form-control" type="hidden" name="Concepto" v-validate="'required'"/>

                                            <label class="help"
                                                   v-show="validation_errors.has('form_fondo_fijo.Concepto')">@{{ validation_errors.first('form_fondo_fijo.Concepto') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="aux">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="bg-gray-light">#</th>
                                                <th class="bg-gray-light">Item</th>
                                                <th class="bg-gray-light">Unidad</th>
                                                <th class="bg-gray-light">Cantidad</th>
                                                <th class="bg-gray-light">Precio</th>
                                                <th class="bg-gray-light">Monto</th>
                                                <th class="bg-gray-light">Destino</th>
                                                <th class="bg-gray-light">
                                                    <button class="btn btn-xs btn-success" type="button"
                                                            @click="add_item" title="Nuevo"><i class="fa fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, index) in form.items">
                                                <td style="white-space: nowrap">@{{ index + 1 }}</td>
                                                <td class="form-group" :class="{'has-error': validation_errors.has('form_fondo_fijo.Item [' + (index + 1) + ']')}" v-show="form.comprobante.id_naturaleza==1"  >

                                                    <select class="form-control" :name="'Item [' + (index + 1) + ']'" :id="(index+1)" v-validate="form.comprobante.id_naturaleza==1 ? 'required' : ''"  :data-placeholder="item.material"
                                                            v-select_material v-model="item.id_material"  ></select>
                                                    <input :id="'I'+(index+1)+''" class="form-control" type="hidden" :name="'Item [' + (index + 1) + ']'" v-validate="form.comprobante.id_naturaleza==1 ? 'required' : ''"/>
                                                    <label class="help" v-show="validation_errors.has('form_fondo_fijo.Item [' + (index + 1) + ']')">@{{ validation_errors.first('form_fondo_fijo.Item [' + (index + 1) + ']') }}</label>
                                                </td>
                                                <td style="white-space: nowrap"  class="form-group" :class="{'has-error': validation_errors.has('form_fondo_fijo.Item  [' + (index + 1) + ']')}" v-show="form.comprobante.id_naturaleza==0">
                                                    <input  class="form-control input-sm text-right" type="text" :name="'Item  [' + (index + 1) + ']'" v-validate="form.comprobante.id_naturaleza==0 ? 'required' : ''" v-model="item.gastos_varios"/>
                                                <label class="help" v-show="validation_errors.has('form_fondo_fijo.Item  [' + (index + 1) + ']')">@{{ validation_errors.first('form_fondo_fijo.Item  [' + (index + 1) + ']') }}</label>
                                                </td>

                                                <td style="white-space: nowrap">
                                                    <label :id="'L'+(index+1)+''">
                                                    </label>
                                                    <input type="hidden" v-model="item.unidad" :id="'UL'+(index+1)+''">
                                                    <button @click="item_material(index,item)" :id="'btn'+(index+1)+''" style="display:none" type="button"></button>
                                                </td>
                                                <td class="form-group"  :class="{'has-error': validation_errors.has('form_fondo_fijo.Cantidad [' + (index + 1) + ']')}">
                                                    <input :name="'Cantidad [' + (index + 1) + ']'" class="form-control input-sm text-right" v-model="item.cantidad" v-validate="'required|numeric'"/>
                                                    <label class="help" v-show="validation_errors.has('form_fondo_fijo.Cantidad [' + (index + 1) + ']')">@{{ validation_errors.first('form_fondo_fijo.Cantidad [' + (index + 1) + ']') }}</label>
                                                </td>

                                                <td  class="form-group" :class="{'has-error': validation_errors.has('form_fondo_fijo.Precio [' + (index + 1) + ']')}">
                                                    <input :name="'Precio [' + (index + 1) + ']'" class="form-control input-sm text-right" v-model="item.precio_unitario" v-validate="'required|decimal'"/>
                                                    <label class="help" v-show="validation_errors.has('form_fondo_fijo.Precio [' + (index + 1) + ']')">@{{ validation_errors.first('form_fondo_fijo.Precio [' + (index + 1) + ']') }}</label>

                                                </td>
                                                <td style="white-space: nowrap" class="numerico">
                                                    $@{{(parseFloat(item.cantidad*item.precio_unitario)).formatMoney(2,'.',',')}}</td>
                                                <td  class="form-group" :class="{'has-error': validation_errors.has('form_fondo_fijo.Destino [' + (index + 1) + ']')}">
                                                    <label v-text="item.destino" v-show="item.destino" ></label>

                                                    <div  data-toggle="modal" data-target="#myModal" class="btn btn-default btn-xs" @click="curent_item(item)" v-if="form.comprobante.id_concepto">
                                                        <i class="fa fa-fw fa-sitemap"></i>
                                                    </div>
                                                    <input v-model="item.destino" class="form-control" type="hidden" :name="'Destino [' + (index + 1) + ']'" v-validate="'required'"/>
                                                    <label class="help" v-show="validation_errors.has('form_fondo_fijo.Destino [' + (index + 1) + ']')">@{{ validation_errors.first('form_fondo_fijo.Destino [' + (index + 1) + ']') }}</label>

                                                </td>
                                                <td style="white-space: nowrap">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <td class="bg-gray-light" colspan="7" rowspan="3">

                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Observaciones')}">
                                                            <label for="Observaciones" class="control-label"><strong>Observaciones</strong></label>
                                                            <textarea type="text" name="Referencia" class="form-control input-sm" style="resize: none" v-model="form.comprobante.observaciones"></textarea>
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_fondo_fijo.Observaciones')">@{{ validation_errors.first('form_fondo_fijo.Observaciones') }}</label>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="bg-gray-light"><strong>Subtotal</strong></td>
                                                <td class="bg-gray-light text-right" style="width: 200px"><strong>$@{{subtotal}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="bg-gray-light text-left" style="width: 80px">
                                                    <button type="button" class="btn btn-danger pull-right" @click="habilitaIva()">
                                                        <i class="fa fa-refresh" > IVA</i>
                                                    </button>
                                                </td>
                                                <td class="bg-gray-light" >
                                                        <input class="form-control input-sm text-right" type="text" v-model="form.iva" :disabled="!form.cambio_iva" width="10px"/>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="bg-gray-light">
                                                    <strong>Total</strong>
                                                </td>
                                                <th class="bg-gray-light text-right"><strong>$@{{total}}</strong></th>
                                            </tr>

                                            </thead>

                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">

                                <div class="col-md-12">
                                    @permission('editar_comprobante_fondo_fijo')
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                    @endpermission
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Modal arbol conceptos-->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="arbolConcetos" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"  aria-label="Close" data-dismiss="modal">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">
                        <span >
                            Conceptos
                        </span>
                            </h4>
                        </div>
                        <div class="modal-body" style="overflow-x: auto;">
                            <div id="jstree"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </comprobante-fondo-fijo-edit>

@endsection