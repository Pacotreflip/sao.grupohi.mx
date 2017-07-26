<div class="box-body no-padding">
    <div class="mailbox-read-info">
        <h3></h3>
        <h5>From: saoweb@grupohi.mx
            <span class="mailbox-read-time pull-right"></span>
        </h5>
    </div>

    <div class="mailbox-read-message">
        <p><b>Estimado Colaborador {{$usuario}}</b></p>
        <p>Se le informa que los siguientes Materiales no cuentan con cuenta contable asignada favor de verificarlas.</p>

    </div>
</div>
<div class="box-footer">
    <ul class="mailbox-attachments clearfix">
        <div class="table-responsive">



            @if($material_restante>0)
                <div class="col-md-4">

                    <div class="bg-gray" style="height:40px;text-align: center;color:black">
                        <label class="widget-user-username"><strong>MATERIALES</strong></label>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{$material_actual}}</h5>
                                    <span class="description-text">Configuradas</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">{{$material_restante}}</h5>
                                    <span class="description-text">Pendientes</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endif

            @if($mano_restante>0)
                <div class="col-md-4">

                    <div class="bg-gray" style="height:40px;text-align: center;color:black">
                        <label class="widget-user-username"><strong>MANO DE OBRA Y SERVICIOS</strong></label>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{$mano_actual}}</h5>
                                    <span class="description-text">Configuradas</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">{{$mano_restante}}</h5>
                                    <span class="description-text">Pendientes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif


            @if($herramienta_restante>0)
                <div class="col-md-4">
                    <div class="bg-gray" style="height:40px;text-align: center;color:black">
                        <label class="widget-user-username"><strong>HERRAMIENTA Y EQUIPO</strong></label>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{$herramienta_actual}}</h5>
                                    <span class="description-text">Configuradas</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">{{$herramienta_restante}}</h5>
                                    <span class="description-text">Pendientes</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

            @if($maquinaria_restante>0)
                <div class="col-md-4">
                    <div class="bg-gray" style="height:40px;text-align: center;color:black">
                        <label class="widget-user-username"><strong>MAQUINARIA</strong></label>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{$maquinaria_actual}}</h5>
                                    <span class="description-text">Configuradas</span>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">{{$maquinaria_restante}}</h5>
                                    <span class="description-text">Pendientes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
@endif





