@extends('layouts.app')
@section('notifications')
    <emails :user="{{ auth()->user()->toJson() }}" :emails="{{ auth()->user()->notificacionesNoLeidas()->get()->toJson() }}" :id_obra="'{{$currentObra->id_obra}}'" :db="'{{\Ghi\Core\Facades\Context::getDatabaseName()}}'" :notificacion_url="'{{route('sistema_contable.notificacion.index')}}'" v-cloak inline-template>
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
        @permission(['consultar_cuenta_almacen', 'consultar_cuenta_concepto', 'consultar_cuenta_empresa', 'consultar_cuenta_fondo', 'consultar_cuenta_general', 'consultar_cuenta_material', 'consultar_cuenta_contable_bancaria', 'consultar_tipo_cuenta_contable', 'consultar_cuenta_costo', 'consultar_plantilla_prepoliza'])
        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i>
                <span>Catálogos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @permission(['consultar_cuenta_almacen', 'consultar_cuenta_concepto', 'consultar_cuenta_empresa', 'consultar_cuenta_fondo', 'consultar_cuenta_general', 'consultar_cuenta_material', 'consultar_cuenta_contable_bancaria', 'consultar_tipo_cuenta_contable', 'consultar_cuenta_costo'])
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-book"></i>
                        <span>Cuentas Contables</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                    @permission('consultar_cuenta_almacen')
                    <li ><a href="{{route('sistema_contable.cuenta_almacen.index')}}"><i class='fa  fa-circle-o'></i> <span>Cuentas - Almacenes</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_concepto')
                    <li ><a href="{{route('sistema_contable.cuenta_concepto.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Conceptos</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_empresa')
                    <li ><a href="{{route('sistema_contable.cuenta_empresa.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Empresas</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_fondo')
                    <li ><a href="{{route('sistema_contable.cuenta_fondo.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Fondos</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_general')
                    <li ><a href="{{route('sistema_contable.cuenta_contable.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Generales</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_material')
                    <li ><a href="{{route('sistema_contable.cuenta_material.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Materiales</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_contable_bancaria')
                    <li ><a href="{{route('sistema_contable.cuentas_contables_bancarias.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas - Cuentas Bancos</span></a></li>
                    @endpermission
                    @permission('consultar_tipo_cuenta_contable')
                    <li ><a href="{{route('sistema_contable.tipo_cuenta_contable.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas Generales</span></a></li>
                    @endpermission
                    @permission('consultar_cuenta_costo')
                    <li ><a href="{{route('sistema_contable.cuenta_costo.index')}}"><i class='fa fa-circle-o'></i> <span>Cuentas Costos</span></a></li>
                    @endpermission

                    </ul>
                </li>
                @endpermission
                @permission('consultar_plantilla_prepoliza')
                <li ><a href="{{route('sistema_contable.poliza_tipo.index')}}"><i class='fa fa-book'></i> <span>Plantillas de Prepólizas</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission(['editar_configuracion_contable', 'consultar_prepolizas_generadas', 'consultar_cierre_periodo'])
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Módulos</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @permission('editar_configuracion_contable')
                <li><a href="{{route('sistema_contable.datos_contables.edit', $currentObra->datosContables)}}"><i class='fa fa-circle-o'></i> <span>Configuración Contable</span></a></li>
                @endpermission
                @permission('consultar_prepolizas_generadas')
                <li><a href="{{route('sistema_contable.poliza_generada.index')}}"><i class='fa fa-circle-o'></i> <span>Prepólizas Generadas</span></a></li>
                @endpermission
                <li><a href="{{route('sistema_contable.revaluacion.index')}}"><i class='fa fa-circle-o'></i> <span>Revaluaciones</span></a></li>
                @permission('consultar_cierre_periodo')
                <li><a href="{{ route('sistema_contable.cierre.index') }}"><i class="fa fa-circle-o"></i><span>Cierre de Periodo</span></a></li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission('consultar_kardex_material')
        <li class="treeview">
            <a href="#">
                <i class="fa fa-area-chart"></i>
                <span>Reportes</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                @permission('consultar_kardex_material')
                <li ><a href="{{route('sistema_contable.kardex_material.index')}}"><i class='fa fa-book'></i> <span>Kardex - Material</span></a></li>
                @endpermission
            </ul>
            <ul class="treeview-menu">
                <!--@permission('consultar_kardex_material') -->
                <li ><a href="{{route('sistema_contable.costos_dolares.index')}}"><i class='fa fa-book'></i> <span>Costos Dolares</span></a></li>
                <!--@endpermission -->
            </ul>
        </li>
        @endpermission
    </ul>
@endsection
