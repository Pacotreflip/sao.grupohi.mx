<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Reportes\ControlPresupuesto\PDFSolicitudCambioInsumos;
use Illuminate\Http\Request;


class CambioInsumosController extends Controller
{
    use Helpers;

    private $presupuesto;
    private $concepto;
    private $basePresupuesto;
    private $cambio_insumos;
    private $partidas;
    private $afectacion;
    private $agrupacion;
    private $solicitud;

    public function __construct(PresupuestoRepository $presupuesto, ConceptoRepository $concepto, BasePresupuestoRepository $basePresupuesto, CambioInsumosRepository $cambio_insumos, SolicitudCambioPartidaRepository $partidas, AfectacionOrdenPresupuestoRepository $afectacion, PartidasInsumosAgrupadosRepository $agrupacion,SolicitudCambioRepository $solicitud)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');


        //Permisos
        //$this->middleware('permission:consultar_cambio_insumos', ['only' => ['index', 'paginate', 'pdf', 'show']]);
        //$this->middleware('permission:registrar_cambio_insumos', ['only' => ['create', 'store']]);
        //$this->middleware('permission:autorizar_cambio_insumos', ['only' => ['autorizar']]);
        //$this->middleware('permission:aplicar_cambio_insumos', ['only' => ['aplicar']]);
        //$this->middleware('permission:rechazar_cambio_insumos', ['only' => ['rechazar']]);

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto = $basePresupuesto;
        $this->concepto = $concepto;
        $this->cambio_insumos = $cambio_insumos;
        $this->partidas = $partidas;
        $this->afectacion = $afectacion;
        $this->agrupacion = $agrupacion;
        $this->solicitud = $solicitud;
    }

    public function index()
    {
        return view('control_presupuesto.cambio_presupuesto.cambio_insumos.index');
    }

    public function paginate(Request $request)
    {
        $solicitud = $this->cambio_insumos->paginate($request->all());

        return response()->json([
            'recordsTotal' => $solicitud->total(),
            'recordsFiltered' => $solicitud->total(),
            'data' => $solicitud->items()
        ], 200);
    }

    public function create()
    {
        $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden', '=', TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS);

        return view('control_presupuesto.cambio_insumos.create')
            ->with('tipo_orden', TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS)
            ->with('presupuestos', $presupuestos);
    }

    public function getPaths(Request $request)
    {
        $baseDatos = $this->basePresupuesto->findBy($request->baseDatos);
        $conceptos = $this->concepto->paths($request->all(), $baseDatos[0]->base_datos);

        return response()->json([
            'recordsTotal' => $conceptos->total(),
            'recordsFiltered' => $conceptos->total(),
            'data' => $conceptos->items()
        ], 200);
    }

    public function store(Request $request)
    {
        $solicitud = $this->cambio_insumos->create($request->all());

        return $this->response->item($solicitud, function ($item) {
            return $item;
        });


    }

    public function pdf(Request $request, $id)
    {
        $solicitud = $this->solicitud->with(['aplicaciones', 'tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto',
            'partidas.numeroTarjeta', 'partidas.historico'])->find($id);
        $pdf = new PDFSolicitudCambioInsumos($solicitud, $this->partidas, $this->agrupacion);
        if (is_object($pdf))
            $pdf->create();
    }

    public function show($id)
    {
        $solicitud = SolicitudCambio::with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto',
            'partidas.numeroTarjeta', 'aplicaciones'])->find($id);
        $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden', '=', $solicitud->id_tipo_orden);
        $conceptos_agrupados = $this->agrupacion->with('concepto')->where([['id_solicitud_cambio', '=', $solicitud->id]])->all();
        $conceptos_agrupados = $this->partidas->getTotalesClasificacionInsumos($conceptos_agrupados->toArray());
        $solicitud = SolicitudCambio::with(['tipoOrden', 'userRegistro', 'estatus'])->find($id);
        return view('control_presupuesto.cambio_insumos.show')
            ->with('solicitud', $solicitud)
            ->with('cobrabilidad', $solicitud->tipoOrden->cobrabilidad)
            ->with('presupuestos', $presupuestos)
            ->with('conceptos_agrupados', $conceptos_agrupados);

    }

    public function autorizar(Request $request)
    {

        $solicitud = $this->cambio_insumos->autorizar($request->id, $request->all());
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });

    }

    public function rechazar(Request $request)
    {
        $solicitud = $this->cambio_insumos->rechazar($request->all());
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    public function aplicar(Request $request)
    {

    }
}
