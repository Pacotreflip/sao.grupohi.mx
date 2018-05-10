@extends('layouts.app')
@section('title', 'Obras')
@section('contentheader_title', 'OBRAS')

@section('main-content')
<obra-index
        :usuario="'{{auth()->user()->usuario}}'"
        :app_key="'{{config('app.key')}}'"
        :route_obra_search="'{{route("obra.search")}}'"
        inline-template
        v-cloak
>
    <section>

        <div class="row">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Buscar Obra</h3>
                </div>
               <div class="input-group">
                    <select class="form-control" id="obras_select">
                        <option value disabled="disabled">[--SELECCIONE--]</option>
                    </select>
                    <div class="input-group-btn">
                        <button id="context_set" style="width: 100%;" class="btn btn-success"><i></i>&nbsp;&nbsp;&nbsp;
                            IR &nbsp;&nbsp;&nbsp;
                        </button>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    @foreach($obras->groupBy('databaseName') as $baseDatos=>$obrasBd)
                        <li class="list-group-item disabled">
                            <i class="fa fa-fw fa-database"></i>{{$baseDatos}}
                        </li>
                        @foreach($obrasBd as $obra)
                            <a class="list_obra list-group-item" data-id_obra="{{$obra->id_obra}}" data-database_name="{{$obra->databaseName}}" href="#">
                                {{mb_strtoupper($obra->nombre)}}
                            </a>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="text-center">
            {!! $obras->render() !!}
        </div>
    </section>
</obra-index>
@endsection