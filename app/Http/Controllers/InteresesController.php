<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Models\Cuenta;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoTransaccion;
use Ghi\Domain\Core\Models\Tesoreria\TraspasoCuentas;
use Illuminate\Http\Request;
use Ghi\Domain\Core\Contracts\Tesoreria\InteresTransaccionRepository;
use Illuminate\View\View;

class InteresesController extends Controller
{
    /**
     *
     */
    public function __construct(InteresTransaccionRepository $interes_transaccion)
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->interes_transaccion = $traspaso_transaccion;
    }

    /**
     * @param Request $request
     * @internal param $Request
     * @return View
     */
    public function index(Request $request)
    {
        $dataView = [ ];

        return view('tesoreria.interes.index')
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
