<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoCobrabilidadRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class TarjetaController extends Controller
{
    use Helpers;

    /**
     * @var TarjetaRepository
     */
    protected $tarjeta;


    /**
     * TarjetaController constructor.
     * @param TarjetaRepository $tarjeta
     */
    public function __construct(TarjetaRepository $tarjeta)
    {
        $this->middleware('auth');
        $this->middleware('context');
        $this->tarjeta = $tarjeta;
    }

    public function index()
    {
        $tarjetas = $this->tarjeta->all();
        return $this->response()->collection($tarjetas, function ($item) { return $item; });
    }

    public function lists() {
        $tarjetas = $this->tarjeta->lists();
        return $this->response()->item($tarjetas, function ($item) {
            return $item;
        });
    }
}
