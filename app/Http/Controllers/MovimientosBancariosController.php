<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Tesoreria\MovimientosBancarios;
use Ghi\Domain\Core\Models\Tesoreria\TiposMovimientos;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovimientosBancariosController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->movimientos = new MovimientosBancarios;
    }

    /**
     * @param Request $request
     * @internal param $Request
     * @return View
     */
    public function index(Request $request)
    {
        $dataView = [
            'cuentas' => Cuenta::paraTraspaso()->with('empresa')->get(),
            'tipos' => TiposMovimientos::get(),
        ];

        return view('tesoreria.movimientos_bancarios.index')
            ->with('dataView', $dataView);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $record = $this->traspaso->create($request->all());

        // Naturaloeza => tipo de transaccion
        $tipos_transaccion = [
            1 => 83,
            2 => 84
        ];
        $naturaleza = 0;

        $tipos_movimientos = TiposMovimientos::get();

        foreach ( $tipos_movimientos as $t)
            if ($t->)

        $transaccion = [
            'tipo_transaccion' => 83,
            'fecha' => $request->input('fecha') ? $request->input('fecha') : date('Y-m-d'),
            'estado' => 1,
            'id_obra' => $id_obra,
            'id_cuenta' => $request->input('id_cuenta_destino'),
            'id_moneda' => $id_moneda,
            'cumplimiento' => $request->input('cumplimiento') ? $request->input('cumplimiento') : date('Y-m-d'),
            'vencimiento' => $request->input('vencimiento') ? $request->input('vencimiento') : date('Y-m-d'),
            'opciones' => 1,
            'monto' => $request->input('importe'),
            'referencia' => $request->input('referencia'),
            'comentario' => "I;". date("d/m/Y") ." ". date("h:s") .";". auth()->user()->usuario,
            'observaciones' => $request->input('observaciones'),
            'FechaHoraRegistro' => date('Y-m-d h:i:s'),
        ];
    }
    public function destroy($id)
    {

    }

    public function update(Request $request, $id)
    {

    }
}
