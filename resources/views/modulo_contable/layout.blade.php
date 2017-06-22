@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-list"></i>
                <span>Catalogos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{ url('/modulo_contable/poliza_tipo') }}"><i class='fa fa-book'></i> <span>Plantillas de Póliza</span></a></li>


            </ul>
        </li>
        <li ><a href="{{route('modulo_contable.cuenta_contable.configuracion')}}"><i class='fa fa-bank'></i> <span>Cuentas contables</span></a></li>
        <li ><a href="{{ url('/modulo_contable/poliza_general') }}"><i class='fa fa-file-text-o'></i> <span>Pólizas Generales</span></a></li>
    </ul>
@endsection