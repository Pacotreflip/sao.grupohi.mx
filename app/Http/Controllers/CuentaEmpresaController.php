<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class CuentaEmpresaController extends Controller
{

    /**
     * @var Cuenta
     */
    private $cuenta_empresa;


    public function __construct(CuentaEmpresaRepository $cuenta_empresa)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_empresa = $cuenta_empresa;

    }

    /**
     * Muestra la vista del listado de Ceuntas de Empresar registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cuenta_empresa = $this->cuenta_empresa->all();
         dd($cuenta_empresa);
        return view('sistema_contable.cuenta_empresa.index')
            ->with('cuenta_empresa', $cuenta_empresa);
    }
}
