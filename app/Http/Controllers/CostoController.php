<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\CostoRepository;
use Ghi\Domain\Core\Models\Costo;
use Ghi\Domain\Core\Transformers\CostoTreeTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;

class CostoController extends Controller
{
    use Helpers;

    protected $Costo;
    /**
     * CostoController constructor.
     * @param CostoRepository $Costo
     */
    public function __construct(CostoRepository $costo)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->costo = $costo;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findBy(Request $request)
    {
        $item = $this->costo->findBy($request->attribute, $request->value, $request->with);
        
        return response()->json(['data' => ['costo' => $item]], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBy(Request $request) {
        $items = $this->costo->getBy($request->attribute, $request->operator, $request->value, $request->with);

        return response()->json(['data' => ['costos' => $items]], 200);
    }

    public function getRoot()
    {
        $roots = $this->costo->getRootLevels();
        $resp=CostoTreeTransformer::transform($roots);
        return response()->json($resp, 200);

    }

    public function getNode($id)
    {
        $node = $this->costo->getDescendantsOf($id);
        $resp=CostoTreeTransformer::transform($node);

        return response()->json($resp, 200);

    }
}