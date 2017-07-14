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
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Cuentas Contables</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li ><a href="{{route('sistema_contable.cuenta_almacen.index')}}"><i class='fa  fa-circle-o'></i> <span>Cuentas - Almacenes</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_concepto.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Conceptos</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_empresa.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Empresas</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_contable.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Generales</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_material.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Materiales</span></a></li>
                        <li ><a href="{{route('sistema_contable.tipo_cuenta_contable.index')}}"><i class='fa fa-circle-o'></i> <span>Cuenta - Contable</span></a></li>
                    </ul>
                </li>
                <li ><a href="{{route('sistema_contable.poliza_tipo.index')}}"><i class='fa fa-book'></i> <span>Plantillas de Pre-Pólizas</span></a></li>
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
                <li ><a href="{{route('sistema_contable.datos_contables.edit', $currentObra->datosContables)}}"><i class='fa fa-circle-o'></i> <span>Configuración Contable</span></a></li>
                <li ><a href="{{route('sistema_contable.poliza_generada.index')}}"><i class='fa fa-circle-o'></i> <span>Pre-Pólizas Generadas</span></a></li>
            </ul>
        </li>

        <!--li class="treeview">
            <a href="#">
                <i class="fa fa-area-chart"></i>
                <span>Reportes</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('sistema_contable.kardex_material.index')}}"><i class='fa fa-book'></i> <span>Kardex - Material</span></a></li>
            </ul>
        </li -->
    </ul>
@endsection
