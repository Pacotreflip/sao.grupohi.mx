<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class ConceptoCuentaController extends Controller
{

    use Helpers;

    protected $concepto;

    /**
     * ConceptoController constructor.
     * @param ConceptoRepository $concepto
     */
    public function __construct(ConceptoRepository $concepto)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
    }


    public function index()
    {
        $conceptos = $this->concepto->getBy('nivel', 'like', '___.', 'cuentaConcepto');

       //$conceptos = Concepto::limit(30)->orderBy('nivel')->get();
        return view('sistema_contable.concepto_cuenta.index')
            ->withConceptos($conceptos);
    }
}
