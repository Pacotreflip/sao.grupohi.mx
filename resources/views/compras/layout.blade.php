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
                <li ><a href="{{route('compras.requisicion.index')}}"><i class='fa  fa-circle-o'></i> <span>Requisiciones</span></a></li>
                <li ><a href="{{route('compras.material.index')}}"><i class='fa  fa-circle-o'></i> <span>Materiales</span></a></li>

            </ul>
        </li>
    </ul>
@endsection
