<?php namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\MovimientoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoMovimientoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaTipoSAORepository;

use Ghi\Domain\Core\Models\Contabilidad\PolizaTipoSAO;
use Illuminate\Http\Request;

class PolizaTipoController extends Controller
{
    use Helpers;
    /**
     * @var PolizaTipoRepository
     */
    private $poliza_tipo;

    /**
     * @var PolizaTipoSAORepository
     */
    private $poliza_tipo_sao;

    /**
     * @var TipoCuentaContableRepository
     */
    private $tipo_cuenta_contable;

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
     * @param PolizaTipoSAORepository $poliza_tipo_sao
     * @param TipoCuentaContableRepository $tipo_cuenta_contable
     * @param TipoMovimientoRepository $tipo_movimiento
     * @param MovimientoRepository $movimiento
     */
    public function __construct(
        PolizaTipoRepository $poliza_tipo,
        PolizaTipoSAORepository $poliza_tipo_sao,
        TipoCuentaContableRepository $tipo_cuenta_contable,
        TipoMovimientoRepository $tipo_movimiento,
        MovimientoRepository $movimiento)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->poliza_tipo = $poliza_tipo;
        $this->poliza_tipo_sao = $poliza_tipo_sao;
        $this->tipo_cuenta_contable = $tipo_cuenta_contable;
        $this->tipo_movimiento = $tipo_movimiento;
        $this->movimiento = $movimiento;
    }

    /**
     * Muestra la vista del listado de Plantillas Para Tipos de Póliza registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $polizas_tipo = $this->poliza_tipo->all();

        return view('sistema_contable.poliza_tipo.index')
        ->with('polizas_tipo', $polizas_tipo);
    }

    /**
     * Muestra la vista de creación de Plantilla para un Tipo de Póliza
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $polizas_tipo_sao = $this->poliza_tipo_sao->lists();
        $tipos_cuentas_contables = $this->tipo_cuenta_contable->all();
        $tipos_movimiento = $this->tipo_movimiento->lists();

        return view('sistema_contable.poliza_tipo.create')
            ->with([
                'polizas_tipo_sao' => $polizas_tipo_sao,
                'tipos_cuentas_contables' => $tipos_cuentas_contables,
                'tipos_movimiento' => $tipos_movimiento
            ]);
    }

    /**
    * Devuelve la vista del detalle de una Plantilla pata Tipo de Póliza
    */
    public function show($id)
    {
        $poliza_tipo = $this->poliza_tipo->with('movimientos')->find($id);

        return view('sistema_contable.poliza_tipo.show')
            ->with('poliza_tipo', $poliza_tipo);
    }

    /**
     * Devuelve la Platilla que coincida con los atributos de búsqueda
     */
    public function findBy(Request $request)
    {
        $item = $this->poliza_tipo->findBy($request->attribute, $request->value, $request->with);

        return response()->json(['data' => ['poliza_tipo' => $item]], 200);
    }

    /**
     * Guarda un registro de Plantilla y sus respectivos movimientos
     */
    public function store(Request $request)
    {
        $item = $this->poliza_tipo->create($request->all());
        return $this->response->created(route('sistema_contable.poliza_tipo.show', $item));
    }

    /**
     * Elimina un registro de Plantilla
     */
    public function destroy(Request $request, $id)
    {
        $this->poliza_tipo->delete($request->only('motivo'), $id);
        return $this->response()->accepted();
    }
}