<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\AlmacenRepository;
use Ghi\Domain\Core\Transformers\AlmacenTreeTransformer;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class AlmacenController extends Controller
{

    use Helpers;

    protected $almacen;

    /**
     * ConceptoController constructor.
     * @param ConceptoRepository $concepto
     */
    public function __construct(AlmacenRepository $almacen)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->almacen = $almacen;
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function getRoot()
    {
        $resp = [
            'text' => "ALMACENES",
            'children' => true,
            'type' => 'folder',

        ];
        return response()->json($resp, 200);

    }

    public function show($id) {
        $almacen = $this->almacen->with('cuentaAlmacen')->find($id);

        return $this->response()->item($almacen, function ($item) { return $item; });
    }

    public function getNode($id)
    {
        $almacenes = $this->almacen->all();
        $resp = AlmacenTreeTransformer::transform($almacenes);
        return response()->json($resp, 200);
    }

    public function paginate(Request $request) {
        $almacenes = $this->almacen->with('cuentaAlmacen')->paginate($request->all());

        return response()->json([
            'recordsTotal' => $almacenes->total(),
            'recordsFiltered' => $almacenes->total(),
            'data' => $almacenes->items()
        ], 200);
    }
}
