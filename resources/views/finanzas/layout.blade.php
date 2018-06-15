@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">

        @permission(['consultar_comprobante_fondo_fijo', 'consultar_solicitud_pago']) {{-- Incluir todos los permisos que se van a requerir en el bloque posterior --}}
        <li class="treeview">
            <a href="#">
                <i class="fa fa-circle-o"></i>
                <span>Transacciones</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @permission('consultar_solicitud_pago')
                <li><a href="{{ route('finanzas.solicitud_pago.index') }}"><i class="fa fa-circle-o"></i> <span>Solicitud de Pago</span></a> </li>
                @endpermission
                @permission('consultar_comprobante_fondo_fijo')
                <li><a href="{{route('finanzas.comprobante_fondo_fijo.index')}}"><i class='fa  fa-circle-o'></i> <span>Comprobantes de Fondo Fijo</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>
@endsection
