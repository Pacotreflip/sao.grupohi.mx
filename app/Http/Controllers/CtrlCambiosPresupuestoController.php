<?php

namespace Ghi\Http\Controllers;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Illuminate\Http\Request;
use Ghi\Http\Requests;

class CtrlCambiosPresupuestoController extends Controller
{
    protected $operadores = [
        '= "{texto}"' => 'Igual A',
        '!= "{texto}"' => 'Diferente De',
        'like "{texto}%"' => 'Empieza Con',
        'like "%{texto}"' => 'Termina Con',
        'like "%{texto}%"' => 'Contiene'
    ];

    private $presupuesto;

    public function __construct(PresupuestoRepository $presupuesto)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->presupuesto = $presupuesto;
    }

    public function index(){
        return view('control_presupuesto.control_cambios_presupuesto.index')
            ->with('max_niveles', $this->presupuesto->getMaxNiveles())
            ->with('operadores', $this->operadores);
    }

    public function  create(){
        return view('control_presupuesto.control_cambios_presupuesto.create')
            ->with('max_niveles', $this->presupuesto->getMaxNiveles())
            ->with('operadores', $this->operadores);
    }
}
