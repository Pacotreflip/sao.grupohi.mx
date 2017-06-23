<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\TipoCuentaContableRepository;
use Illuminate\Http\Request;

class TipoCuentaContableController extends Controller
{
    use Helpers;

    /**
     * @var TipoCuentaContableRepository
     */
    private $tipo_cuenta_contable;

    public function __construct(
        TipoCuentaContableRepository $tipo_cuenta_contable)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->tipo_cuenta_contable = $tipo_cuenta_contable;
    }

    /**
     * Muestra la vista del listado de Plantillas Para Tipos de Cuentas Contables registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tipos_cuenta_contable = $this->tipo_cuenta_contable->all();
        //dd($tipos_cuenta_contable);
        return view('modulo_contable.tipo_cuenta_contable.index')
            ->with('tipos_cuenta_contable', $tipos_cuenta_contable);
        //
    }

    /**
     * Devuelve la vista del detalle de una Plantilla pata Tipo de Cuenta Contable
     */
    public function show($id)
    {
        $tipo_cuenta_contable = $this->tipo_cuenta_contable->find($id);
        return view('modulo_contable.tipo_cuenta_contable.show')
            ->with('tipo_cuenta_contable', $tipo_cuenta_contable);
    }

    /**
     * Muestra la vista de creación de Plantilla para un Tipo de Póliza
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('modulo_contable.tipo_cuenta_contable.create');
    }

    /**
     * Guarda un registro de Tipo Cuenta Contable.
     */
    public function store(Request $request)
    {

        $item = $this->tipo_cuenta_contable->create($request->all());

        return $this->response->created(route('modulo_contable.tipo_cuenta_contable.show', $item));
    }

    /**
     * Elimina un Registro de Tipo Cuenta Contable
     */
    public function destroy(Request $request, $id)
    {
        $this->tipo_cuenta_contable->delete($request->only('motivo'), $id);
        return $this->response()->accepted();
    }
}
