<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaContableRepository;
use Illuminate\Http\Request;

class PolizaController extends Controller
{
    use Helpers;

    protected $poliza;
    protected $tipoCuentaContable;

    public function __construct(PolizaRepository $poliza,TipoCuentaContableRepository $tipoCuenta)
    {
        parent::__construct();
        $this->poliza = $poliza;
        $this->tipoCuentaContable=$tipoCuenta;

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
        $poliza = $this->poliza->find($id, 'polizaMovimientos');
        $tipoCuentaContable=$this->tipoCuentaContable->lists();

        return view('sistema_contable.poliza_generada.edit')->with('poliza', $poliza)->with('tipoCuentaContable',$tipoCuentaContable);
    }

    public function update(Request $request,$id)
    {
        $item = $this->poliza->update($request->all(),$id);
        return $this->response->created(route('sistema_contable.poliza_generada.show', $item));
    }
}
