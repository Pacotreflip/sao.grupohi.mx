<?php

namespace Ghi\Http\Controllers;



use Ghi\Domain\Core\Contracts\Contabilidad\PolizaHistoricoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\PolizaRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class PolizaHistoricoController extends Controller
{
    /**
     * @var PolizaHistoricoRepository
     */
    protected $polizaHistorico;
    /**
     * @var PolizaRepository
     */
    protected $poliza;


    public function __construct(PolizaHistoricoRepository $polizaHistorico,PolizaRepository $poliza)
    {
        parent::__construct();

        //$this->middleware('auth');
        //$this->middleware('context');
        $this->polizaHistorico = $polizaHistorico;
        $this->poliza=$poliza;

    }


    /**
     * @param $poliza
     * @return $this
     */
    public function index($poliza){

         $poliza_actual = $this->poliza->find($poliza);
         $polizas = $this->polizaHistorico->find($poliza);
        return view('sistema_contable.poliza_generada.historico')->with('polizas', $polizas)->with('poliza',$poliza_actual);

    }
}
