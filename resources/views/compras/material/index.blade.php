@extends('compras.layout')
@section('title', 'Materiales')
@section('contentheader_title', 'MATERIALES')
@section('contentheader_description', '(INDEX)')

@section('main-content')
    {!! Breadcrumbs::render('compras.material.index') !!}

@endsection