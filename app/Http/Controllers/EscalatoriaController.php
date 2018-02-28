<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\EscalatoriaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\Escalatoria;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Formatos\ControlPresupuesto\PDFSolicitudCambioEscalatoria;
use Illuminate\Http\Request;


class EscalatoriaController extends Controller
{
    use Helpers;

    private $presupuesto;
    private $concepto;
    private $basePresupuesto;
    private $escalatoria;
    private $partidas;
    private $afectacion;

    public function __construct(PresupuestoRepository $presupuesto, ConceptoRepository $concepto, BasePresupuestoRepository $basePresupuesto, EscalatoriaRepository $escalatoria, SolicitudCambioPartidaRepository $partidas, AfectacionOrdenPresupuestoRepository $afectacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        //Permisos
        $this->middleware('permission:consultar_escalatoria', ['only' => ['index', 'paginate', 'pdf', 'show']]);
        $this->middleware('permission:registrar_escalatoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:autorizar_escalatoria', ['only' => ['autorizar']]);
        $this->middleware('permission:aplicar_escalatoria', ['only' => ['aplicar']]);
        $this->middleware('permission:rechazar_escalatoria', ['only' => ['rechazar']]);

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto = $basePresupuesto;
        $this->concepto = $concepto;
        $this->escalatoria = $escalatoria;
        $this->partidas = $partidas;
        $this->afectacion = $afectacion;
    }

    public function index()
    {
        return view('control_presupuesto.cambio_presupuesto.escalatoria.index');
    }

    public function paginate(Request $request)
    {
        $variacionesVolumen = $this->escalatoria->paginate($request->all());

        return response()->json([
            'recordsTotal' => $variacionesVolumen->total(),
            'recordsFiltered' => $variacionesVolumen->total(),
            'data' => $variacionesVolumen->items()
        ], 200);
    }

    public function create()
    {
        $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden','=', TipoOrden::ESCALATORIA);

        return view('control_presupuesto.escalatoria.create')
            ->with('tipo_orden', TipoOrden::ESCALATORIA)
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
        $escalatoria = $this->escalatoria->create($request->all());

        return $this->response->item($escalatoria, function ($item) {
            return $item;
        });
    }

    public function pdf(Request $request, $id)
    {
        $escalatoria = $this->escalatoria->with(['aplicaciones', 'tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($id);

        $pdf = new PDFSolicitudCambioEscalatoria($escalatoria, $this->partidas);

        if (is_object($pdf))
            $pdf->create();
    }

    public function show($id)
    {
        $escalatoria = Escalatoria::with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta', 'aplicaciones'])->find($id);
        $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden', '=', $escalatoria->id_tipo_orden);

        $aplicadaTitulo =' ('. (!$escalatoria->aplicada ? 'no ' : '') .'Aplicada)';

        return view('control_presupuesto.escalatoria.show')
            ->with('solicitud', $escalatoria)
            ->with('cobrabilidad', $escalatoria->tipoOrden->cobrabilidad)
            ->with('presupuestos', $presupuestos)
            ->with('aplicadaTitulo', $aplicadaTitulo);
    }

    public function autorizar(Request $request)
    {
        $escalatoria = $this->escalatoria->autorizar($request->id, $request->all());

        return $this->response->item($escalatoria, function ($item) {
            return $item;
        });
    }

    public function rechazar(Request $request)
    {
        $escalatoria = $this->escalatoria->rechazar($request->all());

        return $this->response->item($escalatoria, function ($item) {
            return $item;
        });
    }

    public function aplicar(Request $request)
    {

    }
}
