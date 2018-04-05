@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CAMBIO DE CANTIDAD A INSUMOS <small>(COSTO DIRECTO)</small>')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.cambio_presupuesto.create') !!}
@endsection
@section('main-content')
    <cambio-cantidad-insumos-create
            :id_tipo_orden="8"
            :tipo_filtro="{{$tipo_filtro}}"
            inline-template v-cloak xmlns="http://www.w3.org/1999/html">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros para consulta de Insumos</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Insumo:</b></label>
                                        <select class="form-control" name="Familia" data-placeholder="BUSCAR INSUMO"
                                                id="sel_material" v-model="form.filtro_agrupador.id_material"></select>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" v-on:click="consulta_precios_material()"
                                         style="cursor: pointer">
                                        <label><b>Precio a buscar:</b></label>
                                        <div class="bg-gray color-palette form-control">

                                          <span v-if="consultando_precio">
                                            <i class="fa fa-spinner fa-spin"></i>
                                            </span>
                                            <span v-else>
                                             <label style="cursor: pointer"
                                                    v-for="(precio,index) in form.precios_seleccionados"
                                                    v-text="'$'+precio+(form.precios_seleccionados.length!=(index+1)?' , ':'')">
                                            </label>
                                                </i>
                                        </span>

                                        </div>


                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><b>Agrupar por:</b></label>
                                        <br>
                                        @foreach ($tipo_filtro as $filtro)
                                            <input type="radio" value="{{$filtro->id}}"
                                                   v-model="form.filtro_agrupador.id_tipo_filtro" v-on:click="cambio_texto_filtro('{{$filtro->descripcion}}')">
                                             {{$filtro->descripcion}}
                                            </input>
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-default pull-right"
                                    :disabled="form.filtro_agrupador.id_tipo_filtro==0||form.filtro_agrupador.id_material==0||buscando_agrupados"
                                    v-on:click="buscar_conceptos()" >Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <span v-if="buscando_agrupados">
                         <i class="fa fa-spinner fa-spin"></i>
                    </span>
                    <span v-else>

                    </span>
                </div>
            </div>
            <div class="row" v-if="form.agrupacion.length>0">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Insumos Encontrados</h3>
                        </div>
                        <div class="box-body ">
                            <form id="form_save_solicitud"
                                  @submit.prevent="validateForm('form_save_solicitud', 'save_solicitud')"
                                  data-vv-scope="form_save_solicitud">
                                <div class="table-responsive">
                                <table id="agrupadores_tablex" class="table table-bordered"
                                       v-if="form.agrupacion.length>0">
                                    <thead>
                                    <tr>
                                        <th style="width:20px"></th>
                                        <th>Cantidad de insumos</th>
                                        <th v-text="'Agrupados por '+descripcion_agrupados"></th>
                                        <th>Cantidad original</th>
                                        <th>Cantidad actualizada</th>
                                        <th style="width:20px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="(agrupado,i) in form.agrupacion">
                                        <tr>
                                            <td>
                                                <div class="btn btn-xs btn-default" :id="'div_expand_'+i" :disabled="consultando" v-if="agrupado.mostrar_detalle"
                                                        v-on:click="consulta_detalle_agrupador(i)" >
                                                            <span v-if="consultando&&i==row_consulta">
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                            </span>
                                                            <span v-else>
                                                            <i class="fa  fa-list"></i>
                                                            </span>
                                                </div>
                                                <div v-else class="btn btn-xs btn-default" v-on:click="ocultar_detalle(i)">
                                                    <span>
                                                        <i class="fa  fa-minus"></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>@{{agrupado.cantidad}}</td>
                                            <td>@{{agrupado.agrupador}}</td>
                                            <td>@{{agrupado.precio_unitario}}</td>
                                            <td style="width: 100px">
                                                <div class="form-group"
                                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Actualizada [' + (i + 1) + ']')}">
                                                    <input type="text" step=".01" placeholder="Ingrese Cantidad"
                                                           style="width: 75%"
                                                           v-validate="'decimal|min_value:0'"
                                                           :name="'Cantidad Actualizada [' + (i + 1) + ']'"
                                                           v-model="agrupado.cantidad_todos"
                                                           v-on:blur="cambiaPrecios(i)"
                                                           onkeypress="return filterFloat(event,this);"
                                                    >
                                                    <label class="help"
                                                           v-show="validation_errors.has('form_save_solicitud.Cantidad Actualizada [' + (i + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Actualizada [' + (i + 1) + ']') }}</label>
                                                </div>
                                            </td>
                                            <td style="width: 20px"><input type="checkbox" :id="'checksSel'+i"
                                                                           v-model="agrupado.aplicar_todos" v-on:click="selecciona_rows(i)"></td>

                                        </tr>
                                        <tr v-if="agrupado.mostrar_detalle&&agrupado.items.length>0" :id="'tr_detalle_'+i" >
                                            <td colspan="6">

                                                <table class="table table-bordered" >
                                                    <thead>
                                                    <tr>
                                                        <table class="table table-bordered table-stripped ">
                                                            <thead>
                                                            <tr>
                                                                <th class="bg-gray-active">#</th>
                                                                <th class="bg-gray-active">Sector</th>
                                                                <th class="bg-gray-active">Cuadrante</th>
                                                                <th class="bg-gray-active">Especialidad</th>
                                                                <th class="bg-gray-active">Partida</th>
                                                                <th class="bg-gray-active">Subpartida o Cuenta de costo</th>
                                                                <th class="bg-gray-active">Concepto</th>
                                                                <th class="bg-gray-active">Filtro10</th>
                                                                <th class="bg-gray-active">Filtro11</th>
                                                                <th class="bg-gray-active">Precio unitario original</th>
                                                                <th class="bg-gray-active">Precio unitario nuevo</th>
                                                                <th class="bg-gray-active">Seleccionar</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr v-for="(item,i2) in agrupado.items">
                                                                <td>@{{i2+1 }}</td>
                                                                <td>@{{item.filtro4}}</td>
                                                                <td>@{{item.filtro5}}</td>
                                                                <td>@{{item.filtro6}}</td>
                                                                <td>@{{item.filtro7}}</td>
                                                                <td>@{{item.filtro8}}</td>
                                                                <td>@{{item.filtro9}}</td>
                                                                <td>@{{item.filtro10}}</td>
                                                                <td>@{{item.filtro11}}</td>
                                                                <td>@{{item.precio_unitario}}</td>
                                                                <td>
                                                                    <div class="form-group"
                                                                         :class="{'has-error': validation_errors.has('form_save_solicitud.Cantidad Nueva  [' + (i + 1) + '][' + (i2 + 1) + ']')}">
                                                                    <input type="text"
                                                                           v-model="item.cantidad_nueva"
                                                                           v-validate="'decimal|min_value:0'"
                                                                           :name="'Cantidad Nueva  [' + (i + 1) + '][' + (i2 + 1) + ']'"
                                                                           onkeypress="return filterFloat(event,this);">
                                                                        <label class="help"
                                                                               v-show="validation_errors.has('form_save_solicitud.Cantidad Nueva  [' + (i + 1) + '][' + (i2 + 1) + ']')">@{{ validation_errors.first('form_save_solicitud.Cantidad Nueva  [' + (i + 1) + '][' + (i2 + 1) + ']') }}</label>
                                                                    </div>
                                                                </td>
                                                                <td><input type="checkbox" v-model="item.agregado" :checked="agrupado.aplicar_todos" v-on:click="quitar_row(i)"/>
                                                            </tbody>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                </table>

                                    </template>
                                    </tbody>

                                </table>
                                </div>
                                <br>

                                <div class="form-group"
                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Motivo')}">
                                    <label><b>Motivo</b></label>
                                    <textarea class="form-control" v-validate="'required'" :name="'Motivo'"
                                              v-model="form.motivo"></textarea>
                                    <label class="help"
                                           v-show="validation_errors.has('form_save_solicitud.Motivo')">@{{ validation_errors.first('form_save_solicitud.Motivo') }}</label>
                                </div>
                                <div class="form-group"
                                     :class="{'has-error': validation_errors.has('form_save_solicitud.Area solicitante')}">
                                    <label><b>Área Solicitante</b></label>
                                    <textarea class="form-control" v-validate="'required'"
                                              :name="'Area solicitante'"
                                              v-model="form.area_solicitante"></textarea>
                                    <label class="help"
                                           v-show="validation_errors.has('form_save_solicitud.Area solicitante')">@{{ validation_errors.first('form_save_solicitud.Area solicitante') }}</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" :disabled="guardando">
                                        <span v-if="guardando">
                                            <i class="fa fa-spinner fa-spin"></i> Guardando
                                            </span>
                                        <span v-else>
                                            <i class="fa fa-save"></i> Guardar
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div id="lista_precios_modal" class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Lista de precios disponibles</h4>
                        </div>
                        <div class="modal-body">


                            <div class="table-responsive table-bordered">
                                <div class="col-sm-6 col-sm-offset-3">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" v-on:click="selecciona_all_precios()"
                                                       id="select_all_price">
                                                Seleccionar
                                            </th>
                                            <th>Precio</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="precio in form.precios_disponibles">
                                            <td><input type="checkbox" :id="precio" :value="precio"
                                                       v-model="form.precios_seleccionados"
                                                       v-on:click="valida_seleccion_all()"></td>
                                            <td> $<label v-text="precio"></label></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

        </section>
    </cambio-cantidad-insumos-create>

    <section>


    </section>
@endsection

@section('scripts-content')
    <script>

            function filterFloat(evt,input){
                // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
                var key = window.Event ? evt.which : evt.keyCode;
                var chark = String.fromCharCode(key);
                var tempValue = input.value+chark;
                if(key >= 48 && key <= 57){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    if(key == 8 || key == 13 || key == 0) {
                        return true;
                    }else if(key == 46){
                        if(filter(tempValue)=== false){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
        function filter(__val__){
            var preg = /^([0-9]+\.?[0-9]{0,5})$/;
            if(preg.test(__val__) === true){
                return true;
            }else{
                return false;
            }

        }
    </script>

@endsection