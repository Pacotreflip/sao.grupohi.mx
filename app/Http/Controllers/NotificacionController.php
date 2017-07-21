<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionPolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionRepository;
use Ghi\Domain\Core\Models\Contabilidad\NotificacionPoliza;
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

    /**
     * @var NotificacionPolizaRepository
     */
    private $notificaion_poliza;


    public function __construct(NotificacionRepository $notificacion, PolizaRepository $poliza, NotificacionPolizaRepository $notificaion_poliza)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->notificacion = $notificacion;
        $this->poliza = $poliza;
        $this->notificaion_poliza = $notificaion_poliza;
    }

    public function index()
    {
        $notificaciones = $this->notificacion->with('usuario')->findBy('id_usuario', auth()->user()->idusuario);
        return view('sistema_contable.notificaciones.index')
            ->with('notificaciones', $notificaciones);
    }

    public function show($id)
    {
        $notificacion = $this->notificacion->with('notificaionesPoliza')->find($id);
        $notificacion = $this->notificacion->update(['leida' => true], $id);

        $polizas_errores = $this->notificaion_poliza->where([['estatus', '=', Poliza::CON_ERRORES], ['id_notificacion', '=', $id]]);
        $polizas_no_lanzadas = $this->notificaion_poliza->where([['estatus', '=', Poliza::NO_LANZADA], ['id_notificacion', '=', $id]]);
        $polizas_no_validadas = $this->notificaion_poliza->where([['estatus', '=', Poliza::NO_VALIDADA], ['id_notificacion', '=', $id]]);

        return view('sistema_contable.notificaciones.show')
            ->with('notificacion',$notificacion)
            ->with('polizas_errores', $polizas_errores)
            ->with('polizas_no_lanzadas', $polizas_no_lanzadas)
            ->with('polizas_no_validadas', $polizas_no_validadas);

    }

}
