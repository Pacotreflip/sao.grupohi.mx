<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-home"></i></a></li>
        @permission(['administrar_roles_permisos'])
        <li class=""><a href="#control-sidebar-settings-tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-gears"></i></a></li>
        @endpermission
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Sistemas</h3>
            <ul class="control-sidebar-menu">
                @if(auth()->user()->canAccessSystem('sistema_contable'))
                <li>
                    <a href="{{route('sistema_contable.index')}}">
                        <i class="menu-icon fa fa-usd fa-fw bg-aqua"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Contable</h4>

                            <p>Sistema para el Control Contable</p>
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->canAccessSystem('finanzas'))
                <li>
                    <a href="{{route('finanzas.index')}}">
                        <i class="menu-icon fa fa-area-chart bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Finanzas</h4>

                            <p>Sistema para el Control Financiero</p>
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->canAccessSystem('formatos'))
                <li>
                    <a href="{{route('formatos.index')}}">
                        <i class="menu-icon fa fa-file-text-o fa-fw bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Formatos</h4>

                            <p>Sistema de gestión de Formatos</p>
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->canAccessSystem('tesoreria'))
                <li>
                    <a href="{{route('tesoreria.index')}}">
                        <i class="menu-icon fa fa-money fa-fw bg-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Tesorería</h4>

                            <p>Sistema de Tesorería</p>
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->canAccessSystem('control_costos'))
                <li>
                    <a href="{{route('control_costos.index')}}">
                        <i class="menu-icon fa fa-lock fa-fw bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Control de Costos</h4>

                            <p>Sistema de Control de Costos</p>
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->canAccessSystem('control_presupuesto'))
                <li>
                    <a href="{{route('control_presupuesto.index')}}">
                        <i class="menu-icon fa fa-lock fa-fw bg-orange"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Control del Presupuesto</h4>

                            <p>Sistema de Control del Presupuesto</p>
                        </div>
                    </a>
                </li>
                @endif
            </ul>
            <!-- /.control-sidebar-menu -->

            <!--h3 class="control-sidebar-heading">Tasks Progress</--h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->
        </div>
        <!-- /.tab-pane -->

        <!-- Settings tab content -->
        @permission(['administrar_roles_permisos','administracion_configuracion_presupuesto','administracion_configuracion_obra'])
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h4 class="control-sidebar-heading">Configuración General</h4>

                <!-- Administración de Roles y Permisos -->
                @permission('administrar_roles_permisos')
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="{{ route('configuracion.seguridad.index') }}">Roles y Permisos</a>
                    </label>
                    <p>Administración de Roles y Permisos de usuarios para el uso de los Sistemas dentro de SAO</p>
                </div>
                @endpermission

                <!-- Administración del Presupuesto -->
                @permission('administracion_configuracion_presupuesto')
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="{{ route('configuracion.presupuesto.index') }}">Presupuesto</a>
                    </label>
                    <p>Configuración de la estructura del presupuesto</p>
                </div>
                @endpermission
                @permission('administracion_configuracion_obra')
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <a href="{{ route('configuracion.obra.index') }}">Obra</a>
                    </label>
                    <p>Configuración de información de la obra</p>
                </div>
                @endpermission
            </form>
        </div>
        @endpermission
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>