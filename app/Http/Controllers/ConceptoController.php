<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;

use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Illuminate\Http\Request;

class ConceptoController extends Controller
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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findBy(Request $request)
    {
        $item = $this->concepto->findBy($request->attribute, $request->value, $request->with);
        return response()->json(['data' => ['concepto' => $item]], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBy(Request $request) {
        $items = $this->concepto->getBy($request->attribute, $request->operator, $request->value, $request->with);
        return response()->json(['data' => ['conceptos' => $items]], 200);
    }
}