@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li ><a href="{{ url('/modulo_contable/poliza_tipo') }}"><i class='fa fa-book'></i> <span>Plantillas de Póliza</span></a></li>
        <li ><a href="{{ url('/modulo_contable/tipo_cuenta_contable') }}"><i class='fa fa-book'></i> <span>Tipo Cuenta Contable</span></a></li>
    </ul>
@endsection