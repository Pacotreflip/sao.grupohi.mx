@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SISTEMA DE FINANZAS')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.index') !!}

    <comprobante-fondo-fijo-create

            inline-template
            v-cloak>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <div class="col-md-12">

                            <h3 class="box-title">Información del Comprobante</h3>

                            <div class="form-group pull-right ">
                                <label for="descripcion" class="control-label"><strong>Fecha</strong></label>
                                <input type="text" name="fecha" class="form-control input-sm " id="fecha"
                                       v-datepicker>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion" class="control-label"><strong>Fondo Fijo</strong></label>
                                <select name="id_referente" class="form-control input-sm"
                                        v-model="form.comprobante.id_referente">
                                    <option value>[--SELECCIONE--]</option>
                                    @foreach($fondos as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion" class="control-label"><strong>Referencia</strong></label>
                                <input type="text" class="form-control input-sm"
                                       v-model="form.comprobante.referencia">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion" class="control-label"><strong>Cumplimiento</strong></label>
                                <input type="text" name="cumplimiento" class="form-control input-sm " id="cumplimiento"
                                       v-datepicker>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion" class="control-label"><strong>Naturaleza</strong></label>
                                <select name="id_naturaleza" class="form-control input-sm"
                                        v-model="form.comprobante.id_naturaleza">
                                    <option value>[--SELECCIONE--]</option>
                                    <option value="0">Gastos Varios</option>
                                    <option value="1">Materiales / Servicios</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="descripcion" class="control-label"><strong>Concepto</strong></label>
                                <select class="form-control" id="concepto_select" data-placeholder="BUSCAR CONCEPTO"
                                        v-select2></select>
                                <input name="id_concepto" id="id_concepto" class="form-control" type="hidden"/>
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
            </div>
        </div>


    </comprobante-fondo-fijo-create>
@endsection
