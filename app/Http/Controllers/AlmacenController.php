<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\AlmacenRepository;
use Ghi\Domain\Core\Transformers\AlmacenTreeTransformer;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class AlmacenController extends Controller
{

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

    public function getNode($id)
    {
        $almacenes = $this->almacen->all();
        $resp = AlmacenTreeTransformer::transform($almacenes);
        return response()->json($resp, 200);
    }
}
