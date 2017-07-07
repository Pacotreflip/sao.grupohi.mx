<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Contabilidad\CuentaEmpresaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaEmpresaRepository;
use Ghi\Domain\Core\Contracts\EmpresaRepository;
use Ghi\Domain\Core\Models\Contabilidad\TipoCuentaEmpresa;
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
    /**
     * @var TipoCuentaEmpresa
     */
    private $tipo_cuenta_empresa;


    public function __construct(CuentaEmpresaRepository $cuenta_empresa, EmpresaRepository $empresa, TipoCuentaEmpresaRepository $tipo_cuenta_empresa)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->cuenta_empresa = $cuenta_empresa;
        $this->empresa = $empresa;
        $this->tipo_cuenta_empresa = $tipo_cuenta_empresa;

    }

    /**
     * Muestra la vista del listado de Ceuntas de Empresar registradas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $empresas = $this->empresa->with('cuentasEmpresa')->all();

        return view('sistema_contable.cuenta_empresa.index')
            ->with('empresas', $empresas);
    }

    public function show($id)
    {
        $empresa = $this->empresa->with('cuentasEmpresa')->find($id);
        return view('sistema_contable.cuenta_empresa.show')->with('empresa', $empresa);
    }

    public function edit($id)
    {
        $empresa = $this->empresa->with('cuentasEmpresa.tipoCuentaEmpresa')->find($id);
        $tipoCuentaEmpresa = $this->tipo_cuenta_empresa->all();
        return view('sistema_contable.cuenta_empresa.edit')->with('empresa', $empresa)->with('tipo_cuenta_empresa', $tipoCuentaEmpresa);
    }

    public function delete(Request $request, $id)
    {
        $data = $request->all();
        $this->cuenta_empresa->delete($data, $id);
        $empresa = $this->empresa->with('cuentasEmpresa.tipoCuentaEmpresa')->find($data['data']['id_empresa']);
        return response()->json(['data' => ['empresa' => $empresa]], 200);

    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $this->cuenta_empresa->update($data, $id);
        $empresa = $this->empresa->with('cuentasEmpresa.tipoCuentaEmpresa')->find($data['data']['id_empresa']);
        return response()->json(['data' => ['empresa' => $empresa]], 200);
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $cuenta = $this->cuenta_empresa->create($data);

        return response()->json(['data' => ['cuenta_empresa' => $cuenta]], 200);
    }
}
