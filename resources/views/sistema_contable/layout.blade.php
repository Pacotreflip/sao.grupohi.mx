@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li ><a href="{{route('sistema_contable.cuenta_contable.configuracion')}}"><i class='fa fa-bank'></i> <span>Configuración Contable</span></a></li>
        <li ><a href="{{route('sistema_contable.poliza_generada.index')}}"><i class='fa fa-file-text-o'></i> <span>Pólizas Generadas</span></a></li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-list"></i>
                <span>Catalogos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('sistema_contable.poliza_tipo.index')}}"><i class='fa fa-book'></i> <span>Plantillas de Póliza</span></a></li>
                <li ><a href="{{route('sistema_contable.tipo_cuenta_contable.index')}}"><i class='fa fa-book'></i> <span>Tipo Cuenta Contable</span></a></li>
                <li ><a href="{{route('sistema_contable.cuenta_material.index')}}"><i class='fa fa-book'></i> <span>Cuentas Materiales</span></a></li>

            </ul>
        </li>
    </ul>
@endsection
