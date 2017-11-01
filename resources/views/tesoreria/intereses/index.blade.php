@extends('tesoreria.layout')
@section('title', 'Intereses')
@section('contentheader_title', 'INTERESES')
@section('main-content')
    {!! Breadcrumbs::render('tesoreria.intereses.index') !!}

    <global-errors></global-errors>
    <intereses-index
            :url_intereses_index="'{{ route('tesoreria.intereses.index') }}'"
            inline-template
            v-cloak>
        <section>

        </section>
    </intereses-index>

@endsection