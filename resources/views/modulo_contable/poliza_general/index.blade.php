@extends('modulo_contable.layout')
@section('title', 'Plantillas de Póliza')
@section('contentheader_title', 'PLANTILLAS DE PÓLIZA')
@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_tipo.create') !!}
    <hr>
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

                                        @foreach($polizas as $index => $item)
                                        <tr>

                                            <td>{{ $index+1}}</td>
                                            <td>{{ $item->tipoPolizaContpaq}}</td>
                                            <td>{{ $item->concepto}}</td>
                                            <td>{{ $item->total}}</td>
                                            <td>{{ $item->cuadre}}</td>
                                            <td>1</td>
                                            <td>No lanzado</td>
                                            <td style="min-width: 90px;max-width: 90px">

                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-xs btn-default"  data-toggle="modal" data-target="#modal-add-movimiento" >
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <button type="button" class="btn btn-xs btn-danger" >
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                </div>

                                            </td>

                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


@endsection
