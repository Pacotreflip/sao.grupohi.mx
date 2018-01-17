<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionPartidasRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionAutorizadaRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRechazadaRepository;
use Ghi\Domain\Core\Reportes\ControlCostos\Solicitudes;
use Illuminate\Http\Request;

/**
 * Class SolicitudesReclasificacionController
 * @package Ghi\Http\Controllers
 */
class SolicitudesReclasificacionController extends Controller
{
    use Helpers;

    /**
     * SolicitudesReclasificacionController constructor.
     * @param SolicitudReclasificacionRepository $solicitud
     * @param SolicitudReclasificacionPartidasRepository $partidas
     * @param SolicitudReclasificacionAutorizadaRepository $autorizadas
     * @param SolicitudReclasificacionRechazadaRepository $rechazadas
     */
    public function __construct(SolicitudReclasificacionRepository $solicitud, SolicitudReclasificacionPartidasRepository $partidas, SolicitudReclasificacionAutorizadaRepository $autorizadas, SolicitudReclasificacionRechazadaRepository $rechazadas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        // Permisos
        $this->middleware('permission:autorizar_reclasificacion', ['only' => ['store']]);
        $this->middleware('permission:consultar_reclasificacion', ['only' => ['index']]);

        $this->solicitar = $solicitud;
        $this->partidas = $partidas;
        $this->autorizadas = $autorizadas;
        $this->rechazadas = $rechazadas;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $repetidas = !empty($request->repetidas) ? $request->repetidas : '';

        return view('control_costos.solicitudes_reclasificacion.index')
            ->with('repetidas', $repetidas);
    }

    public function paginate(Request $request) {
        $items = $this->solicitar->paginate($request->all());



        return response()->json([
            'recordsTotal' => $items->total(),
            'recordsFiltered' => $items->total(),
            'data' => $items->items()
        ], 200);
    }

    public function store(Request $request)
    {
        $tipo = $request->tipo;
        $data = json_decode($request->data, true);

        if ($tipo == 'aprobar')
            $resultado  = $this->autorizadas->create($data);

        else
        {
            $data['motivo_rechazo'] = htmlentities($request->motivo, ENT_QUOTES);
            $resultado = $this->rechazadas->create($data);
        }

        return response()->json(
            [
                'resultado' => $resultado
            ], 200);
    }

    /**
     *
     */
    public  function generar_pdf(Request $request)
    {
        $solicitud = $this->solicitar->find($request->item);

        $pdf = new Solicitudes($solicitud);
        $pdf->create();
    }
}