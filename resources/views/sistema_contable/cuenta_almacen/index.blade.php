@extends('sistema_contable.layout')
@section('title', 'Cuentas Almacenes')
@section('contentheader_title', 'CUENTAS DE ALMACENES')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.tipo_cuenta_contable.index') !!}

    <div class="row" >
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Cuentas de Almacenes</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-12">
                        <div class="row table-responsive">
                            <table  class="table table-bordered table-striped small index_table" role="grid"
                                    aria-describedby="tipo_cuenta_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="tipo_cuenta" aria-sort="ascending">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Almacén</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Cuenta Contable</th>
                                        <th class="sorting" tabindex="0" aria-controls="tipo_cuenta">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($almacenes) > 0)
                                        @foreach($almacenes as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->descripcion  }}</td>
                                                @if($item->cuentasAlmacen)
                                                    <td>{{ $item->cuentasAlmacen->cuenta }}</td>
                                                @else
                                                    <td>Cuenta Sin Registrar</td>
                                                @endif
                                                <td style="min-width: 90px;max-width: 90px">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-info">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Almacén</th>
                                        <th>Cuenta Contable</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>


@endsection