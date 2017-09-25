@extends('compras.layout')
@section('title', 'Reportes')
@section('contentheader_title', 'ORDEN DE PAGO ESTIMACIÓN')


@section('main-content')
    {!! Breadcrumbs::render('reportes.subcontratos.estimacion') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Datos de Consulta</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Contratista</strong></label>
                            <select class="form-control input-sm" name="id_empresa">
                                <option value>[--SELECCIONE--]</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id_empresa}}">{{$empresa->razon_social}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Subcontrato</strong></label>
                            <select class="form-control input-sm" name="id_empresa">
                                <option value>[--SELECCIONE--]</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><strong>Estimación</strong></label>
                            <select class="form-control input-sm" name="id_empresa">
                                <option value>[--SELECCIONE--]</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-12">
                        <button class="btn btn-info btn-sm pull-right">Ver Informe</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection