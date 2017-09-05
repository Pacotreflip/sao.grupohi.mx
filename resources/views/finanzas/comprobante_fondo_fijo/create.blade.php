@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'SISTEMA DE FINANZAS')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.index') !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Información del Comprobante</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Fondo Fijo</strong></label>
                            <select name="id_referente" class="form-control input-sm" v-model="form.comprobante.id_referente">
                                <option value>[--SELECCIONE--]</option>
                                @foreach($fondos as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>


                            <input type="text" name="descripcion" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Referencia</strong></label>
                            <input type="text" name="descripcion" class="form-control input-sm">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Fecha</strong></label>
                            <input type="text" name="descripcion" class="form-control input-sm">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Naturaleza</strong></label>
                            <input type="text" name="descripcion" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Requisicion</strong></label>
                            <input type="text" name="descripcion" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Salida</strong></label>
                            <input type="text" name="descripcion" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion" class="control-label"><strong>Concepto</strong></label>
                            <input type="text" name="descripcion" class="form-control input-sm">
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
@endsection
