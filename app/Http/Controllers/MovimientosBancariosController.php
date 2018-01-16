<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Tesoreria\MovimientosBancarios;
use Ghi\Domain\Core\Models\Tesoreria\TipoMovimiento;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovimientosBancariosController extends Controller
{
    /**
     * @var MovimientosBancariosRepository
     */
    private $movimientos;

    /**
     * @param MovimientosBancariosRepository $movimientos
     */
    public function __construct(MovimientosBancariosRepository $movimientos)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        // Permisos
        $this->middleware('permission:consultar_movimiento_bancario', ['only' => ['index']]);
        $this->middleware('permission:eliminar_movimiento_bancario', ['only' => ['destroy']]);
        $this->middleware('permission:editar_movimiento_bancario', ['only' => ['update']]);

        $this->movimientos = $movimientos;
    }

    /**
     * @param Request $request
     * @internal param $Request
     * @return View
     */
    public function index(Request $request)
    {
        return view('tesoreria.movimientos_bancarios.index')
            ->with('dataView', [
            'cuentas' => Cuenta::paraTraspaso()->with('empresa')->get(),
            'tipos' => TipoMovimiento::get(),
            'movimientos' => MovimientosBancarios::with(['tipo', 'cuenta.empresa', 'movimiento_transaccion.transaccion'])->get(),
        ]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $record = $this->movimientos->create($request->all());

        return response()->json(['data' =>
            [
                'movimiento' => $record
            ]
        ], 200);
    }
    public function destroy($id)
    {
        $this->movimientos->delete($id);

        return response()->json(['data' =>
            [
                'id_movimiento_bancario' => $id
            ]
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $movimiento = $this->movimientos->update($request->all(), $id);

        return response()->json(['data' =>
            [
                'movimiento' => $movimiento
            ]
        ], 200);
    }
}
