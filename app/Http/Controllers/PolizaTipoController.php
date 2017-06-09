<?php namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Ghi\Domain\Core\Contracts\TransaccionInterfazRepository;

class PolizaTipoController extends Controller
{
    /**
     * @var PolizaTipoRepository
     */
    private $poliza_tipo;

    /**
     * @var TransaccionInterfazRepository
     */
    private $transaccion_interfaz;

    /**
     * PolizaTipoController constructor.
     * @param PolizaTipoRepository $poliza_tipo
     * @param TransaccionInterfazRepository $transaccion_interfaz
     */
    public function __construct(PolizaTipoRepository $poliza_tipo, TransaccionInterfazRepository $transaccion_interfaz)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');
        $this->poliza_tipo = $poliza_tipo;
        $this->transaccion_interfaz = $transaccion_interfaz;
    }

    public function index() {
        $polizas_tipo = $this->poliza_tipo->getAll();
        return view('modulo_contable.poliza_tipo.index')
            ->with('polizas_tipo', $polizas_tipo);
    }

    public function create() {
        $transacciones_interfaz = $this->transaccion_interfaz->getAll();
        return view('modulo_contable.poliza_tipo.create')
            ->with('transacciones_interfaz', $transacciones_interfaz);
    }
}