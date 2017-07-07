@extends('sistema_contable.layout')
@section('title', 'Cuentas de Empresas')
@section('contentheader_title', 'CUENTAS DE EMPRESAS')
@section('contentheader_description', '(INDEX)')

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
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($empresas as $index=>$empresa)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$empresa->razon_social}}</td>
                                            <td>{{$empresa->total_cuentas}}</td>
                                            <td>
                                                <a href="{{route('sistema_contable.cuenta_empresa.show',$empresa)}}">
                                                    <button title="Ver" class="btn-xs btn-default"><i class="fa fa-eye"></i></button>
                                                </a>
                                                <a href="{{route('sistema_contable.cuenta_empresa.edit',$empresa)}}">
                                                    <button  title="Editar" class="btn-xs btn-info"><i class="fa fa-edit"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <th >#</th>
                                    <th>Empresa</th>
                                    <th>Número de Cuentas Configuradas</th>
                                    <th>Acciones</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <br/>
                    </div>
            </div>
        </div>
@endsection