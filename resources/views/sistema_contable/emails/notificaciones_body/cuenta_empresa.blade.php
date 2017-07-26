<div class="box-body no-padding">
    <div class="mailbox-read-info">
        <h3></h3>
        <h5>From: saoweb@grupohi.mx
            <span class="mailbox-read-time pull-right"></span>
        </h5>
    </div>

    <div class="mailbox-read-message">
        <p><b>Estimado Colaborador {{$usuario}}</b></p>
        <p>Se le informa que las siguientes Empresas no cuentan con cuenta contable asignada favor de verificarlas.</p>

    </div>
</div>
<div class="box-footer">
    <ul class="mailbox-attachments clearfix">
        <div class="table-responsive">

            @if(count($cuentas_empresa))
                <table class="table table-bordered small"  style="width: 100% !important;text-size-adjust: auto;">
                    <thead>
                    <tr>
                        <th  class="bg-gray" colspan="9" style="text-align: left">CUENTAS EMPRESAS</th>
                    </tr>
                    <tr>
                        <th class="bg-gray">No</th>
                        <th class="bg-gray">Empresa</th>
                        <th class="bg-gray">Estatus</th>
                        <th class="bg-gray">Editar</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cuentas_empresa as $index=>$cuenta_empresa)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$cuenta_empresa->razon_social}}</td>
                            <td>Sin configurar</td>
                            <td><a href="/sistema_contable/cuenta_empresa/{{$cuenta_empresa->id_empresa}}/edit"
                                   title="Editar" class="btn btn-xs btn-info " target="_blank"><i class="fa fa-pencil" ></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
@endif

        </div>
    </ul>
</div>


