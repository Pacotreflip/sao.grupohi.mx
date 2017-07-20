@extends('sistema_contable.layout')
@section('title', 'Póliza General')
@section('contentheader_title', 'PREPÓLIZAS GENERADAS')
@section('contentheader_description', '(DETALLE)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.show', $poliza) !!}

    <div class="row">
        <div class="col-md-12">
            @if($poliza->estatus!=1)
            <a href="{{route('sistema_contable.poliza_generada.edit', $poliza)}}" class="btn btn-app btn-info pull-right">
                <i class="fa fa-edit"></i> Editar
            </a>
            @endif
            @if($poliza->estatus==0||$poliza->estatus==-2)
                <a  class="btn btn-app btn-info pull-right" onclick="validar_prepoliza({{$poliza->id_int_poliza}})">
                    <i class="fa fa-check-square-o"></i> Validar
                </a>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalle de Prepóliza</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th  class="bg-gray-light">Tipo Póliza SAO:<br><label>{{ $poliza->transaccionInterfaz}}</label></th>
                                <th class="bg-gray-light">Fecha de Solicitud:<br><label>{{ $poliza->created_at->format('Y-m-d h:i:s a')}}</label></th>
                                <th  class="bg-gray-light">Usuario Solicita:<br><label> {{$poliza->usuario_solicita }}</label></th>
                                <th class="bg-gray-light">Cuadre:<br><label>$ {{number_format($poliza->cuadre,'2','.',',')}}</label></th>
                            </tr>
                            <tr>
                                <th class="bg-gray-light">Estatus:<br>
                                    <label>
                                        <span class="label bg-{{$poliza->estatusPrepoliza->label}}">{{$poliza->estatusPrepoliza}}</span>
                                    </label>
                                </th>
                                <th class="bg-gray-light">
                                    Póliza Contpaq:
                                    <br><label>{{$poliza->poliza_contpaq}}</label>
                                </th>
                                <th class="bg-gray-light">
                                    Tipo de Póliza:
                                    <br><label> {{ $poliza->tipoPolizaContpaq}}</label>
                                </th>
                                <th class="bg-gray-light">
                                    Transacción Antecedente:
                                    <br><label>{{ $poliza->transacciones->tipoTransaccion}} - {{ $poliza->transacciones->numero_folio}}</label>
                                </th>
                            </tr>
                            <tr>

                                <th class="bg-gray-light" colspan="4">
                                    Concepto:
                                    <br><label> {{$poliza->concepto }}</label>
                                </th>
                            </tr>
                        </table>

                        @if(count($poliza->polizaMovimientos)>0)
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-gray-light">Cuenta Contable</th>
                                    <th class="bg-gray-light">Tipo Cuenta Contable</th>
                                    <th class="bg-gray-light">Debe</th>
                                    <th class="bg-gray-light">Haber</th>
                                    <th class="bg-gray-light">Referencia</th>
                                    <th class="bg-gray-light">Concepto</th>
                                </tr>
                                @foreach($poliza->polizaMovimientos as $movimiento)
                                    <tr>
                                        <td>{{$movimiento->cuenta_contable}}</td>
                                        <td>{{$movimiento->tipoCuentaContable ? $movimiento->tipoCuentaContable : 'No Registrada' }}</td>
                                        <td class="bg-gray-light numerico">{{$movimiento->id_tipo_movimiento_poliza == 1 ? '$' . number_format($movimiento->importe,'2','.',',') : '' }}</td>
                                        <td class="bg-gray-light numerico">{{$movimiento->id_tipo_movimiento_poliza == 2 ? '$' . number_format($movimiento->importe,'2','.',',') : '' }}</td>
                                        <td>{{$movimiento->referencia}}</td>
                                        <td>{{$movimiento->concepto}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="bg-gray {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}" style="text-align: right">
                                        <b>Sumas Iguales</b>
                                    </td>
                                    <td class="bg-gray numerico {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}">
                                        <b>$ {{number_format($poliza->sumaDebe,'2','.',',')}}</b>
                                    </td>
                                    <td class="bg-gray numerico {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}">
                                        <b>$ {{number_format($poliza->sumaHaber,'2','.',',')}}</b>
                                    </td>
                                    <td class="bg-gray {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}"></td>
                                    <td class="bg-gray {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}"></td>
                                </tr>
                            </table>
                            <div class="col-sm-12" style="text-align: right">
                                <h4><b>Total de la Prepóliza:</b>  $ {{number_format($poliza->total,'2','.',',')}}</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts-content')
    <script>
        function validar_prepoliza(id) {

            var url=App.host +"/sistema_contable/poliza_generada/" + id;
            swal({
                title: "¡Validar Prepóliza!",
                text: "¿Esta seguro de que deseas validar la Prepóliza?",
                confirmButtonText: "Si, Validar",
                cancelButtonText: "No, Cancelar",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                allowOutsideClick: false
            }).then(function (inputValue)
            { $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: "PATCH",
                    'poliza_generada':{
                        'estatus':1,
                        'lanzable':'True'

                    }

                },
                success: function (data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Prepóliza validada con éxito',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        location.reload();
                    });
                },
                complete: function () {

                }
            });
            }) .catch(swal.noop);

        }
    </script>
@endsection