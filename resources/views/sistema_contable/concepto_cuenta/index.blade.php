@extends('sistema_contable.layout')
@section('title', 'Relación Concepto Cuenta')
@section('contentheader_title', 'RELACIÓN CONCEPTO - CUENTA')
@section('contentheader_description', '(LISTA)')

@section('main-content')
    {!! Breadcrumbs::render('sistema_contable.concepto_cuenta.index') !!}
@endsection