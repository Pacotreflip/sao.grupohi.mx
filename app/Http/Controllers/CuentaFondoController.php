<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CuentaFondoRepository;
use Ghi\Domain\Core\Contracts\FondoRepository;
use Illuminate\Http\Request;

class CuentaFondoController extends Controller
{

    use Helpers;

    protected $fondo;
    protected $cuenta_fondo;

    public function __construct(FondoRepository $fondo, CuentaFondoRepository $cuenta_fondo)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->middleware('permission:consultar_cuenta_fondo', ['only' => ['index']]);
        $this->middleware('permission:registrar_cuenta_fondo', ['only' => ['store']]);
        $this->middleware('permission:editar_cuenta_fondo', ['only' => ['update']]);

        $this->fondo = $fondo;
        $this->cuenta_fondo = $cuenta_fondo;
    }


    public function index()
    {
        $fondos = $this->fondo->with('cuentaFondo')->all();

        return view('sistema_contable.cuenta_fondo.index')
            ->withFondos($fondos);
    }

    public function update(Request $request, $id) {
        $item = $this->cuenta_fondo->update($request->all(), $id);

        return response()->json(['data' => ['cuenta_fondo' => $item]], 200);
    }

    public function store(Request $request) {
        $item = $this->cuenta_fondo->create($request->all());
        return response()->json(['data' => ['cuenta_fondo' => $item]], 200);
    }
}
