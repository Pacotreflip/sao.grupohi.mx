@extends('layouts.app')
@section('notifications')
    <emails :user="{{ auth()->user()->toJson() }}" :emails="{{ auth()->user()->notificacionesNoLeidas()->get()->toJson() }}" :notificacion_url="'{{route('sistema_contable.notificacion.index')}}'" v-cloak inline-template>
        <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

            <i class="fa fa-envelope-o"></i>
                <span class="label label-success">@{{ data.emails.length }}</span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">Usted tiene <span class="label label-success">@{{ data.emails.length  }}</span> mensajes</li>
                <li>
                    <ul class="menu">
                        <li v-for="email in data.emails" v-if="data.emails.length > 0">
                            <a :href="notificacion_url + '/' + email.id">
                                <div class="pull-left">
                                    <i class="fa fa-envelope-o fa-2x"></i>
                                </div>
                                <h4>
                                    @{{ email.titulo }}
                                </h4>
                                <p>@{{ (new Date(email.created_at)).dateFormat() }}</p>
                            </a>
                        </li>
                        <li v-else>
                            <a>
                                <h4>
                                    Sin mensajes recientes.
                                </h4>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="footer"><a :href="notificacion_url">Ver todos</a></li>
            </ul>
        </li>
    </emails>
@endsection
@section('content-menu')
    <ul class="sidebar-menu">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i>
                <span>Catálogos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Cuentas Contables</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li ><a href="{{route('sistema_contable.cuenta_almacen.index')}}"><i class='fa  fa-circle-o'></i> <span>Cuentas - Almacenes</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_concepto.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Conceptos</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_empresa.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Empresas</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_contable.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Generales</span></a></li>
                        <li ><a href="{{route('sistema_contable.cuenta_material.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Materiales</span></a></li>
                        <li ><a href="{{route('sistema_contable.tipo_cuenta_contable.index')}}"><i class='fa fa-circle-o'></i> <span>Cuenta - Contable</span></a></li>
                    </ul>
                </li>
                <li ><a href="{{route('sistema_contable.poliza_tipo.index')}}"><i class='fa fa-book'></i> <span>Plantillas de Pre-Pólizas</span></a></li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('sistema_contable.datos_contables.edit', $currentObra->datosContables)}}"><i class='fa fa-circle-o'></i> <span>Configuración Contable</span></a></li>
                <li ><a href="{{route('sistema_contable.poliza_generada.index')}}"><i class='fa fa-circle-o'></i> <span>Pre-Pólizas Generadas</span></a></li>
            </ul>
        </li>

        <!--li class="treeview">
            <a href="#">
                <i class="fa fa-area-chart"></i>
                <span>Reportes</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li ><a href="{{route('sistema_contable.kardex_material.index')}}"><i class='fa fa-book'></i> <span>Kardex - Material</span></a></li>
            </ul>
        </li -->
    </ul>
@endsection
