<?php

namespace Ghi\Http\Controllers;



use Ghi\Domain\Core\Contracts\PolizaHistoricoRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class PolizaHistoricoController extends Controller
{
    /**
     * @var PolizaRepository
     */
    protected $poliza;

    public function __construct(PolizaHistoricoRepository $poliza)
    {
        parent::__construct();

        //$this->middleware('auth');
        //$this->middleware('context');
        $this->poliza = $poliza;

    }


    /**
     * @param $poliza
     * @return $this
     */
    public function index($poliza){
       $polizas = $this->poliza->find($poliza);
        return view('modulo_contable.poliza_generada.historico')->with('polizas', $polizas);

    }
}
