@extends('control_presupuesto.layout')
@section('title', 'Control Presupuesto')
@section('contentheader_title', 'CONTROL PRESUPUESTO')
@section('breadcrumb')
    {!! Breadcrumbs::render('control_presupuesto.index') !!}
@endsection
@section('main-content')
    {{ dd(\Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden::find(4)->monto_autorizado) }}
    <control-presupuesto-index v-cloak inline-template>
        <section>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resúmen de Cambios</h3>
                        </div>
                        <div class="box-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="#">Escalatorias
                                        <span class="pull-right text-red"><i class="fa fa-angle-down"></i> $12,000.86</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">Variaciones de Volúmen
                                        <span class="pull-right text-green"><i class="fa fa-angle-up"></i> $123,233.21</span>
                                    </a>
                                </li>
                                <li><a href="#">Cambios de Insumos
                                        <span class="pull-right text-red"><i class="fa fa-angle-down"></i> $1,000,000.00</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </control-presupuesto-index>
@endsection

