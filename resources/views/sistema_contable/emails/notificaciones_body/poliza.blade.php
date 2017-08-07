<div class="box-body no-padding">
    <div class="mailbox-read-info">
        <h3></h3>
        <h5>From: saoweb@grupohi.mx
            <span class="mailbox-read-time pull-right"></span>
        </h5>
    </div>

    <div class="mailbox-read-message">
        <p><b>Estimado Colaborador {{$usuario}}</b></p>
        <p>Se le informa que las siguientes prepólizas requieren de revisión para poder ser emitidas
            correctamente.</p>

    </div>
</div>
<div class="box-footer">
    <ul class="mailbox-attachments clearfix">
        <div class="table-responsive">

            <table class="table table-bordered table-striped"
                   style="width: 100% !important;text-size-adjust: auto;">

                @if(count($polizas_errores)>0)
                    <thead>
                    <tr>
                        <th colspan="9" class="bg-gray">PREPÓLIZAS CON ERRORES</th>
                    </tr>
                    </thead>
                    <tr>
                        <th class="bg-gray">No.</th>
                        <th class="bg-gray">Tipo de Póliza</th>
                        <th class="bg-gray">Concepto</th>
                        <th class="bg-gray">Total</th>
                        <th class="bg-gray">Cuadre</th>
                        <th class="bg-gray">Estatus</th>
                        <th class="bg-gray">Póliza ContPaq</th>
                        <th class="bg-gray">Editar</th>
                    </tr>
                    @foreach($polizas_errores as $index=>$poliza)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$poliza['tipo_poliza']}}</td>
                            <td>{{$poliza['concepto']}}</td>
                            <td style="text-align: right;width: 100px">$ {{$poliza['total']}}</td>
                            <td style="text-align: right;width: 100px">$ {{$poliza['cuadre']}}</td>
                            <td>  <span class="label bg-red">Con errores</span></td>
                            <td>{{$poliza['poliza_contpaq']}}</td>
                            <td><a href="/sistema_contable/poliza_generada/{{$poliza['id_int_poliza']}}/edit"
                                   title="Editar" class="btn btn-xs btn-info "><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                @if(count($polizas_no_lanzadas)>0)
                    <tr>
                        <th colspan="9" bgcolor="white"></th>
                    </tr>
                    <tr>
                        <th colspan="9" class="bg-gray">PREPÓLIZAS NO LANZADAS</th>
                    </tr>

                    <tr>
                        <th class="bg-gray">No.</th>
                        <th class="bg-gray">Tipo de Póliza</th>
                        <th class="bg-gray">Concepto</th>
                        <th class="bg-gray">Total</th>
                        <th class="bg-gray">Cuadre</th>
                        <th class="bg-gray">Estatus</th>
                        <th class="bg-gray">Póliza ContPaq</th>
                        <th class="bg-gray">Editar</th>

                    </tr>
                    @foreach($polizas_no_lanzadas as $index=>$poliza)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$poliza['tipo_poliza']}}</td>
                            <td>{{$poliza['concepto']}}</td>
                            <td style="text-align: right;width: 100px">$ {{$poliza['total']}}</td>
                            <td style="text-align: right;width: 100px">$ {{$poliza['cuadre']}}</td>
                            <td>  <span class="label bg-red">No lanzada</span></td>
                            <td>{{$poliza['poliza_contpaq']}}</td>
                            <td><a href="/sistema_contable/poliza_generada/{{$poliza['id_int_poliza']}}/edit"
                                   title="Editar" class="btn btn-xs btn-info "><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                @if(count($polizas_no_validadas)>0)

                    <tr>
                        <th colspan="9" bgcolor="white"></th>
                    </tr>
                    <tr>
                        <th colspan="9" class="bg-gray">PREPÓLIZAS NO VALIDADAS</th>
                    </tr>

                    <tr>
                        <th class="bg-gray">No.</th>
                        <th class="bg-gray">Tipo de Póliza</th>
                        <th class="bg-gray">Concepto</th>
                        <th class="bg-gray">Total</th>
                        <th class="bg-gray">Cuadre</th>
                        <th class="bg-gray">Estatus</th>
                        <th class="bg-gray">Póliza ContPaq</th>
                        <th class="bg-gray">Editar</th>

                    </tr>

                    @foreach($polizas_no_validadas as $index=>$poliza)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$poliza['tipo_poliza']}}</td>
                            <td>{{$poliza['concepto']}}</td>
                            <td style="text-align: right;width: 100px">$ {{$poliza['total']}}</td>
                            <td style="text-align: right;width: 100px">$ {{$poliza['cuadre']}}</td>
                            <td>  <span class="label bg-yellow">No validada</span></td>
                            <td>{{$poliza['poliza_contpaq']}}</td>
                            <td><a href="/sistema_contable/poliza_generada/{{$poliza['id_int_poliza']}}/edit"
                                   title="Editar" class="btn btn-xs btn-info " target="_blank"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            </table>
        </div>
    </ul>
</div>
