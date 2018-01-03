@extends('layouts.app')
@section('content-menu')
    <ul class="sidebar-menu">
        {{--@permission(['consultar_traspaso_cuenta', 'consultar_movimiento_bancario'])--}}
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                {{--@permission(['consultar_movimiento_bancario'])--}}
                <li ><a href="{{route('control_presupuesto.presupuesto.index')}}"><i class='fa fa-circle-o'></i> <span>Control Presupuesto</span></a></li>
                {{--@endpermission--}}

                <li ><a href="{{route('control_presupuesto.cambio_presupuesto.index')}}"><i class='fa fa-circle-o'></i> <span>Ctrol cambios al Presupuesto</span></a></li>
            </ul>
        </li>
        {{--@endpermission--}}
    </ul>
@endsection
