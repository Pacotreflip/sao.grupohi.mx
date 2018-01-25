<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
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


    public function __construct(TarjetaRepository $tipo_cobrabilidad)
    {
        $this->middleware('auth');
        $this->middleware('context');
    }

    public function index()
    {

    }
}
