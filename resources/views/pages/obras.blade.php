@extends('layouts.app')
@section('title', 'Obras')
@section('contentheader_title', 'OBRAS')

@section('main-content')
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
                        <button id="context_set" style="width: 100%;" class="btn btn-success"><i></i>&nbsp;&nbsp;&nbsp; IR &nbsp;&nbsp;&nbsp;</button>
                    </div>
                </div>
            <br><br>
        </div>
    </div>
</section>
    <div class="row">
        <div class="col-md-12">
            <ul class="list-group">
                @foreach($obras->groupBy('databaseName') as $baseDatos=>$obrasBd)
                    <li class="list-group-item disabled">
                        <i class="fa fa-fw fa-database"></i>{{$baseDatos}}
                    </li>
                    @foreach($obrasBd as $obra)
                        <a class="list-group-item" href="{{route('context.set',[$obra->databaseName, $obra])}}">
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
@endsection

@section('scripts-content')
    <script>
        $("#obras_select").select2({
            width:'100%',
            ajax: {
                url: '{{route('obra.search')}}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text:'[' + item.databaseName + '] ' + item.nombre,
                                id: item.id_obra,
                                url: App.host + '/context/' + item.databaseName + '/' + item.id_obra
                            }
                        })
                    };
                },
                error: function(error) {

                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1
        });
        $('#context_set').on('click', function() {
            if($('#obras_select option:selected').data())
            window.location = $('#obras_select option:selected').data().data.url;
        })
    </script>
@endsection