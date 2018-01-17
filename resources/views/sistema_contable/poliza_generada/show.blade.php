@extends('sistema_contable.layout')
@section('title', 'Póliza General')
@section('contentheader_title', 'PREPÓLIZAS GENERADAS')
@section('breadcrumb')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.show', $poliza) !!}
@endsection
@section('main-content')

    <div class="row">
        <div class="col-md-12">
            @permission('editar_prepolizas_generadas')
            @if($poliza->estatus== -2  || $poliza->estatus == -1 || $poliza->estatus == 0)
            <a href="{{route('sistema_contable.poliza_generada.edit', $poliza)}}" class="btn btn-app btn-info pull-right">
                <i class="fa fa-edit"></i> Editar
            </a>
            @endif
            @if($poliza->estatus== -2 || $poliza->estatus== 0)
            <a  class="btn btn-app btn-info pull-right" onclick="validar_prepoliza({{$poliza->id_int_poliza}})">
                <i class="fa fa-check-square-o"></i> Validar
            </a>
            @endif
            @if($poliza->estatus == 0 || $poliza->estatus== -2 || $poliza->estatus == -1)
            <a  class="btn btn-app btn-info pull-right" onclick="omitir_prepoliza({{$poliza->id_int_poliza}})">
                <i class="glyphicon glyphicon-thumbs-down"></i> Omitir
            </a>
            @endif
            @if($poliza->estatus == -1 || $poliza->estatus == 0)
            <a  class="btn btn-app btn-info pull-right" data-toggle="modal" data-target="#folioContpaqModal">
                <i class="fa fa-i-cursor"></i> Ingrear Folio Contpaq
            </a>
            @endif
            @endpermission
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
                                <th class="bg-gray-light">Fecha de Prepóliza:<br><label>{{ $poliza->fecha}}</label></th>
                                <th  class="bg-gray-light">Usuario Solicita:<br><label> {{$poliza->usuario_solicita }}</label></th>
                                <th class="bg-gray-light">Cuadre:<br><label>$ {{number_format($poliza->cuadre,'2','.',',')}}</label></th>
                            </tr>
                            <tr>
                                <th class="bg-gray-light">Estatus:<br>
                                    <label>
                                        <span class="label" style="background-color: {{$poliza->estatusPrepoliza->label}}">{{$poliza->estatusPrepoliza}}</span>
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
                                    @if($poliza->transacciones)
                                    <br><label>{{ $poliza->transacciones->tipoTransaccion}} - {{ $poliza->transacciones->numero_folio}}</label>
                                    @elseif($poliza->traspaso)
                                    <br><label>Traspaso - {{ $poliza->traspaso->numero_folio}}</label>
                                    @endif
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
                                        <b>${{number_format($poliza->sumaDebe,'2','.',',')}}</b>
                                    </td>
                                    <td class="bg-gray numerico {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}">
                                        <b>${{number_format($poliza->sumaHaber,'2','.',',')}}</b>
                                    </td>
                                    <td class="bg-gray {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}"></td>
                                    <td class="bg-gray {{$poliza->cuadrado != 1 ? 'bg-red' : ''}}"></td>
                                </tr>
                            </table>
                            <div class="col-sm-12" style="text-align: right">
                                <h4><b>Total de la Prepóliza:</b>  ${{number_format($poliza->total,'2','.',',')}}</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Folio Contpaq-->
    <div class="modal fade" id="folioContpaqModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Ingresar Folio Contpaq</h4>
                </div>
                <form id="folio_contpaq_form" action="{{route('sistema_contable.poliza_generada.ingresar_folio', $poliza)}}">
                    <input type="hidden" name="estatus" value="3">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="folio_contpaq"><strong>Número de Folio</strong></label>
                                <input type="number" id="folio_contpaq" name="poliza_contpaq" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha"><strong>Fecha de Prepóliza</strong></label>
                                <input type="text" id="fecha" class="fecha form-control" name="fecha" data-date-end-date="0d" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts-content')
    <script>
        function validar_prepoliza(id) {

            var url=App.host +"/sistema_contable/poliza_generada/" + id;
            swal({
                title: "Validar Prepóliza",
                text: "¿Esta seguro de que deseas validar la Prepóliza?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: "PATCH",
                            'poliza_generada': {
                                'estatus': 1,
                                'lanzable': 'True'
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
                        }
                    });
                }
            });
        }

        function omitir_prepoliza(id) {
            var url=App.host +"/sistema_contable/poliza_generada/" + id;
            swal({
                title: "Omitir Prepóliza",
                text: "¿Esta seguro de que deseas Omitir la Prepóliza?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: "PATCH",
                            'poliza_generada':{
                                'estatus':-3,
                                'lanzable':'True'
                            }
                        },
                        success: function (data, textStatus, xhr) {
                            swal({
                                type: "success",
                                title: '¡Correcto!',
                                text: 'Prepóliza Omitida con éxito',
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        $('#folio_contpaq_form').on('submit', function(e) {
            e.preventDefault();

            var url = $('#folio_contpaq_form').attr('action');

            swal({
                title: "Guardar Plantilla",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar",
            }).then(function (result) {
                if(result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _method: 'PATCH',
                            fecha: $('#fecha').val(),
                            poliza_contpaq: $('#folio_contpaq').val()
                        },
                        success: function (data, textStatus, xhr) {
                            swal({
                                type: "success",
                                title: '¡Correcto!',
                                text: 'Folio Contpaq ingresado correctamente',
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }).then(function () {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection