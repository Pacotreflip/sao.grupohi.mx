<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Illuminate\Http\Request;


class AfectacionOrdenPresupuestoController extends Controller
{
    private $afectacion;

    public function __construct(AfectacionOrdenPresupuestoRepository $afectacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->afectacion = $afectacion;
    }

    public function getBasesAfectadas(Request $request){
        $presupuestos=$this->afectacion->with('baseDatos')->getBy('id_tipo_orden','=',$request->tipo_orden);
        return response()->json([
            'data' => $presupuestos
        ], 200);

    }
}
