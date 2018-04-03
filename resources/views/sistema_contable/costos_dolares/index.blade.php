@extends('sistema_contable.layout')
@section('title', 'Costos Moneda Extranjera')
@section('contentheader_title', 'COSTOS MONEDA EXTRANJERA')
@section('contentheader_description', '(INDEX)')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.costos_dolares.index') !!}

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Opciones de Búsqueda</h3>
                </div>
                <div class="box-body">
                    {!! Form::model(Request::only('fechas'), ['method' => 'GET']) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Rango de Fechas</b></label>

                                <input type="text" class="form-control pull-right" id="fechas"  name="fechas">
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
    @if(!empty($costos))
        <div class="row" >
            <div class="col-md-11">
                <button class="btn btn-sm btn-primary pull-right" type="button" id="pdf" onclick="pdf()">Reporte PDF</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-sm btn-primary pull-right" type="button" id="xls" onclick="xls()">Reporte Excel</button>
            </div>
        </div>
        <br>
        <br> <br>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Costos en Moneda Extranjera</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped index_table">
                                <thead>
                                <tr>
                                    <th>Id PrePóliza</th>
                                    <th>Folio Contpaq</th>
                                    <th>Fecha de Póliza</th>
                                    <th>Tipo de Cambio</th>
                                    <th>Cuenta Contable</th>
                                    <th>Descripción</th>
                                    <th>Importe Moneda Nacional</th>
                                    <th>Costo Moneda Extranjera</th>
                                    <th>Costo Moneda Extranjera Complementaria</th>
                                    <th>Póliza ContPaq</th>
                                    <th>Póliza SAO</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($costos as $index => $item)
                                    <tr>
                                        <td>{{ $item->id_poliza}}</td>
                                        <td>{{ $item->folio_contpaq }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->fecha_poliza)->format('d/m/Y')}}</td>
                                        <td>{{ $item->tipo_cambio}}</td>
                                        <td>{{ $item->cuenta_contable}}</td>
                                        <td>{{ $item->descripcion_concepto}}</td>
                                        <td class="numerico">$ {{ number_format($item->importe,'2','.',',')}}</td>
                                        <td class="numerico">$ {{ number_format($item->costo_me,'2','.',',')}}</td>
                                        <td class="numerico">$ {{ number_format($item->costo_me_complementaria,'2','.',',')}}</td>
                                        <td>{{ $item->tipo_poliza_contpaq.' No. '.$item->folio_contpaq}}</td>
                                        <td>{{ $item->tipo_poliza_sao.' No. '.$item->id_poliza}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="PDFModal" tabindex="-1" role="dialog" aria-labelledby="PDFModal">
        <div class="modal-dialog modal-lg" id="mdialTamanio">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                    <h4 class="modal-title">Costos Moneda Extranjera</h4>
                </div>
                <div class="modal-body modal-lg" style="height: 800px">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts-content')
    <script>
        $("#fechas").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: "Aceptar",
                cancelLabel: "Cancelar"
            }
        });

        function $_GET(q,s) {
            s = (s) ? s : window.location.search;
            var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
            return (s=s.replace(/^\?/,'&amp;').match(re)) ?s=s[1] :s='';
        }

        function pdf() {
            var url = App.host + '/sistema_contable/costos_dolares/' + $_GET('fechas') + '/reporte';
            $("#PDFModal .modal-body").html('<iframe src="'+url+'"  frameborder="0" height="100%" width="99.6%">d</iframe>');
            $("#PDFModal").modal("show");
        }

        function xls(){
            var url = App.host + '/sistema_contable/costos_dolares/' + $_GET('fechas') + '/reportexls';
            $("#PDFModal .modal-body").html('<iframe src="'+url+'"  frameborder="0" height="100%" width="99.6%">d</iframe>');
        }
    </script>
@endsection