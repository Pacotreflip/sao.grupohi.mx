<!DOCTYPE html>

<html lang="es">
@section('htmlheader')
    @include('layouts.partials.htmlheader')
    @include('scripts.globals')
@show

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-green sidebar-mini sidebar-collapse">
<div id="app">

<div class="wrapper">

    @include('layouts.partials.mainheader')

    @include('layouts.partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        @include('layouts.partials.contentheader')
        <section class="content small" >
        <!-- Your Page Content Here -->
            @include('flash::message')

            @yield('main-content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    @include('layouts.partials.controlsidebar')

    @include('layouts.partials.footer')

</div><!-- ./wrapper -->

</div>

</body>
@section('scripts')
    @include('layouts.partials.scripts')
    <script>
        $.AdminLTE.options.sidebarExpandOnHover = true;
    </script>
    @yield('scripts-content')
@show
</html>
