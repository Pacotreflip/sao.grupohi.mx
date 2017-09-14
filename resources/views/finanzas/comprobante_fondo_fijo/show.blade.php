@extends('finanzas.layout')
@section('title', 'Sistema de Finanzas')
@section('contentheader_title', 'COMPROBANTE DE FONDO FIJO')
@section('contentheader_description', '(DETALLE)')
@section('main-content')
    {!! Breadcrumbs::render('finanzas.comprobante_fondo_fijo.show', $comprobante_fondo_fijo) !!}



    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información del Comprobante</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong>Fecha:</strong>
                    <p class="text-muted">{{$comprobante_fondo_fijo->fecha}}</p>
                    <hr>

                    <strong>Fondo Fijo</strong>
                    <p class="text-muted">{{$comprobante_fondo_fijo->FondoFijo}}</p>
                    <hr>

                    <strong>Referencia</strong>
                    <p>{{$comprobante_fondo_fijo->referencia}}</p>
                    <hr>

                    <strong>Cumplimiento</strong>
                    <p>{{$comprobante_fondo_fijo->cumplimiento}}</p>
                    <hr>

                    <strong>Naturaleza</strong>
                    <p>{{$comprobante_fondo_fijo->DescripcionNaturaleza}}</p>
                    <hr>

                    <strong>Concepto</strong>
                    <p>{{$comprobante_fondo_fijo->concepto}}</p>
                    <hr>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

            <div class="col-md-9">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Items</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ">
                                    <thead>
                                    <tr>
                                        <th class="bg-gray-light">#</th>
                                        <th class="bg-gray-light">Item</th>
                                        <th class="bg-gray-light">Unidad</th>
                                        <th class="bg-gray-light">Cantidad</th>
                                        <th class="bg-gray-light">Precio</th>
                                        <th class="bg-gray-light">Monto</th>
                                        <th class="bg-gray-light">Destino</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $index=>$item)
                                        <tr>
                                            <td style="white-space: nowrap">{{$index+1}}</td>

                                            <td style="white-space: nowrap" class="form-group">
                                                @if($item->id_material)
                                                    {{$item->material}}
                                                @else
                                                    {{$item->referencia}}
                                                @endif
                                            </td>
                                            <td style="white-space: nowrap">
                                                {{$item->unidad}}
                                            </td>
                                            <td class="form-group">
                                                {{$item->cantidad}}
                                            </td>

                                            <td class="form-group">
                                                {{$item->precio_unitario}}
                                            </td>
                                            <td style="white-space: nowrap" class="numerico">
                                                $ {{$item->precio_unitario*$item->cantidad}}
                                            </td>
                                            <td class="form-group">
                                                {{$item->concepto}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td class="bg-gray-light" colspan="7" rowspan="3">
                                            <strong>Observaciónes:</strong>
                                            <br><label>{{$comprobante_fondo_fijo->observaciones}}</label>

                                        </td>
                                        <td class="bg-gray-light"><strong>Subtotal</strong></td>
                                        <td class="bg-gray-light text-right" style="width: 200px"><strong>${{number_format(($comprobante_fondo_fijo->Subtotal),'2','.',',')}}</strong></td>
                                    </tr>
                                    <tr>

                                        <td class="bg-gray-light">
                                            <strong>IVA</strong>
                                        </td>
                                        <th class="bg-gray-light text-right"><strong>  {{$comprobante_fondo_fijo->impuesto}}
                                                %</strong></th>
                                    </tr>
                                    <tr>

                                        <td class="bg-gray-light">
                                            <strong>Total</strong>
                                        </td>
                                        <th class="bg-gray-light text-right">
                                            <strong>${{number_format($comprobante_fondo_fijo->monto,'2','.',',')}}</strong></th>
                                    </tr>

                                    </thead>

                                </table>

                        </div>
                    </div>
                </div>
            </div>

    </div>
@endsection

