@extends('sistema_contable.layout')
@section('title', 'Póliza Generada')
@section('contentheader_title', 'PREPÓLIZAS GENERADAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.index') !!}
@endsection
@section('main-content')
    <poliza-generada-index
            inline-template
            v-cloak
            :editar_prepolizas_generadas="{{ \Entrust::can(['editar_prepolizas_generadas']) ? 'true' : 'false' }}">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Opciones de Búsqueda</h3>
                        </div>
                        <div class="box-body">
                            {!! Form::model(Request::only(['fechas', 'estatus']), ['method' => 'GET']) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Rango de Fechas</b></label>

                                        <input type="text" class="form-control pull-right" id="fechas" value="{{$fechas}}" name="fechas">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Estatus</b></label>
                                        <Select class="form-control" name="estatus" id="estatus">
                                            <option value="">Todas</option>
                                            index
                                            @foreach($est_prepolizas as $key=>$value)
                                                <option value="{{$key}}" {{$key==$estatus&&$key!=""?'selected':''}}>{{$value}}</option>
                                            @endforeach
                                        </Select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b>Tipo de Póliza</b></label>
                                        <Select class="form-control" name="tipo" id="tipo">
                                            <option value="">Todas</option>
                                            @foreach($tipo_polizas as $tipo_poliza)
                                                <option value="{{$tipo_poliza->id_transaccion_interfaz}}" {{$tipo_poliza->id_transaccion_interfaz==$tipo?'selected':''}}>{{$tipo_poliza->descripcion}}</option>
                                            @endforeach
                                        </Select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-sm btn-primary pull-right" type="button" @click="consultar()">Buscar</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Prepólizas Generadas</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="prepolizas_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo de Póliza</th>
                                        <th>Tipo de Transaccion</th>
                                        <th>Concepto</th>
                                        <th>Fecha de Prepóliza</th>
                                        <th>Total</th>
                                        <th>Cuadre</th>
                                        <th>Estatus</th>
                                        <th>Póliza ContPaq</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo de Póliza</th>
                                        <th>Tipo de Transaccion</th>
                                        <th>Concepto</th>
                                        <th>Fecha de Prepóliza</th>
                                        <th>Total</th>
                                        <th>Cuadre</th>
                                        <th>Estatus</th>
                                        <th>Póliza ContPaq</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </poliza-generada-index>
@endsection