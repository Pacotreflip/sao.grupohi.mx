<?php

namespace Ghi\Http\Controllers\Compras;

use Dingo\Api\Routing\Helpers;
use Ghi\Core\Facades\Context;
use Ghi\Core\Models\Material;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\Requisicion;
use Illuminate\Http\Request;
use Ghi\Http\Controllers\Controller;

class RequisicionController extends Controller
{
    use Helpers;

    protected $requisicion;
    protected $material;

    /**
     * RequisicionController constructor.
     * @param RequisicionRepository $requisicion
     * @param MaterialRepository $material
     */
    public function __construct(RequisicionRepository $requisicion, MaterialRepository $material)
    {
        parent::__construct();

        //$this->middleware('auth');
        //$this->middleware('context');

        $this->requisicion = $requisicion;
        $this->material = $material;
    }

    public function index() {
        $items = $this->requisicion->all();

        return view('compras.requisicion.index')
            ->with('requisiciones', $items);
    }

    public function show($id) {
        $item = $this->requisicion->with('items')->find($id);

        return view('compras.requisicion.show')
            ->with('requisicion', $item);
    }

    public function create() {
        return view('compras.requisicion.create');
    }

    public function edit($id) {
        $item = $this->requisicion->with('items')->find($id);

        $materiales = $this->material->scope('materiales')->getBy('unidad','!=', null);

        return view('compras.requisicion.edit')
            ->with([
                'requisicion' => $item,
                'materiales' => $materiales
            ]);
    }

    public function update(Request $request, $id) {
        $item = $this->requisicion->update($request->all(), $id);

        return response()->json(['data' => ['requisicion' => $item]], 200);
    }

    public function store(Request $request) {
        $item = $this->requisicion->create($request->all());

        return response()->json(['data' => ['requisicion' => $item]],200);
    }

    public function destroy($id) {
        $this->requisicion->delete($id);
        return $this->response->accepted();
    }
}