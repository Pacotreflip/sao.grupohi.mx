<?php

namespace Ghi\Http\Controllers;

use Illuminate\Http\Request;
use Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentasRepository;

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

        $this->traspaso = $traspaso;
    }

    /**
     * @param  Request
     * @return [type]
     */
    public function index(Request $request)
    {
        // Hardcode
        $cuenta_origen =  $cuenta_destino = $this->traspaso->cuentas();
        $traspasos = false;

        return view('sistema_contable.traspaso_cuentas.index')
            ->with('cuenta_origen', $cuenta_origen)
            ->with('cuenta_destino', $cuenta_destino)
            ->with('traspasos', $traspasos);
    }

    public function guardar(Request $request)
    {
//        $nuevo_traspaso = $this->traspaso->create($request->all());
        $nuevo_traspaso = [
            'id_traspaso' => 1,
            'estatus' => 1,
            'id_cuenta_origen' => $request->cuenta_origen,
            'id_cuenta_destino' => $request->cuenta_destino,
            'importe' => $request->importe,
            'observaciones' => $request->observaciones
        ];

        return response()->json(['data' =>
            [
                'traspaso' => $nuevo_traspaso
            ]
        ], 200);
    }
}
