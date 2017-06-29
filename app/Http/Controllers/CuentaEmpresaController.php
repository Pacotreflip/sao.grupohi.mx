<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class CuentaEmpresaController extends Controller
{

    /**
     * @var Cuenta
     */
    private $cuenta_empresa;
    /**
     * @var Empresa
     */
    private $empresa;

    public function __construct(CuentaEmpresaRepository $cuenta_empresa,EmpresaRepository $empresa)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_empresa = $cuenta_empresa;
        $this->empresa=$empresa;

    }

    /**
     * Muestra la vista del listado de Ceuntas de Empresar registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $empresas = $this->empresa->all('cuentasEmpresa');

        return view('sistema_contable.cuenta_empresa.index')
            ->with('empresas', $empresas);
    }

    public function show($id){

        $empresa = $this->empresa->find($id,'cuentasEmpresa');
        return view('sistema_contable.cuenta_empresa.show')->with('empresa', $empresa);
    }
}
