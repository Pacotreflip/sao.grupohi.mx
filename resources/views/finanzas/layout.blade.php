@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">

        @permission(['consultar_comprobante_fondo_fijo', 'registrar_reposicion_fondo_fijo', 'registrar_pago_cuenta']) {{-- Incluir todos los permisos que se van a requerir en el bloque posterior --}}
        <li class="treeview">
            <a href="#">
                <i class="fa fa-circle-o"></i>
                <span>Transacciones</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @permission(['registrar_reposicion_fondo_fijo', 'registrar_pago_cuenta'])
                <li><a href="{{ route('finanzas.solicitud_cheque.create') }}"><i class="fa fa-circle-o"></i> <span>Solicitud de Cheque</span></a> </li>
                @endpermission
                @permission('consultar_comprobante_fondo_fijo')
                <li><a href="{{route('finanzas.comprobante_fondo_fijo.index')}}"><i class='fa  fa-circle-o'></i> <span>Comprobantes de Fondo Fijo</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>
@endsection
