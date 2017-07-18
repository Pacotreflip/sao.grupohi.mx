@if(Auth::user()->has('notificaciones'))
<li class="dropdown messages-menu">
    <a href="{{ route('notificacion') }}">
        <i class="fa fa-envelope-o"></i>
        @if(Auth::user())
        <span class="label label-success">{{ Auth::user()->notificacionesNoLeidas()->count()  }}</span>
            @endif
    </a>
</li>
@endif