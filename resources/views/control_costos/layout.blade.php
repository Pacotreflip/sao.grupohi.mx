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
                <li ><a href="{{route('control_costos.solicitar_reclasificacion.index')}}"><i class='fa fa-circle-o'></i> <span>Solicitar Reclasificación</span></a></li>
                {{--@endpermission--}}
                {{--@permission('consultar_traspaso_cuenta')--}}
                <li ><a href="{{route('control_costos.reclasificacion_costos.index')}}"><i class='fa fa-circle-o'></i> <span>Reclasificación De Costos</span></a></li>
                {{--@endpermission--}}
            </ul>
        </li>
        {{--@endpermission--}}
    </ul>
@endsection
