<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Models\Cuenta;
use Illuminate\Http\Request;
use Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentasRepository;
use Illuminate\View\View;

class TraspasoCuentasController extends Controller
{
    /**
     *
     */
    public function __construct(TraspasoCuentasRepository $traspaso)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        // Permisos
        $this->middleware('permission:consultar_traspaso_cuenta', ['only' => ['index']]);
        $this->middleware('permission:eliminar_traspaso_cuenta', ['only' => ['destroy']]);
        $this->middleware('permission:editar_traspaso_cuenta', ['only' => ['update']]);

        $this->traspaso = $traspaso;
    }

    /**
     * @param Request $request
     * @internal param $Request
     * @return View
     */
    public function index(Request $request)
    {
        $cuentas = Cuenta::paraTraspaso()->with('empresa')->get();
        $traspasos = $this->traspaso->with(['cuenta_destino.empresa', 'cuenta_origen.empresa'])->all();

        return view('sistema_contable.traspaso_cuentas.index')
            ->with('cuentas', $cuentas)
            ->with('traspasos', $traspasos);
    }

    public function store(Request $request)
    {
        $record = $this->traspaso->create($request->all());

        return response()->json(['data' =>
            [
                'traspaso' => $record
            ]
        ], 200);
    }
    public function destroy($id)
    {
        $this->traspaso->delete($id);
        return response()->json(['data' =>
            [
                'id_traspaso' => $id
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $traspaso = $this->traspaso->update($request->all(), $id);
        return response()->json(['data' =>
            [
                'traspaso' => $traspaso
            ]
        ], 200);
    }
}
