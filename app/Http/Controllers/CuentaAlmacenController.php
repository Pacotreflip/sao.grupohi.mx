<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\AlmacenRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaAlmacenRepository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class CuentaAlmacenController extends Controller
{
    use Helpers;

    /**
     * @var CuentaAlmacenRepository
     */
    private $cuenta_almacen;
    private $almacen;

    public function __construct(
        CuentaAlmacenRepository $cuenta_almacen,
        AlmacenRepository $almacen)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:consultar_cuenta_almacen', ['only' => ['index']]);
        $this->middleware('permission:registrar_cuenta_almacen', ['only' => ['store']]);
        $this->middleware('permission:editar_cuenta_almacen', ['only' => ['update']]);

        $this->cuenta_almacen = $cuenta_almacen;
        $this->almacen = $almacen;
    }

    public function index() {
        $almacenes = $this->almacen->with('cuentaAlmacen')->all();

        return view('sistema_contable.cuenta_almacen.index')
            ->with('almacenes', $almacenes);
    }

    public function update(Request $request, $id) {
        $item = $this->cuenta_almacen->update($request->all(), $id);
        return response()->json(['data' => ['cuenta_almacen' => $item]],200);
    }

    public function store(Request $request) {
        $item = $this->cuenta_almacen->create($request->all());
        return response()->json(['data' => ['cuenta_almacen' => $item]],200);
    }
}
