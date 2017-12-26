<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header text-center"><strong>{{ $currentObra ? $currentObra->nombre : '' }}</strong></li>
        </ul>
       @yield('content-menu')

    </section>
    <!-- /.sidebar -->
</aside>
