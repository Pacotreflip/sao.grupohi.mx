<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionPartidasRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
use Illuminate\Http\Request;

class SolicitudesReclasificacionController extends Controller
{
    use Helpers;


    /**
     * SolicitudesReclasificacionController constructor.
     * @param SolicitudReclasificacionRepository $solicitud
     * @param SolicitudReclasificacionPartidasRepository $partidas
     */
    public function __construct(SolicitudReclasificacionRepository $solicitud, SolicitudReclasificacionPartidasRepository $partidas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->solicitar = $solicitud;
        $this->part
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $r = $this->solicitar->with(['concepto', 'concepto_nuevo'])->all();


        $data_view = [
            'nuevo' => $this->concepto->obtenerMaxNumNiveles(),
            'antiguo' => $this->operadores,
        ];

        return view('control_costos.solicitar_reclasificacion.index')
            ->with('data_view', $data_view);
    }
}