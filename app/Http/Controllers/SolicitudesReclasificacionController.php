<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitarReclasificacionesRepository;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Http\Request;

class SolicitudesReclasificacionController extends Controller
{
    use Helpers;

    /**
     * SolicitarReclasificacionController constructor.
     * @param Concepto|ConceptoRepository $concepto
     * @param ConceptoPathRepository $conceptoPath
     * @param SolicitarReclasificacionesRepository $solicitar
     * @internal param TransaccionRepository $trasaccion
     */
    public function __construct(ConceptoRepository $concepto, ConceptoPathRepository $conceptoPath, SolicitarReclasificacionesRepository $solicitar)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
        $this->conceptoPath = $conceptoPath;
        $this->solicitar = $solicitar;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $r = $this->solicitar->with(['concepto', 'concepto_nuevo'])->all();
        dd($r);

        $data_view = [
            'nuevo' => $this->concepto->obtenerMaxNumNiveles(),
            'antiguo' => $this->operadores,
        ];

        return view('control_costos.solicitar_reclasificacion.index')
            ->with('data_view', $data_view);
    }
}