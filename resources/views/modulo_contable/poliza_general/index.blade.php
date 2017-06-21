@extends('modulo_contable.layout')
@section('title', 'Cuentas Contables')
@section('contentheader_title', 'PÓLIZAS GENERALES')


@section('main-content')
    {!! Breadcrumbs::render('modulo_contable.poliza_general.index') !!}
    <hr>
    <div id="app">
        <global-errors></global-errors>
        <cuenta-contable

                inline-template>
            <section>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Pólizas Generales</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped small">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo de Póliza</th>
                                            <th>Concepto</th>
                                            <th>Total</th>
                                            <th>Cuadre</th>
                                            <th>Estatus</th>
                                            <th>Poliza ContPaq</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in data.cuentas_contables">


                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        </cuenta-contable>
    </div>
@endsection