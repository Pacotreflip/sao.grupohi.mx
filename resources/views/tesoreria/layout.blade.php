@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        @permission(['consultar_traspaso_cuenta'])
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @permission('consultar_traspaso_cuenta')
                <li ><a href="{{route('tesoreria.traspaso_cuentas.index')}}"><i class='fa fa-circle-o'></i> <span>Traspaso Entre Cuentas</span></a></li>
                <li ><a href="{{route('tesoreria.movimientos_bancarios.index')}}"><i class='fa fa-circle-o'></i> <span>Movimientos Bancarios</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>
@endsection
