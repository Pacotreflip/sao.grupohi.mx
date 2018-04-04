<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Transformers\ConceptoTreeTransformer;
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

    public function show(Request $request, $id) {
        $concepto = $this->concepto->getById($id);
        return $this->response()->item($concepto, function ($item) {
            return $item;
        });
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

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function getRoot()
    {
        $roots = $this->concepto->getRootLevels();
        $resp=ConceptoTreeTransformer::transform($roots);
        return response()->json($resp, 200);

    }

    public function getNode($id)
    {
        $node = $this->concepto->getDescendantsOf($id);


        $resp=ConceptoTreeTransformer::transform($node);

       // $data = Fractal::createData($resource);
        return response()->json($resp, 200);

    }

    public function getPaths(Request $request) {

        $conceptos = $this->concepto->paths($request->all());

        return response()->json([
            'recordsTotal' => $conceptos->total(),
            'recordsFiltered' => $conceptos->total(),
            'data' => $conceptos->items()
            ], 200);
    }

    public function getPathsConceptos(Request $request) {

        $conceptos = $this->concepto->pathsConceptos($request->all());

        return response()->json([
            'recordsTotal' => $conceptos->total(),
            'recordsFiltered' => $conceptos->total(),
            'data' => $conceptos->items()
        ], 200);
    }

    public function getPathsCostoIndirecto(Request $request){
        $items = $this->concepto->pathsCostoIndirecto($request->all());
        return response()->json(['data' => ['conceptos' => $items]], 200);
    }

    public function getInsumos($id){
        $insumos = $this->concepto->getInsumos($id);
        return $insumos;
    }

    public function getPathColumns() {
        return $this->concepto->getPathColmns();
    }

    public function getPreciosConceptos($id){
        $items=$this->concepto->getPreciosConceptos($id);
        return response()->json(['data' => ['precios' => $items]], 200);
    }
}