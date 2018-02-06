@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('control_presupuesto.cambio_presupuesto.index')}}"><i class='fa fa-circle-o'></i> <span>Cambios al Presupuesto</span></a></li>
            </ul>
        </li>
    </ul>
@endsection
