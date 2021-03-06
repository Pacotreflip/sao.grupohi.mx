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

        $this->middleware('permission:consultar_cuenta_concepto', ['only' => ['index']]);
        $this->middleware('permission:registrar_cuenta_concepto', ['only' => ['store']]);
        $this->middleware('permission:editar_cuenta_concepto', ['only' => ['update']]);

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

    public function searchNodo(Request $request){

        if(strlen($request->all()['texto'])>0) {
            $conceptos = $this->concepto->getBy('descripcion', 'like', '%' . $request->all()['texto'] . '%');
        }
        else{
            $conceptos = $this->concepto->getBy('nivel', 'like', '___.', 'cuentaConcepto');

        }
        return response()->json(['data' => ['concepto' => $conceptos]],200);
    }
}
