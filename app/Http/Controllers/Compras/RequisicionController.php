<?php

namespace Ghi\Http\Controllers\Compras;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Compras\RequisicionRepository;
use Illuminate\Http\Request;
use Ghi\Http\Controllers\Controller;

class RequisicionController extends Controller
{
    use Helpers;

    protected $requisicion;

    /**
     * RequisicionController constructor.
     * @param RequisicionRepository $requisicion
     */
    public function __construct(RequisicionRepository $requisicion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->requisicion = $requisicion;
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
        return view('compras.requisicion.edit')
            ->with('requisicion', $item);
    }

    public function store(Request $request) {
        $item = $this->requisicion->create($request->all());
        return response()->json(['data' => ['requisicion' => $item]],200);
    }
}