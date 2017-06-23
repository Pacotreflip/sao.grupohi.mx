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
                <li ><a href="{{route('modulo_contable.poliza_tipo.index')}}"><i class='fa fa-book'></i> <span>Plantillas de Póliza</span></a></li>
                <li ><a href="{{route('modulo_contable.tipo_cuenta_contable.index')}}"><i class='fa fa-book'></i> <span>Tipo Cuenta Contable</span></a></li>


            </ul>
        </li>
        <li ><a href="{{route('modulo_contable.cuenta_contable.configuracion')}}"><i class='fa fa-bank'></i> <span>Cuentas contables</span></a></li>
        <li ><a href="{{route('modulo_contable.poliza_generada.index')}}"><i class='fa fa-file-text-o'></i> <span>Pólizas Generadas</span></a></li>
    </ul>
@endsection
