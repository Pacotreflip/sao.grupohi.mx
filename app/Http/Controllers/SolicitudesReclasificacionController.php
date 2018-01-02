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
        $this->partidas = $partidas;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
//        $solicitudes = $this->solicitar->with(['partidas'])->all();
        $partidas = [];



        return view('control_costos.solicitudes_reclasificacion.index');
    }

    public function paginate() {
        $items = $this->solicitar->paginate();

        return response()->json([
            'recordsTotal' => $items->total(),
            'recordsFiltered' => $items->total(),
            'data' => $items->items()
        ], 200);
    }
}