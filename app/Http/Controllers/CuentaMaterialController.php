<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\CuentaMaterialRepository;
use Illuminate\Http\Request;

class CuentaMaterialController extends Controller
{

    /**
     * @var CuentaMaterialRepository
     */
    private $cuenta_material;


    public function __construct(CuentaMaterialRepository $cuenta_material)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_material = $cuenta_material;

    }

    /**
     * Muestra la vista del listado de Cuentasde Materiales registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cuentas_material = $this->cuenta_material->all();

        return view('sistema_contable.cuenta_material.index')
                    ->with('cuentas_material', $cuentas_material);
    }

    /**
     * Muestra la vista de creación de Cuenta de Materiales
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sistema_contable.cuenta_material.create');
    }

    /**
     * Devuelve la vista del detalle de una Cuenta de Materiales
     */
    public function show($id)
    {
        $cuenta_material = $this->cuenta_material->find($id);
        return view('sistema_contable.cuenta_material.show')
            ->with('cuenta_material', $cuenta_material);
    }


    /**
     * Guarda un registro de Tipo Cuenta Contable.
     */
    public function store(Request $request)
    {

        $item = $this->cuenta_material->create($request->all());

        return $this->response->created(route('sistema_contable.cuenta_material.show', $item));
    }

    /**
     * Elimina un Registro de Tipo Cuenta Contable
     */
    public function destroy(Request $request, $id)
    {
        $this->cuenta_material->delete($request->only('motivo'), $id);
        return $this->response()->accepted();
    }
}
