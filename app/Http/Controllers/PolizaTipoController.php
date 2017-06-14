<?php namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\MovimientoRepository;
use Ghi\Domain\Core\Contracts\PolizaTipoRepository;
use Ghi\Domain\Core\Contracts\TipoMovimientoRepository;
use Ghi\Domain\Core\Contracts\TransaccionInterfazRepository;
use Illuminate\Http\Request;

class PolizaTipoController extends Controller
{

    use Helpers;
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
     * Muestra la vista del listado de Plantillas Para Tipos de Póliza registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        $polizas_tipo = $this->poliza_tipo->all();


        return view('modulo_contable.poliza_tipo.index')
            ->with('polizas_tipo', $polizas_tipo);
    }


    /**
     * Muestra la vista de creación de Plantilla para un Tipo de Póliza
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
    * Devuelve la vista del detalle de una Plantilla pata Tipo de Póliza
    */
    public function show($id) {
        $poliza_tipo = $this->poliza_tipo->find($id);
        $movimientos = $this->movimiento->findBy('id_poliza_tipo', $poliza_tipo->id);

        return view('modulo_contable.poliza_tipo.show')
            ->with([
                'poliza_tipo' => $poliza_tipo,
                'movimientos' => $movimientos
            ]);
    }

    public function findBy(Request $request) {
        $item = $this->poliza_tipo->findBy($request->attribute, $request->value, $request->with);

        if (! $item) {
            return $this->response->noContent();
        }
        return $this->response->array($item->toArray());
    }

    public function store(Request $request) {
         $item = $this->poliza_tipo->create($request->all());

        if(! $item) {
            return $this->response->errorInternal();
        }

        return $this->response->created(route('modulo_contable.poliza_tipo.show', $item));
    }

    public function destroy(Request $request, $id)
    {
        $data = [
            'cancelo' => auth()->user()->idusuario,
            'motivo'  => $request->motivo
        ];

        $item = $this->poliza_tipo->delete($data, $id);
        if(! $item) {
            return $this->response->errorInternal();
        }

        return $this->response->accepted(route('modulo_contable.poliza_tipo.index'));
    }
}