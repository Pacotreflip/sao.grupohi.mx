@extends('layouts.app')
@section('title', 'Obras')
@section('contentheader_title', 'OBRAS')

@section('main-content')
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
    <div class="text-center">
        {!! $obras->render() !!}
    </div>
@endsection

@section('scripts-content')
    <script>
        $('.select2').select2();
    </script>
@endsection