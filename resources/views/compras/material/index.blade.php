@extends('compras.layout')
@section('title', 'Materiales')
@section('contentheader_title', 'MATERIALES')
@section('breadcrumb')
    {!! Breadcrumbs::render('compras.material.index') !!}
@endsection
@section('main-content')
        <material-index></material-index>
@endsection