
@if(Auth::user()->has('notificaciones'))
    <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">
             @if(Auth::user())
                    <span class="label label-success">{{ Auth::user()->notificacionesNoLeidas()->count()  }}</span>
                @endif</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">Usted tiene @if(Auth::user())
                    <span class="label label-success">{{ Auth::user()->notificacionesNoLeidas()->count()  }}</span>
                    @endif</span> mensajes
            </li>
            <li>
                <ul class="menu">
                    @if(count(Auth::user()->notificacionesNuevas)>0)
                        @foreach(Auth::user()->notificacionesNuevas as $notificacion)
                            <li>
                                <a href="{{route('notificacion.show',$notificacion->id)}}">
                                    <div class="pull-left fa-lg">
                                        <i class="fa fa-envelope text-yellow "></i>
                                    </div>
                                    <h4>
                                        {{$notificacion->titulo}}
                                        <small><i class="fa fa-clock-o"></i> {{$notificacion->created_at->format('Y-m-d')}}
                                        </small>
                                    </h4>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li>
                            <a>
                                <h4>
                                    Sin mensajes recientes.
                                </h4>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="footer"><a href="{{ route('notificacion') }}">Ver todos</a></li>
        </ul>
    </li>


@endif