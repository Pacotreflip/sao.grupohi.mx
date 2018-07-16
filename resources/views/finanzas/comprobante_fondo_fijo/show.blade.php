@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'COMPROBANTE DE FONDO FIJO')
@section('breadcrumb')
    {!! Breadcrumbs::render('finanzas.comprobante_fondo_fijo.show', $comprobante_fondo_fijo) !!}
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Información General</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Número de Folio:</strong>
                    <p>#&nbsp;{{$comprobante_fondo_fijo->numero_folio}}</p>
                    <hr>

                    @if($comprobante_fondo_fijo->reposicionFondoFijo)
                        <strong>Reposición de Fondo Fijo:</strong>
                        <p>#&nbsp;{{$comprobante_fondo_fijo->reposicionFondoFijo->numero_folio}}</p>
                        <hr>
                    @endif

                    <strong>Fecha:</strong>
                    <p>{{\Carbon\Carbon::parse($comprobante_fondo_fijo->fecha)->format('Y-m-d')}}</p>
                    <hr>

                    <strong>Fondo Fijo</strong>
                    <p>{{$comprobante_fondo_fijo->FondoFijo}}</p>
                    <hr>

                    <strong>Referencia</strong>
                    <p>{{$comprobante_fondo_fijo->referencia}}</p>
                    <hr>

                    <strong>Cumplimiento</strong>
                    <p>{{\Carbon\Carbon::parse($comprobante_fondo_fijo->cumplimiento)->format('Y-m-d')}}</p>
                    <hr>

                    <strong>Naturaleza</strong>
                    <p>{{$comprobante_fondo_fijo->DescripcionNaturaleza}}</p>
                    <hr>

                    <strong>Concepto</strong>
                    <p>{{$comprobante_fondo_fijo->concepto}}</p>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Partidas / Conceptos</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <!-- Partidas -->
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">Partida / Concepto</th>
                                <th style="text-align: center">Destino</th>
                                @if($comprobante_fondo_fijo->naturaleza == 1)
                                    <th style="text-align: center">Unidad</th>
                                @endif
                                <th style="text-align: center">Cantidad</th>
                                @if($comprobante_fondo_fijo->naturaleza == 1)
                                    <th style="text-align: center">Precio</th>
                                @endif
                                <th style="text-align: center">Monto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->id_material ? $item->material : $item->referencia }}</td>
                                    <td>{{$item->destino}}</td>
                                    @if($comprobante_fondo_fijo->Naturaleza == 1)
                                        <td>{{ $item->unidad ? $item->unidad : $item->material->unidad }}</td>
                                    @endif
                                    <td style="text-align: right">{{ $item->cantidad }}</td>
                                    @if($comprobante_fondo_fijo->Naturaleza == 1)
                                        <td style="text-align: right"><span class="pull-left">$</span>{{ number_format(($item->precio_unitario),'2','.',',') }}</td>
                                    @endif
                                    <td style="text-align: right"><span class="pull-left">$</span>{{ number_format(($item->Monto),'2','.',',') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <!-- Subtotales -->
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th style="text-align: right; width: 80%">Subtotal</th>
                                <td style="text-align: right">$&nbsp;{{ number_format(($comprobante_fondo_fijo->Subtotal),'2','.',',') }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">IVA</th>
                                <td style="text-align: right">$&nbsp;{{ number_format(($comprobante_fondo_fijo->impuesto),'2','.',',') }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Total</th>
                                <td style="text-align: right">$&nbsp;{{ number_format($comprobante_fondo_fijo->monto,'2','.',',') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Observaciones -->
                    @if($comprobante_fondo_fijo->observaciones)
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Observaciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $comprobante_fondo_fijo->observaciones }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                @if(! $comprobante_fondo_fijo->reposicionFondoFijo)
                    @permission('registrar_reposicion_fondo_fijo')
                    <div class="box-footer">
                        <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#reposicion_modal">
                            <i class="fa fa-check"></i> Generar Solicitud de Pago
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="reposicion_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Reposición de Fondo Fijo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <reposicion-fondo-fijo-create :id_antecedente="{{$comprobante_fondo_fijo->id_transaccion}}" v-cloak></reposicion-fondo-fijo-create>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endpermission
                @endif
            </div>
        </div>
    </div>
@endsection
