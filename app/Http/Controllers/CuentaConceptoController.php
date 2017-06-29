<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaConceptoRepository;
use Illuminate\Http\Request;

class CuentaConceptoController extends Controller
{

    use Helpers;

    protected $concepto;
    protected $cuenta_concepto;

    /**
     * CuentaConcepto constructor.
     * @param ConceptoRepository $concepto
     */
    public function __construct(ConceptoRepository $concepto, CuentaConceptoRepository $cuenta_concepto)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
        $this->cuenta_concepto = $cuenta_concepto;
    }


    public function index()
    {
        $conceptos = $this->concepto->getBy('nivel', 'like', '___.', 'cuentaConcepto');

        return view('sistema_contable.cuenta_concepto.index')
            ->withConceptos($conceptos);
    }

    public function update(Request $request, $id) {
        $item = $this->cuenta_concepto->update($request->all(), $id);
        return response()->json(['data' => ['cuenta_concepto' => $item]],200);
    }

    public function store(Request $request) {
        $item = $this->cuenta_concepto->create($request->all());
        return response()->json(['data' => ['cuenta_concepto' => $item]],200);
    }
}
