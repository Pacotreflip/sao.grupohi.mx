@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i>
                <span>Catálogos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('sistema_contable.cuenta_almacen.index')}}"><i class='fa fa-book'></i> <span>Cuentas - Almacenes</span></a></li>
                <li ><a href="{{route('sistema_contable.cuenta_concepto.index')}}"><i class='fa fa-book'></i> <span>Cuentas - Conceptos</span></a></li>
                <li ><a href="{{route('sistema_contable.cuenta_empresa.index')}}"><i class='fa fa-book'></i> <span>Cuentas - Empresas</span></a></li>
                <li ><a href="{{route('sistema_contable.poliza_tipo.index')}}"><i class='fa fa-book'></i> <span>Plantillas de Póliza</span></a></li>
                <li ><a href="{{route('sistema_contable.tipo_cuenta_contable.index')}}"><i class='fa fa-book'></i> <span>Tipos de Cuentas Contables</span></a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('sistema_contable.cuenta_contable.configuracion')}}"><i class='fa fa-bank'></i> <span>Configuración Contable</span></a></li>
                <li ><a href="{{route('sistema_contable.poliza_generada.index')}}"><i class='fa fa-file-text-o'></i> <span>Pólizas Generadas</span></a></li>
            </ul>
        </li>
    </ul>
@endsection
