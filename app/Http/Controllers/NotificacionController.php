<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\NotificacionRepository;
use Ghi\Domain\Core\Models\Contabilidad\Poliza;
use Illuminate\Http\Request;

use Ghi\Http\Requests;


class NotificacionController extends Controller
{
    /**
     * @var Notificacion
     */
    private $notificacion;

    /**
     * @var Poliza
     */
    private $poliza;

    public function __construct(NotificacionRepository $notificacion, PolizaRepository $poliza)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->notificacion = $notificacion;
        $this->poliza = $poliza;
    }

    public function index()
    {
        $notificaciones = $this->notificacion->with('obra')->all();
        return view('sistema_contable.notificaciones.index')
            ->with('notificaciones', $notificaciones);
    }

    public function show($id)
    {
        $notificacion = $this->notificacion->find($id);
        $integerIDs = array_map('intval', explode(',', $notificacion->idPolizas.'0'));
        $polizas = $this->poliza->findWhereIn($integerIDs);

        return view('sistema_contable.notificaciones.show')
            ->with('polizas', $polizas)
            ->with('notificacion', $notificacion);

    }
    public function notificaciones(){
        $notificaciones = $this->notificacion->with('obra')->all()->count();
        dd($notificaciones);
    }
}