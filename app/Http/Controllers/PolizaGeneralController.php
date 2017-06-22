<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\PolizasRepository;

class PolizaGeneralController extends Controller
{

    protected $polizas;

    public function __construct(PolizasRepository $polizas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->polizas=$polizas;
    }

    public function index()
    {
        $polizas=$this->polizas->all('tiposPolizasContpaq');

        return view('modulo_contable.poliza_general.index')->with('polizas',$polizas);
    }
}
