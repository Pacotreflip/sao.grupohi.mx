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

    public function store(Request $request)
    {

    }
    public function destroy($id)
    {

    }

    public function update(Request $request, $id)
    {

    }
}
