<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{url("/")}}" class="logo">
        <span class="logo-mini">
            <figure class="nav-company">
                <img src="{{ asset('img/company-icon.png') }}"/>
            </figure>
        </span>
        <span class="logo-lg">
            <figure class="nav-company pull-left">
                <img src="{{ asset('img/company-icon.png') }}"/>
            </figure> SAO
        </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle Navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth::check())
                    @yield('notifications')
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <i class="fa fa-fw fa-user"></i>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">
                                {{ auth() ->user() }}
                                <i class="fa fa-fw fa-caret-down"></i>
                            </span>
                        </a>

                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <i class="fa fa-user fa-5x img-circle" style="color:white"></i>
                                <p>
                                    {{ auth()->user() }}
                                    <small>{{$currentObra ? $currentObra->nombre : ''}}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('obras') }}" class="btn btn-default btn-flat">Cambiar Obra</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('auth.getLogout')}}" class="btn btn-default btn-flat">Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($currentObra)
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
