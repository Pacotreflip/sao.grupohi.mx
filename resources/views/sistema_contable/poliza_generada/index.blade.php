@extends('sistema_contable.layout')
@section('title', 'Póliza Generada')
@section('contentheader_title', 'PREPÓLIZAS GENERADAS')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.poliza_generada.index') !!}


    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Opciones de Búsqueda</h3>
                </div>
                <div class="box-body">
                    {!! Form::model(Request::only(['fechas', 'estatus']), ['method' => 'GET']) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Rango de Fechas</b></label>
                                {!! Form::text('fechas', null, ['class' => 'form-control rango_fechas']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Estatus</b></label>
                                <Select class="form-control" name="estatus" id="estatus">
                                    <option value="">Todas</option>index
                                    @foreach($est_prepolizas as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </Select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Tipo de Póliza</b></label>
                                <Select class="form-control" name="tipo" id="tipo">
                                    <option value="">Todas</option>
                                    @foreach($tipo_polizas as $tipo_poliza)
                                        <option value="{{$tipo_poliza->id_transaccion_interfaz}}" {{$tipo_poliza->id_transaccion_interfaz==$tipo?'selected':''}}>{{$tipo_poliza->descripcion}}</option>
                                    @endforeach
                                </Select>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button class="btn btn-sm btn-primary pull-right" type="submit">Buscar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@if($polizas)
    <div class="row" style="float:right">
        <div class="col-sm-12">
            <button class="btn btn-sm btn-primary pull-right" data-toggle="modal"  data-target="#add_movimiento_modal"data-dismiss="modal">Acumulado</button>
        </div>
    </div>
    <br>
    <br> <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Prepólizas Generadas</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped index_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Póliza</th>
                                <th>Tipo de Transaccion</th>
                                <th>Concepto</th>
                                <th>Fecha de Prepóliza</th>
                                <th>Total</th>
                                <th>Cuadre</th>
                                <th>Estatus</th>
                                <th>Póliza ContPaq</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($polizas as $index => $item)
                                <tr>
                                    <td>{{ $index+1}}</td>
                                    <td>{{ $item->transaccionInterfaz}}</td>
                                    <td>{{ $item->tipoPolizaContpaq}}</td>
                                    <td>{{ $item->concepto}}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td class="numerico">${{number_format($item->total,'2','.',',')}}</td>
                                    <td class="numerico">${{number_format($item->cuadre,'2','.',',')}}</td>
                                    <td>
                                        <span class="label bg-{{$item->estatusPrepoliza->label}}">{{$item->estatusPrepoliza}}</span>
                                    </td>
                                    <td>{{$item->poliza_contpaq}}</td>
                                    <td style="min-width: 90px;max-width: 90px">
                                        <a href="{{route('sistema_contable.poliza_generada.show',$item)}}" title="Ver"
                                           class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                        @permission('editar_prepolizas_generadas')
                                        <a href="{{route('sistema_contable.poliza_generada.edit',$item)}}"
                                           title="Editar" class="btn btn-xs btn-info  {{$item->estatus==1||$item->estatus==2 ? 'disabled' : '' }}"><i class="fa fa-pencil"></i></a>
                                        @endpermission
                                        <a href="{{route('sistema_contable.poliza_generada.historico',$item)}}"
                                           title="Histórico"
                                           class="btn btn-xs btn-success {{$item->historicos()->count() > 0 ? '' : 'disabled' }}"><i
                                                    class="fa fa-clock-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Modal Detalle de Cuentas -->
    <div id="add_movimiento_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCuentaModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"  aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">
                        <span >
                            Acumulados
                        </span>
                    </h4>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                              <table class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                      @foreach($est_prepolizas as $key=>$value)
                                          <th>{{$value}}</th>
                                      @endforeach
                                          <th>Total</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                      @foreach($acumulado as $catidad)
                                          <td class="text-right">
                                              {{number_format($catidad)}}
                                            </td>
                                      @endforeach
                                          <td class="text-right">
                                          {{number_format($total_polizas)}}
                                          </td>
                                  </tr>

                                  </tbody>

                              </table>
                            </div>

                        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Acumulados de Prepólizas</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="acumulado" width="762" height="500"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"  data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endif
@endsection

@section('scripts-content')
    <script>
        var chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };


        var dataAcumulado = {!! json_encode($acumulado_chart)!!};
        var fecha = new Date();
        var config_acumulado = {
            type: 'doughnut',
            data: dataAcumulado,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: fecha.getDate()+' / '+(fecha.getMonth() + 1)+' / '+fecha.getFullYear()
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        $(document).ready( function() {


            var acum = $("#acumulado")[0].getContext("2d");
            var doughnut = new Chart (acum, config_acumulado);

            $("#acumulado").click(
                function(evt){

                    var activePoints = doughnut.getElementAtEvent(evt);
                    if( activePoints[0]) {
                        var estatu = activePoints[0]._chart.config.data.estatus;
                        console.log(activePoints[0], estatu );
                        var url = App.host + '/sistema_contable/poliza_generada?estatus=' + estatu[activePoints[0]._index];
                        window.location = url;
                    }
                }
            );
        });

    </script>
@endsection