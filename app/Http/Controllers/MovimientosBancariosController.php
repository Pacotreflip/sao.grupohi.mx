<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\Tesoreria\MovimientosBancariosRepository;
use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Tesoreria\MovimientosBancarios;
use Ghi\Domain\Core\Models\Tesoreria\TiposMovimientos;
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
//        $this->middleware('auth');
//        $this->middleware('context');

        $this->movimientos = $movimientos;
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
        $record = $this->movimientos->create($request->all());
    }
    public function destroy($id)
    {

    }

    public function update(Request $request, $id)
    {

    }
}
