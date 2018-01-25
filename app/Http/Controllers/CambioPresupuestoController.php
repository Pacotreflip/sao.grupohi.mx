<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Reportes\ControlPresupuesto\PDFSolicitudCambio;
use Illuminate\Http\Request;


class CambioPresupuestoController extends Controller
{
    use Helpers;
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
    private $solicitud;

    public function __construct(PresupuestoRepository $presupuesto, ConceptoRepository $concepto, BasePresupuestoRepository $basePresupuesto, SolicitudCambioRepository $solicitud)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto = $basePresupuesto;
        $this->concepto = $concepto;
        $this->solicitud = $solicitud;
    }

    public function index()
    {
        return view('control_presupuesto.cambio_presupuesto.index');
    }

    public function paginate(Request $request)
    {
        $solicitudes = $this->solicitud->paginate($request->all());
        return response()->json([
            'recordsTotal' => $solicitudes->total(),
            'recordsFiltered' => $solicitudes->total(),
            'data' => $solicitudes->items()
        ], 200);
    }

    public function create()
    {
        return view('control_presupuesto.cambio_presupuesto.create')
            ->with('operadores', $this->operadores);
    }

    public function getPaths(Request $request)
    {

        $baseDatos = $this->basePresupuesto->findBy($request->all()['baseDatos']);
        $conceptos = $this->concepto->paths($request->all(), $baseDatos[0]->base_datos);

        return response()->json([
            'recordsTotal' => $conceptos->total(),
            'recordsFiltered' => $conceptos->total(),
            'data' => $conceptos->items()
        ], 200);
    }

    public function store(Request $request)
    {
        $solicitud = '';
        switch ($request->id_tipo_orden) {
            case TipoOrden::ESCALATORIA:
                break;
            case TipoOrden::RECLAMOS_INDIRECTO:
                break;
            case TipoOrden::CONCEPTOS_EXTRAORDINARIOS:
                break;
            case TipoOrden::VARIACION_VOLUMEN:
                $solicitud = $this->solicitud->saveVariacionVolumen($request->all());
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_NO_COBRABLE:
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS:
                break;
        }
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });

    }

    public  function pdf(Request $request, $id)
    {
        $solicitud = $this->solicitud->find($id);

        $pdf = new PDFSolicitudCambio($solicitud);
        $pdf->create();
    }
}
