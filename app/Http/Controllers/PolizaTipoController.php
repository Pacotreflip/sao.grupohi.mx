<?php namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\MovimientoRepository;
use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Ghi\Domain\Core\Contracts\TipoMovimientoRepository;
use Ghi\Domain\Core\Contracts\TransaccionInterfazRepository;
use Illuminate\Http\Request;

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
     * @var MovimientoRepository
     */
    private $movimiento;

    /**
     * PolizaTipoController constructor.
     * @param PolizaTipoRepository $poliza_tipo
     * @param TransaccionInterfazRepository $transaccion_interfaz
     * @param CuentaContableRepository $cuenta_contable
     * @param TipoMovimientoRepository $tipo_movimiento
     * @param MovimientoRepository $movimiento
     */
    public function __construct(
        PolizaTipoRepository $poliza_tipo,
        TransaccionInterfazRepository $transaccion_interfaz,
        CuentaContableRepository $cuenta_contable,
        TipoMovimientoRepository $tipo_movimiento,
        MovimientoRepository $movimiento)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->poliza_tipo = $poliza_tipo;
        $this->transaccion_interfaz = $transaccion_interfaz;
        $this->cuenta_contable = $cuenta_contable;
        $this->tipo_movimiento = $tipo_movimiento;
        $this->movimiento = $movimiento;
    }

    /**
     * Muestra la vista del listado de Pólizas tipo registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $polizas_tipo = $this->poliza_tipo->getAll();
        return view('modulo_contable.poliza_tipo.index')
            ->with('polizas_tipo', $polizas_tipo);
    }


    /**
     * Muestra la vista de creación de Póliza ipo
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

    /*
     * Recibe los datos para la creación de una nueva Póliza Tipo
     */
    public function  store(Request $request){
        return response()->json(['success' => $this->poliza_tipo->create($request)]);
    }

    public function show($id) {
        $poliza_tipo = $this->poliza_tipo->getById($id);
        $movimientos = $this->movimiento->getByPolizaTipoId($poliza_tipo->id);

        return view('modulo_contable.poliza_tipo.show')
            ->with([
                'poliza_tipo' => $poliza_tipo,
                'movimientos' => $movimientos
            ]);
    }
}