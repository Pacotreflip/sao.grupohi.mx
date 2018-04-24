@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        @permission(['consultar_asignacion','registrar_asignacion'])
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @permission('consultar_asignacion','registrar_asignacion')
                <li ><a href="{{route('procuracion.asignacion.index')}}"><i class='fa fa-circle-o'></i> <span>Asignación de Compradores</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>
@endsection
