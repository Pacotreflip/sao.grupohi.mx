@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
        <li ><a href="{{ url('/modulo_contable/poliza_tipo') }}"><i class='fa fa-book'></i> <span>Pólizas Tipo</span></a></li>
    </ul>
@endsection