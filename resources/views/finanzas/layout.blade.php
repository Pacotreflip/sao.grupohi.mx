@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">

        @permission(['consultar_comprobante_fondo_fijo'])
        <li class="treeview">
            <a href="#">
                <i class="fa fa-circle-o"></i>
                <span>Transacciones</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @permission('consultar_comprobante_fondo_fijo')
                <li><a href="{{route('finanzas.comprobante_fondo_fijo.index')}}"><i class='fa  fa-circle-o'></i> <span>Comprobantes de Fondo Fijo</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>
@endsection
