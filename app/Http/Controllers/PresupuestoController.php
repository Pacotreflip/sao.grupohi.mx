<?php

namespace Ghi\Http\Controllers;

use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Illuminate\Http\Request;


class PresupuestoController extends Controller
{
    private $presupuesto;

    public function __construct(PresupuestoRepository $presupuesto)
    {
        parent::__construct();
//        $this->middleware('auth');
        $this->middleware('context');

        $this->presupuesto = $presupuesto;

    }

    public function index(){
        return view('control_presupuesto.presupuesto.index')->with('max_niveles', $this->presupuesto->getMaxNiveles());
    }
}
