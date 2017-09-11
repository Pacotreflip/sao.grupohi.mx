@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SISTEMA DE FINANZAS')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.index') !!}

    <comprobante-fondo-fijo-create

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
                                               v-validate="'required'"
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
                                                   id="cumplimiento" v-validate="'required'"
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
                                            <select class="form-control" name="Concepto" id="concepto_select"
                                                    v-validate="'required'" data-placeholder="BUSCAR CONCEPTO"
                                                    v-select2></select>
                                            <input id="id_concepto" class="form-control" type="hidden" name="test"/>

                                            <label class="help"
                                                   v-show="validation_errors.has('form_fondo_fijo.Concepto')">@{{ validation_errors.first('form_fondo_fijo.Concepto') }}</label>
                                        </div>
                                    </div>
                                </div>
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
                                                <td style="white-space: nowrap">
                                                    <select class="form-control" :name="'Material [' + (index + 1) + ']'" :id="'SMaterial'+(index+1)+''" v-validate="'required'" data-placeholder="BUSCAR MATERIAL"
                                                            v-select_material v-model="item.id_material"></select>
                                                    <input :id="'ISMaterial'+(index+1)+''" class="form-control" type="hidden" :name="'Material [' + (index + 1) + ']'"/>
                                                </td>
                                                <td style="white-space: nowrap">
                                                    <label :id="'LSMaterial'+(index+1)+''"></label>
                                                </td>
                                                <td style="white-space: nowrap">
                                                    <input
                                                            :name="'Cantidad [' + (index + 1) + ']'"
                                                            class="form-control input-sm text-right"
                                                            v-model="item.cantidad"/></td>
                                                <td style="white-space: nowrap">
                                                    <input name="Presio(index+1)"
                                                           class="form-control input-sm text-right"
                                                           v-model="item.precio_unitario"/>
                                                </td>
                                                <td style="white-space: nowrap" class="numerico">
                                                    $@{{(parseFloat(item.cantidad*item.precio_unitario)).formatMoney(2,'.',',')}}</td>
                                                <td class="text-center">
                                                    <center>
                                                    <button type="submit" class="btn btn-default pull-right">
                                                        <i class="fa fa-tree"></i>
                                                    </button>
                                                    </center>
                                                </td>
                                                <td style="white-space: nowrap">@{{ index + 1 }}</td>

                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="bg-gray-light" colspan="7" rowspan="3">

                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group"
                                                             :class="{'has-error': validation_errors.has('form_fondo_fijo.Observaciones')}">
                                                            <label for="Observaciones"class="control-label"><strong>Observaciones</strong></label>
                                                            <textarea type="text" name="Referencia" class="form-control input-sm"></textarea>
                                                            <label class="help"
                                                                   v-show="validation_errors.has('form_fondo_fijo.Observaciones')">@{{ validation_errors.first('form_fondo_fijo.Observaciones') }}</label>
                                                        </div>
                                                    </div>


                                                </th>
                                                <th class="bg-gray-light">Subtotal</th>
                                                <th class="bg-gray-light text-right">$@{{total}}</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray-light text-left" style="width: 80px">
                                                    <button type="submit" class="btn btn-danger pull-right">
                                                        <i class="fa fa-refresh"></i> IVA
                                                    </button>
                                                </th>
                                                <th class="bg-gray-light text-right">0.0</th>
                                            </tr>
                                            <tr>

                                                <th class="bg-gray-light">
                                                    Total
                                                </th>
                                                <th class="bg-gray-light text-right">$@{{total}}</th>
                                            </tr>

                                            </thead>

                                        </table>
                                    </div>
                                </div>

                            </div>

                            <div class="box-footer">

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>


            <!-- 3 setup a container element -->
            <div id="jstree">
                <!-- in this example the tree is populated from inline HTML -->
                <ul>
                    <li>Root node 1
                        <ul>
                            <li id="child_node_1">Child node 1</li>
                            <li>Child node 2</li>
                        </ul>
                    </li>
                    <li>Root node 2</li>
                </ul>
            </div>
            <button>demo button</button>


        </section>
    </comprobante-fondo-fijo-create>
@endsection

@section('scripts-content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

    <script>
        $(function () {
            // 6 create an instance when the DOM is ready
            $('#jstree').jstree();
            // 7 bind to events triggered on the tree
            $('#jstree').on("changed.jstree", function (e, data) {
                console.log(data.selected);
            });
            // 8 interact with the tree - either way is OK
            $('button').on('click', function () {
                $('#jstree').jstree(true).select_node('child_node_1');
                $('#jstree').jstree('select_node', 'child_node_1');
                $.jstree.reference('#jstree').select_node('child_node_1');
            });
        });
    </script>

        @endsection