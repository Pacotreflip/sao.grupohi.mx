@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-circle-o"></i>
                <span>Transacciones</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{route('finanzas.comprobante_fondo_fijo.index')}}"><i class='fa  fa-circle-o'></i> <span>Comprobantes de Fondo Fijo</span></a></li>

            </ul>
        </li>

    </ul>
@endsection
