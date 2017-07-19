@extends('sistema_contable.layout')
@section('title', 'Póliza Generada')
@section('contentheader_title', 'PRE-PÓLIZAS GENERADAS')
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
                                {!! Form::select('estatus', array('' => 'Todas', '-2' => 'No lanzada', '-1' => 'Con Errores', '0' => 'No Validada', '1' => 'Validada','2'=>'Lanzada'), '', array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Tipo de Poliza</b></label>
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


    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Pre-Pólizas Generadas</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped small index_table" id="example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Póliza</th>
                                <th>Tipo de Transaccion</th>
                                <th>Concepto</th>
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
                                    <td class="numerico">$ {{number_format($item->total,'2','.',',')}}</td>
                                    <td class="numerico">$ {{number_format($item->cuadre,'2','.',',')}}</td>
                                    <td>
                                        <span class="label bg-{{$item->estatusPrepoliza->label}}">{{$item->estatusPrepoliza}}</span>
                                    </td>
                                    <td>{{$item->poliza_contpaq}}</td>
                                    <td style="min-width: 90px;max-width: 90px">
                                        <a href="{{route('sistema_contable.poliza_generada.show',$item)}}" title="Ver"
                                           class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                        <a href="{{route('sistema_contable.poliza_generada.edit',$item)}}"
                                           title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                                        <a href="{{route('sistema_contable.poliza_generada.historico',$item)}}"
                                           title="Histórico"
                                           class="btn btn-xs btn-success {{$item->historicos()->count() > 0 ? '' : 'disabled' }}"><i
                                                    class="fa fa-clock-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $polizas->appends(['fechas' => $fechas, 'estatus' => $estatus])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
    <script>
   $('#tipo').select2();

    </script>

@endsection
