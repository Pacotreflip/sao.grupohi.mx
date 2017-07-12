<?php

namespace Ghi\Http\Controllers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Illuminate\Http\Request;

class CuentaContableController extends Controller
{
    protected $cuenta_contable;
    protected $tipo_cuenta_contable;

    /**
     * CuentaContableController constructor.
     * @param CuentaContableRepository $cuenta_contable
     * @param TipoCuentaContableRepository $tipo_cuenta_contable
     */
    public function __construct(
        CuentaContableRepository $cuenta_contable, TipoCuentaContableRepository $tipo_cuenta_contable)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_contable = $cuenta_contable;
        $this->tipo_cuenta_contable = $tipo_cuenta_contable;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
       $cuentas_contables=$this->cuenta_contable->with('tipoCuentaContable')->getBy('estatus','=',1);
        return view('sistema_contable.cuenta_contable.index')
            ->with('cuentas_contables', $cuentas_contables);
    }

    /**
     * Guarda un registro de Cuenta Contable
     */
    public function store(Request $request)
    {
        $item = $this->cuenta_contable->create($request->all());
        $cuentas_contables=$this->cuenta_contable->with('tipoCuentaContable')->getBy('estatus','=',1);
        return response()->json(['data' =>
            [
                'cuenta_contable' => $item,
                'cuentas_contables' => $cuentas_contables
            ]
        ], 200);
    }

    /**
     * Actualiza un registro de Cuenta Contable
     */
    public function update(Request $request, $id)
    {
        $item = $this->cuenta_contable->update($request->all(), $id);
        $cuentas_contables=$this->cuenta_contable->with('tipoCuentaContable')->getBy('estatus','=',1);

        return response()->json(['data' =>
            [
                'cuenta_contable' => $item,
                'cuentas_contables' => $cuentas_contables
            ]
        ], 200);
    }

    /**
     * Busca y devuelve una Cuenta Contable que coincida con el atributo de búsqueda
     */
    public function findBy(Request $request)
    {
        $item = $this->cuenta_contable->with('tipoCuentaContable')->findBy($request->attribute, $request->value);
        return response()->json(['data' => ['cuenta_contable' => $item]], 200);
    }
}