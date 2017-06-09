<?php namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Ghi\Domain\Core\Contracts\TipoMovimientoRepository;
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
     * @var CuentaContableRepository
     */
    private $cuenta_contable;

    /**
     * @var TipoMovimientoRepository
     */
    private $tipo_movimiento;

    /**
     * PolizaTipoController constructor.
     * @param PolizaTipoRepository $poliza_tipo
     * @param TransaccionInterfazRepository $transaccion_interfaz
     */
    public function __construct(
        PolizaTipoRepository $poliza_tipo,
        TransaccionInterfazRepository $transaccion_interfaz,
        CuentaContableRepository $cuenta_contable,
        TipoMovimientoRepository $tipo_movimiento)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->poliza_tipo = $poliza_tipo;
        $this->transaccion_interfaz = $transaccion_interfaz;
        $this->cuenta_contable = $cuenta_contable;
        $this->tipo_movimiento = $tipo_movimiento;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $polizas_tipo = $this->poliza_tipo->lists();
        return view('modulo_contable.poliza_tipo.index')->with('polizas_tipo', $polizas_tipo);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {

        $transacciones_interfaz = $this->transaccion_interfaz->lists();
        $cuentas_contables = $this->cuenta_contable->lists();
        $tipos_movimiento = $this->tipo_movimiento->lists();

        return view('modulo_contable.poliza_tipo.create')
            ->with([
                'transacciones_interfaz' => $transacciones_interfaz,
                'cuentas_contables'      => $cuentas_contables,
                'tipos_movimiento'       => $tipos_movimiento
            ]);
    }
}