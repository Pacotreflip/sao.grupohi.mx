@extends('sistema_contable.layout')
@section('title', 'Cuentas Contables Bancarias')
@section('contentheader_title', 'CUENTAS CONTABLES BANCARIAS')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuentas_contables_bancarias.index') !!}

    <div class="row">
    </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cuentas Contables Bancarias</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row table-responsive">
                                <table  class="table table-bordered table-striped dataTable index_table" role="grid"
                                        aria-describedby="tipo_cuenta_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Cuenta</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Número de Cuentas Configuradas</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataView['cuentas'] as $index => $c)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$c->numero }} ({{$c->abreviatura }} {{$c->empresa->razon_social}})</td>
                                            <td>{{$c->total_cuentas}}</td>
                                            <td>
                                                <a href="{{route('sistema_contable.cuentas_contables_bancarias.show',$c->id_cuenta)}}">
                                                    <button title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></button>
                                                </a>
                                                {{--@permission('editar_cuenta_contable_bancaria')--}}
                                                <a href="{{route('sistema_contable.cuentas_contables_bancarias.edit',$c->id_cuenta)}}">
                                                    <button  title="Editar" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                                                </a>
                                                {{--@endpermission--}}
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