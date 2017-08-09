<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\MaterialRepository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class KardexMaterialController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $material;

    public function __construct(MaterialRepository $material)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_kardex_material', ['only' => ['index']]);

        $this->material = $material;
    }

    /**
     * Muestra la vista del listado del Material para visualizar en el Kardex
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('sistema_contable.kardex_material.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBy(Request $request) {
        $items = $this->material->scope('ConTransaccionES')->getBy($request->attribute, $request->operator, $request->value);
        return response()->json(['data' => ['materiales' => $items]], 200);

    }


}
