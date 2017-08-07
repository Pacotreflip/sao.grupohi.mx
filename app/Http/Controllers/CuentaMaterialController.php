<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaMaterialRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\TipoCuentaMaterialRepository;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Illuminate\Http\Request;

class CuentaMaterialController extends Controller
{
    use Helpers;

    /**
     * @var MaterialRepository
     */
    private $material;

    private $cuenta_material;

    private $tipo_cuenta_material;

    public function __construct(
        MaterialRepository $material,
        CuentaMaterialRepository $cuenta_material,
        TipoCuentaMaterialRepository $tipo_cuenta_material
       )
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_cuenta_material', ['only' => ['index', 'show']]);
        $this->middleware('permission:editar_cuenta_material', ['only' => ['update']]);
        $this->middleware('permission:registrar_cuenta_material', ['only' => ['store']]);

        $this->material = $material;
        $this->cuenta_material = $cuenta_material;
        $this->tipo_cuenta_material = $tipo_cuenta_material;
    }


    public function index()
    {
        $tipos_cuenta_material = $this->tipo_cuenta_material->all();
        return view('sistema_contable.cuenta_material.index')
            ->with('tipos_cuenta_material', $tipos_cuenta_material);
    }

    public function update(Request $request, $id) {
        $item = $this->cuenta_material->update($request->all(), $id);
        return response()->json(['data' => ['cuenta_material' => $item]],200);
    }

    public function store(Request $request) {
        $item = $this->cuenta_material->create($request->all());
        return response()->json(['data' => ['cuenta_material' => $item]],200);
    }
}