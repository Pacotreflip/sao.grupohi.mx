<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoOrdenRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class TipoOrdenController extends Controller
{
    use Helpers;

    /**
     * @var TipoOrdenController
     */
    protected $tipo_orden;

    /**
     * TipoOrdenController constructor.
     * @param TipoOrdenRepository $tipo_orden
     */
    public function __construct(TipoOrdenRepository $tipo_orden)
    {
        $this->middleware('auth');
        $this->middleware('context');
        $this->tipo_orden = $tipo_orden;
    }

    public function index()
    {
        $items = $this->tipo_orden->all();
        return $this->response()->collection($items, function ($items) { return $items; });
    }
}
