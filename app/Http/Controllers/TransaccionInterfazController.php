<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\TransaccionInterfazRepository;
use Illuminate\Http\Request;

class TransaccionInterfazController extends Controller
{
    /**
     * @var  TransaccionInterfazRepository
     */
    private $transaccion_interfaz;

    /**
     * TransaccionInterfazController constructor.
     * @param TransaccionInterfazRepository $transaccion_interfaz
     */
    public function __construct(TransaccionInterfazRepository $transaccion_interfaz)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->transaccion_interfaz = $transaccion_interfaz;
    }
}
