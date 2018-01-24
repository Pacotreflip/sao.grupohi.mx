<?php

namespace Ghi\Http\Controllers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Illuminate\Http\Request;


class CambioPresupuestoController extends Controller
{
    protected $operadores = [
        '= "{texto}"' => 'Igual A',
        '!= "{texto}"' => 'Diferente De',
        'like "{texto}%"' => 'Empieza Con',
        'like "%{texto}"' => 'Termina Con',
        'like "%{texto}%"' => 'Contiene'
    ];

    private $presupuesto;
    private $concepto;
    private $basePresupuesto;

    public function __construct(PresupuestoRepository $presupuesto,ConceptoRepository $concepto,BasePresupuestoRepository $basePresupuesto)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto=$basePresupuesto;
        $this->concepto=$concepto;
    }

    public function index(){
        return view('control_presupuesto.cambio_presupuesto.index')
            ->with('max_niveles', $this->presupuesto->getMaxNiveles())
            ->with('operadores', $this->operadores);
    }

    public function  create(){
        return view('control_presupuesto.cambio_presupuesto.create')
            ->with('operadores', $this->operadores);
    }

    public function getPaths(Request $request){

        $baseDatos=$this->basePresupuesto->findBy($request->all()['baseDatos']);
        $conceptos =  $this->concepto->paths($request->all(),$baseDatos[0]->base_datos);

        return response()->json([
            'recordsTotal' => $conceptos->total(),
            'recordsFiltered' => $conceptos->total(),
            'data' => $conceptos->items()
        ], 200);

    }
}
