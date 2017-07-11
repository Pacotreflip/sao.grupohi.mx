<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\NotificacionRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;


class NotificacionController extends Controller
{
    /**
     * @var Cuenta
     */
    private $notificacion;

    public function __construct(NotificacionRepository $notificacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->notificacion = $notificacion;
    }

    public function index(){

        $notificaciones = $this->notificacion->with('obra')->all();
        return view('sistema_contable.notificaciones.index')
            ->with('notificaciones', $notificaciones);
    }
}
