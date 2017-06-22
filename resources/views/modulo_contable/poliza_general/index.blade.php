@extends('modulo_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'PLANTILLAS DE PÓLIZA')

    <style>

        .borderless td, .borderless th {
            border: none;
        }
    </style>
@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.create') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <poliza-general-create
                v-cloak
                v-bind:polizas="{{ $polizas }}"
                inline-template>
            <section>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Pólizas Generales</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped small index_table" id="example">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo de Póliza</th>
                                            <th>Concepto</th>
                                            <th>Total</th>
                                            <th>Cuadre</th>
                                            <th>Estatus</th>
                                            <th>Poliza ContPaq</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in polizas">

                                            <td>@{{ index + 1  }}</td>
                                            <td>@{{ item.tipos_polizas_contpaq.descripcion}}</td>
                                            <td>@{{ item.concepto}}</td>
                                            <td>@{{ item.total}}</td>
                                            <td>@{{ item.cuadre}}</td>
                                            <td>1</td>
                                            <td>No lanzado</td>
                                            <td style="min-width: 90px;max-width: 90px">

                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-xs btn-default"  data-toggle="modal" data-target="#modal-add-movimiento" v-on:click="ver_detalle(item)">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <button type="button" class="btn btn-xs btn-danger" >
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                </div>

                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Detalle de Pólizas</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tr>
                                            <th colspan="5">Poliza :<br><label v-text="form.poliza_seleccionada.tipo_poliza" ></label> </th>
                                            <th>Fecha de Solicitud :<br><label v-text="form.poliza_seleccionada.fecha_registro" ></label></th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">Concepto: <br><label v-text="form.poliza_seleccionada.concepto" ></label></th>
                                            <th colspan="2">Usuario Solicita</th>

                                        </tr>
                                        <tr>
                                            <td>Cuenta</td>
                                            <td>Cuenta</td>
                                            <td>Cuenta</td>
                                            <td>Debe</td>
                                            <td>Haber</td>
                                            <td>Concepto</td>

                                        </tr>
                                        <tr>
                                            <td class="borderless table-"></td>
                                            <td></td>
                                            <td>Sumas Igiales</td>
                                            <td>$</td>
                                            <td>$</td>
                                           <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal view Detail -->
                <div class="modal fade" id="modal-add-movimiento" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Detalle de Póliza</h4>
                            </div>
                            <div class="modal-body">

                                <table class="table table-bordered table-striped ">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Nombre</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Tipo de Póliza</td>
                                        <td><label v-text="form.poliza_seleccionada.tipo_poliza" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Concepto</td>
                                        <td><label v-text="form.poliza_seleccionada.concepto" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td><label v-text="form.poliza_seleccionada.total" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Cuadre</td>
                                        <td><label v-text="form.poliza_seleccionada.cuadre" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Estatus</td>
                                        <td><label v-text="form.poliza_seleccionada.estatus" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Póliza Contpaq</td>
                                        <td><label v-text="form.poliza_seleccionada.poliza_contpaq" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Usuario Registro</td>
                                        <td><label v-text="form.poliza_seleccionada.poliza_contpaq" ></label></td>
                                    </tr>
                                    <tr>
                                        <td>Fecha y Hora de Registro</td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


            </section>
        </poliza-general-create>
    </div>



@endsection
