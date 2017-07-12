<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaContableRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Illuminate\Http\Request;

class PolizaController extends Controller
{
    use Helpers;

    protected $poliza;
    protected $tipoCuentaContable;
    protected $cuenta_contable;

    public function __construct(PolizaRepository $poliza,TipoCuentaContableRepository $tipoCuenta,CuentaContableRepository $cuenta_contable)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->poliza = $poliza;
        $this->tipoCuentaContable=$tipoCuenta;
        $this->cuenta_contable=$cuenta_contable;
    }

    public function index()
    {
        $polizas = $this->poliza->all();
        return view('sistema_contable.poliza_generada.index')->with('polizas', $polizas);
    }

    public function show($id)
    {
        $polizas = $this->poliza->find($id);
        return view('sistema_contable.poliza_generada.show')->with('poliza', $polizas);
    }

    public function edit($id)
    {

        $tipoCuentaContable=$this->tipoCuentaContable->with('cuentaContable')->lists();
        $poliza = $this->poliza->with('polizaMovimientos.tipoCuentaContable')->find($id);
        $cuentasContables=$this->cuenta_contable->all();

        return view('sistema_contable.poliza_generada.edit')->with('poliza', $poliza)->with('tipoCuentaContable',$tipoCuentaContable)->with('cuentasContables',$cuentasContables);
    }

    public function update(Request $request,$id)
    {
        $item = $this->poliza->update($request->all(),$id);
        return $this->response->created(route('sistema_contable.poliza_generada.show', $item));
    }
}
