@extends('sistema_contable.layout')
@section('title', 'Cuentas de Materiales')
@section('contentheader_title', 'CUENTAS DE MATERIALES')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.cuenta_material.index') !!}

    <div class="row">
        <div class="col-sm-12">
            <a  href="{{ route('sistema_contable.cuenta_material.create') }}" class="btn btn-success btn-app" style="float:right">
                <i class="glyphicon glyphicon-plus-sign"></i>Nueva
            </a>
        </div>
    </div>
    @if(true)
        <div class="row" >
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cuentas de Materiales</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-sm-12">
                            <div class="row table-responsive">
                                <table  class="table table-bordered table-striped dataTable index_table" role="grid"
                                        aria-describedby="tipo_cuenta_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Material</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Tipo de Cuenta</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Cuenta Contable</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- // Statement de llenado   -->
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Material</th>
                                        <th>Tipo de Cuenta</th>
                                        <th>Cuenta Contable</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <br/>
                    </div>
            </div>
        </div>
    @endif

@endsection