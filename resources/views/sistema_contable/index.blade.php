@extends('sistema_contable.layout')
@section('notifications')
    <div id="app">
        <emails :user="{{ auth()->user()->toJson() }}" v-cloak inline-template>
            <section>
                <li class="dropdown messages-menu">
                    <a href="{{ route('notificacion') }}">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">@{{ emails.length }}</span>
                    </a>
                </li>
            </section>
        </emails>
    </div>
@endsection
@section('title', 'Sistema Contable')
@section('contentheader_title', 'SISTEMA CONTABLE')
@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.index') !!}
@endsection
