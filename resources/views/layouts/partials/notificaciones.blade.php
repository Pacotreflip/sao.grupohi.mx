@if(Auth::user()->has('notificaciones'))
<!--li class="dropdown messages-menu">
    <a href="{{ route('notificacion') }}">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success">{{ Auth::user()->notificacionesNoLeidas()->count()  }}</span>
    </a>
</li-->
@endif