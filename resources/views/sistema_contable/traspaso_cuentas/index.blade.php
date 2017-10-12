@extends('sistema_contable.layout')
@section('title', 'Traspaso entre cuentas')
@section('contentheader_title', 'TRASPASO ENTRE CUENTAS')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.traspaso_cuentas.index') !!}

    <global-errors></global-errors>
    <traspaso-cuentas-index
            :url_traspaso_cuentas_index="'{{ route('sistema_contable.traspaso_cuentas.index') }}'"
            inline-template
            v-cloak>
        <section>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Traspasar una cuenta</h3>
                        </div>
                        <div class="box-body">
                            <form  id="form_guardar_traspaso" @submit.prevent="validateForm('form_guardar_traspaso', 'update_cuenta')"  data-vv-scope="form_update_cuenta">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Cuenta origen</b></label>
                                            <Select class="form-control" name="cuenta_origen" id="cuenta_origen" v-model="form.cuenta_origen">
                                                @foreach($cuenta_origen as $origen)
                                                    <option value="{{$origen->id_cuenta}}">{{$origen->numero }} ({{$origen->abreviatura}}) ({{$origen->razon_social}})</option>
                                                @endforeach
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Cuenta destino</b></label>
                                            <Select class="form-control" name="cuenta_destino" id="cuenta_destino" v-model="form.cuenta_destino">
                                                @foreach($cuenta_destino as $destino)
                                                    <option value="{{$destino->id_cuenta}}">{{$destino->numero }} ({{$destino->abreviatura}}) ({{$destino->razon_social}})</option>
                                                @endforeach
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><b>Importe</b></label>
                                            <input type="text" class="form-control pull-right" id="importe" value="" name="importe" v-model="form.importe">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="comment">Observaciones</label>
                                            <textarea class="form-control" rows="10" id="observaciones" name="observaciones" v-model="form.observaciones"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button class="btn btn-sm btn-primary pull-right" type="submit">Traspasar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($traspasos)
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Traspasos</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped index_table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>campo</th>
                                        <th>otro campo</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($traspasos as $index => $item)
                                        <tr>
                                            <td>{{ $index+1}}</td>
                                            <td>{{$item->numero}}</td>
                                            <td>{{$item->cuenta_contable}}</td>
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
        </section>
    </traspaso-cuentas-index>

@endsection