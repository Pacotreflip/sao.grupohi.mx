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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Fondo Fijo</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Referencia</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Fecha</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Naturaleza</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Requisicion</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Salida</label>
                            <input type="text" name="descripcion" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion" class="control-label">Concepto</label>
                            <input type="text" name="descripcion" class="form-control">
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
