<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoCobrabilidadRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class TipoCobrabilidadController extends Controller
{
    use Helpers;

    /**
     * @var TipoCobrabilidadRepository
     */
    protected $tipo_cobrabilidad;

    /**
     * TipoCobrabilidadController constructor.
     * @param TipoCobrabilidadRepository $tipo_cobrabilidad
     */
    public function __construct(TipoCobrabilidadRepository $tipo_cobrabilidad)
    {
        $this->middleware('auth');
        $this->middleware('context');
        $this->tipo_cobrabilidad = $tipo_cobrabilidad;
    }

    public function index()
    {
        $items = $this->tipo_cobrabilidad->all();
        return $this->response()->collection($items, function ($items) { return $items; });
    }
}
