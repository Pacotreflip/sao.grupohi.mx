@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i>
                <span>Subcontratos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('reportes.subcontratos.estimacion')}}"><i class='fa  fa-circle-o'></i> <span>Orden de Pago Estimación</span></a></li>
            </ul>
        </li>
    </ul>
@endsection
