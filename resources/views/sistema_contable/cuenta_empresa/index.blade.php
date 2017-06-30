@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTAS DE EMPRESAS')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_empresa.index') !!}

    <div class="row">

    </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cuentas de Empresas</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row table-responsive">
                                <table  class="table table-bordered table-striped dataTable index_table" role="grid"
                                        aria-describedby="tipo_cuenta_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Empresa</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Número de Cuentas Configuradas</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($empresas as $index=>$empresa)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$empresa->razon_social}}</td>
                                            <td>{{$empresa->total_cuentas}}</td>
                                            <td>
                                                <a href="{{route('sistema_contable.cuenta_empresa.show',$empresa)}}" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                                <a href="{{route('sistema_contable.cuenta_empresa.edit',$empresa)}}" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <th >#</th>
                                    <th>Empresa</th>
                                    <th>Número de Cuentas Configuradas</th>
                                    <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <br/>
                    </div>
            </div>
        </div>
@endsection