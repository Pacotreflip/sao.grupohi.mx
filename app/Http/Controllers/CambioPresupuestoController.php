<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
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
    private $partidas;
    private $afectacion;
    private $agrupacion;

    public function __construct(PresupuestoRepository $presupuesto, ConceptoRepository $concepto, BasePresupuestoRepository $basePresupuesto, SolicitudCambioRepository $solicitud, SolicitudCambioPartidaRepository $partidas, AfectacionOrdenPresupuestoRepository $afectacion, PartidasInsumosAgrupadosRepository $agrupacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto = $basePresupuesto;
        $this->concepto = $concepto;
        $this->solicitud = $solicitud;
        $this->partidas = $partidas;
        $this->afectacion = $afectacion;
        $this->agrupacion = $agrupacion;
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
                $solicitud = $this->solicitud->saveEscalatoria($request->all());
                break;
            case TipoOrden::RECLAMOS_INDIRECTO:
                break;
            case TipoOrden::CONCEPTOS_EXTRAORDINARIOS:
                break;
            case TipoOrden::VARIACION_VOLUMEN:
                // Revisa si ya existe una solicitud con al menos una partida ya seleccionada
                $conceptos_ids = [];
                $repetidas = false;

                foreach ($request->partidas as $p)
                    $conceptos_ids[] = $p['id_concepto'];

                $repetidas = SolicitudCambio::whereHas('partidas', function ($query) use ($conceptos_ids) {
                    $query->whereIn('id_concepto', $conceptos_ids);
                })->where('id_estatus', '=', Estatus::GENERADA)->get();

                if (!$repetidas->isEmpty())
                    return response()->json(
                        [
                            'repetidas' => $repetidas
                        ], 200);

                $solicitud = $this->solicitud->saveVariacionVolumen($request->all());
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_NO_COBRABLE:
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS:
                $solicitud = $this->solicitud->saveCambioInsumos($request->all());
                dd($solicitud);
                break;
        }
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });

    }

    public function pdf(Request $request, $id)
    {
        $solicitud = $this->solicitud->find($id);

        $pdf = new PDFSolicitudCambio($solicitud, $this->partidas);
        $pdf->create();
    }

    public function show($id)
    {
        $solicitud = $this->solicitud->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($id);
        $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden', '=', $solicitud->id_tipo_orden);

        switch ($solicitud->id_tipo_orden) {
            case TipoOrden::ESCALATORIA:
                break;
            case TipoOrden::RECLAMOS_INDIRECTO:
                break;
            case TipoOrden::CONCEPTOS_EXTRAORDINARIOS:
                break;
            case TipoOrden::VARIACION_VOLUMEN:
                return view('control_presupuesto.cambio_presupuesto.show.variacion_volumen')
                    ->with('solicitud', $solicitud)
                    ->with('cobrabilidad', $solicitud->tipoOrden)
                    ->with('presupuestos', $presupuestos);
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_NO_COBRABLE:
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS:

              //  $clasificacion = $this->partidas->getClasificacionInsumos($solicitud->id);
                $conceptos_agrupados = $this->agrupacion->with('concepto')->where([['id_solicitud_cambio', '=', $solicitud->id]])->all();
                return view('control_presupuesto.cambio_presupuesto.show.cambio_insumos')
                    ->with('solicitud', $solicitud)
                    ->with('cobrabilidad', $solicitud->tipoOrden->cobrabilidad)
                    ->with('presupuestos', $presupuestos)
                    ->with('conceptos_agrupados',$conceptos_agrupados);
                break;
        }


    }


    public function autorizarSolicitud(Request $request)
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
                $solicitud = $this->solicitud->autorizarVariacionVolumen($request->id);
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

    public function rechazarSolicitud(Request $request)
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
                $solicitud = $this->solicitud->rechazarVariacionVolumen($request->all());
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
}
