<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoSAORepository;
use Illuminate\Http\Request;

class TransaccionInterfazController extends Controller
{
    /**
     * @var  PolizaTipoSAORepository
     */
    private $transaccion_interfaz;

    /**
     * TransaccionInterfazController constructor.
     * @param PolizaTipoSAORepository $transaccion_interfaz
     */
    public function __construct(PolizaTipoSAORepository $transaccion_interfaz)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->transaccion_interfaz = $transaccion_interfaz;
    }
}
