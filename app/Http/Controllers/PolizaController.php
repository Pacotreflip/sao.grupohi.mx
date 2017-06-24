<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\PolizaRepository;
use Illuminate\Http\Request;

class PolizaController extends Controller
{

    protected $poliza;

    public function __construct(PolizaRepository $poliza)
    {
        parent::__construct();

        //$this->middleware('auth');
        //$this->middleware('context');
        $this->poliza = $poliza;

    }

    public function index()
    {
        $polizas = $this->poliza->all();
        return view('modulo_contable.poliza_generada.index')->with('polizas', $polizas);
    }

    public function show($id)
    {
        $polizas = $this->poliza->find($id);
        return view('modulo_contable.poliza_generada.show')->with('poliza', $polizas);
    }

    public function edit($id)
    {
        $poliza = $this->poliza->find($id, 'polizaMovimientos');
        return view('modulo_contable.poliza_generada.edit')->with('poliza', $poliza);
    }

    public function update(Request $request,$id)
    {
        $item = $this->poliza->update($request->all(),$id);

        return response()->json(['data' => ['poliza_generada' => $item]],200);
    }
}
