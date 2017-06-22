<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\PolizaRepository;

class PolizaController extends Controller
{

    protected $poliza;

    public function __construct(PolizaRepository $poliza)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->poliza = $poliza;

    }

    public function index()
    {
        $polizas = $this->poliza->all();
        return view('modulo_contable.poliza_general.index')->with('polizas', $polizas);
    }

    public function show($id)
    {
        $polizas = $this->poliza->find($id);
        return view('modulo_contable.poliza_general.show')->with('poliza', $polizas);
    }
}
