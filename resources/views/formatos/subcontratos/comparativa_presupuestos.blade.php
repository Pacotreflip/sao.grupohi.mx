@extends('formatos.layout')
@section('title', 'Formatos')
@section('contentheader_title', 'COMPARATIVA DE PRESUPUESTOS')
@section('breadcrumb')
    {!! Breadcrumbs::render('formatos.subcontratos.comparativa_presupuestos') !!}
@endsection
@section('main-content')
    <subcontratos-comparativa-presupuestos inline-template v-cloak>
        <section>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                        </div>
                        <div class="box-body">
                            <div id="remote">
                                <input class="form-control input-sm typeahead" type="text" placeholder="Oscar winners for Best Picture">
                            </div>
                        </div>
                        <div class="box-footer">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </subcontratos-comparativa-presupuestos>
@endsection