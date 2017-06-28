@extends('sistema_contable.layout')
@section('title', 'Relación Concepto Cuenta')
@section('contentheader_title', 'RELACIÓN CONCEPTO - CUENTA')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.concepto_cuenta.index') !!}
    <hr>

    <div id="app">
        <concepto-cuenta-edit
                :conceptos="{{$conceptos}}"
                :url_concepto_get_by="'{{route('sistema_contable.concepto.getBy')}}'"
                v-cloak
                inline-template>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Datos Concepto de la Cuenta -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Relación Concepto - Cuenta</h3>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered small" v-treegrid id="concepto_tree">
                                        <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Cuenta</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr  v-for="(concepto,index) in conceptos_ordenados" :class="tr_class(concepto)" :id="tr_id(concepto)" >
                                                <td v-if="concepto.id_padre == null">
                                                    <img v-if="concepto.tiene_hijos > 0 && ! concepto.cargado" src="{{asset('build/img/expand.png')}}" @click="get_hijos(concepto)">
                                                    @{{ concepto.descripcion }}
                                                </td>
                                                <td v-else>
                                                    <img v-if="concepto.tiene_hijos > 0 && ! concepto.cargado" src="{{asset('build/img/expand.png')}}" @click="get_hijos(concepto)">
                                                    @{{ concepto.descripcion}}
                                                </td>
                                                <td>@{{ concepto.cuenta ? concepto.cuenta : 'NO ASIGNADA' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </concepto-cuenta-edit>
    </div>
@endsection