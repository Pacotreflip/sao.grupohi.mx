<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <span class="logo">
        <figure class="nav-company pull-left">
            <img src="{{ asset('img/company-icon.png') }}"/>
        </figure>
        {{ trans('strings.app-name') }}
    </span>

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
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <i class="fa fa-fw fa-user"></i>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ auth()->user() }}</span>
                            <i class="fa fa-fw fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                           <li class="user-footer">
                               <a href="/obras"><i class="fa fa-fw fa-database"></i> Obras</a>
                           </li>
                            <li class="user-footer">
                                <a href="auth/logout"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
