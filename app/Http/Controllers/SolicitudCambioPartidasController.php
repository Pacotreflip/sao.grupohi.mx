<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Illuminate\Http\Request;

class SolicitudCambioPartidasController extends Controller
{
    // use Helpers;
    private $partida;

    public function __construct(SolicitudCambioPartidaRepository $partida)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->partida = $partida;
    }

    public function mostrarAfectacion($id)
    {
        $afectaciones = $this->partida->mostrarAfectacion($id);
        return response()->json([
            'data' => $afectaciones
        ], 200);
    }

    public function detallePresupuesto(Request $request)
    {
        $afectaciones = $this->partida->mostrarAfectacionPresupuesto($request->all());
        return response()->json([
            'data' => $afectaciones
        ], 200);
    }
    public function subtotalTarjetaShow(Request $request)
    {
        $afectaciones = $this->partida->subtotalTarjetaShow($request->all());
        return response()->json([
            'data' => $afectaciones
        ], 200);
    }
     public function subtotalTarjeta(Request $request)
    {
        $afectaciones = $this->partida->mostrarSubtotalTarjeta($request->all());
        return response()->json([
            'data' => $afectaciones
        ], 200);
    }


}
