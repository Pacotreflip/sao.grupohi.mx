@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'COMPROBANTES DE FONDO FIJO')
@section('breadcrumb')
   {!! Breadcrumbs::render('finanzas.comprobante_fondo_fijo.index') !!}
@endsection
@section('main-content')
    <comprobante-fondo-fijo-index
            v-cloak
            inline-template
            :editar_comprobante_fondo_fijo="{{ \Entrust::can(['editar_comprobante_fondo_fijo']) ? 'true' : 'false' }}"
            :eliminar_comprobante_fondo_fijo="{{ \Entrust::can(['eliminar_comprobante_fondo_fijo']) ? 'true' : 'false' }}"
        >
        <section>
            <div class="row">
                <div class="col-sm-12">
                    @permission('registrar_comprobante_fondo_fijo')
                    <a  href="{{ route('finanzas.comprobante_fondo_fijo.create') }}" class="btn btn-success btn-app" style="float:right">
                        <i class="glyphicon glyphicon-plus-sign"></i>Nuevo
                    </a>
                    @endpermission

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultados</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="row table-responsive">
                                    <table id="comprobantes_table" class="table table-bordered table-stripped">
                                        <thead>
                                        <tr role="row">
                                            <th># Folio</th>
                                            <th>Fondo Fijo</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                            <th>Referencia</th>
                                            <th>Fecha de Alta</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th># Folio</th>
                                            <th>Fondo Fijo</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                            <th>Referencia</th>
                                            <th>Fecha de Alta</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </comprobante-fondo-fijo-index>

@endsection
