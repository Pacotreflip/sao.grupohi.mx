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
                            <h3 class="box-title">Filtros para consulta de Conceptos</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Material:</b></label>
                                        <select class="form-control" name="Familia" data-placeholder="BUSCAR MATERIAL"
                                                id="sel_material" v-model="form.filtro_agrupador.id_material"></select>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group"  v-on:click="consulta_precios_material()" style="cursor: pointer" >
                                        <label><b>Precio a buscar:</b></label>
                                       <div class="bg-gray color-palette form-control">
                                           <label style="cursor: pointer" v-for="(precio,index) in form.precios_seleccionados" v-text="'$'+precio+(form.precios_seleccionados.length!=(index+1)?' , ':'')">
                                           </label>
                                       </div>


                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><b>Agrupar por:</b></label>
                                        <br>
                                        @foreach ($tipo_filtro as $filtro)
                                            <input type="radio" value="{{$filtro->id}}"
                                                   v-model="form.filtro_agrupador.id_tipo_filtro">
                                            {{$filtro->descripcion}}
                                            </input>
                                        @endforeach

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-default pull-right"
                                    :disabled="form.filtro_agrupador.id_tipo_filtro==0||form.filtro_agrupador.id_material==0"
                                    v-on:click="buscar_conceptos()">Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros para consulta de Conceptos</h3>
                        </div>
                        <div class="box-body">
                            <table id="agrupadores_table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width:30px"></th>
                                    <th>Agrupador</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th style="width:50px">Cambiar a todo</th>
                                </tr>
                                </thead>

                            </table>
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
                                            <th><input type="checkbox" v-on:click="selecciona_all_precios()" id="select_all_price">
                                                Seleccionar</th>
                                            <th>Precio</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="precio in form.precios_disponibles">
                                            <td><input type="checkbox" :id="precio" :value="precio"
                                                       v-model="form.precios_seleccionados" v-on:click="valida_seleccion_all()"></td>
                                            <td> $<label v-text="precio"></label></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

        </section>
    </cambio-cantidad-insumos-create>

@endsection