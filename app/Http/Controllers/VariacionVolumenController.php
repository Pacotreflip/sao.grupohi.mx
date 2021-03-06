<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\VariacionVolumenRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\VariacionVolumen;
use Ghi\Domain\Core\Formatos\ControlPresupuesto\PDFVariacionVolumen;
use Illuminate\Http\Request;


class VariacionVolumenController extends Controller
{
    use Helpers;

    private $presupuesto;
    private $concepto;
    private $basePresupuesto;
    private $variacionVolumen;
    private $partidas;
    private $afectacion;

    public function __construct(PresupuestoRepository $presupuesto, ConceptoRepository $concepto, BasePresupuestoRepository $basePresupuesto, VariacionVolumenRepository $variacionVolumen, SolicitudCambioPartidaRepository $partidas, AfectacionOrdenPresupuestoRepository $afectacion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        //Permisos
        $this->middleware('permission:consultar_variacion_volumen', ['only' => ['index', 'paginate', 'pdf', 'show']]);
        $this->middleware('permission:registrar_variacion_volumen', ['only' => ['create', 'store']]);
        $this->middleware('permission:autorizar_variacion_volumen', ['only' => ['autorizar']]);
        $this->middleware('permission:aplicar_variacion_volumen', ['only' => ['aplicar']]);
        $this->middleware('permission:rechazar_variacion_volumen', ['only' => ['rechazar']]);

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto = $basePresupuesto;
        $this->concepto = $concepto;
        $this->variacionVolumen = $variacionVolumen;
        $this->partidas = $partidas;
        $this->afectacion = $afectacion;
    }

    public function index()
    {
        return view('control_presupuesto.cambio_presupuesto.variacion_volumen.index');
    }

    public function paginate(Request $request)
    {
        $variacionesVolumen = $this->variacionVolumen->paginate($request->all());

        return response()->json([
            'recordsTotal' => $variacionesVolumen->total(),
            'recordsFiltered' => $variacionesVolumen->total(),
            'data' => $variacionesVolumen->items()
        ], 200);
    }

    public function create()
    {
        return view('control_presupuesto.variacion_volumen.create');
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
        $conceptos_ids = [];
        $repetidas = false;

        foreach ($request->partidas as $p)
            $conceptos_ids[] = $p['id_concepto'];

        $repetidas = VariacionVolumen::whereHas('partidas', function ($query) use ($conceptos_ids) {
            $query->whereIn('id_concepto', $conceptos_ids);
        })
            ->where(function ($q) {
                $q->where('id_estatus', '=', Estatus::GENERADA)
                    ->orWhere(function ($query){
                        $query
                            ->has('aplicacionesPendientes', '>', 0)
                            ->where('id_estatus', '=', Estatus::AUTORIZADA);
                    });
            })
            ->get();

        if (!$repetidas->isEmpty())
            return response()->json(
                [
                    'repetidas' => $repetidas
                ], 200);

        $variacionVolumen = $this->variacionVolumen->create($request->all());

        return $this->response->item($variacionVolumen, function ($item) {
            return $item;
        });
    }

    public function pdf(Request $request, $id)
    {
        $variacionVolumen = $this->variacionVolumen->with(['aplicaciones', 'tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($id);

        $pdf = new PDFVariacionVolumen($variacionVolumen, $this->partidas);

        if (is_object($pdf))
            $pdf->create();
    }

    public function show($id)
    {
        $variacionVolumen = VariacionVolumen::with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta', 'aplicaciones'])->find($id);
        $presupuestos = $this->afectacion->with('baseDatos')->getBy('id_tipo_orden', '=', $variacionVolumen->id_tipo_orden);

        return view('control_presupuesto.variacion_volumen.show')
            ->with('variacion_volumen', $variacionVolumen)
            ->with('cobrabilidad', $variacionVolumen->tipoOrden)
            ->with('presupuestos', $presupuestos);
    }

    public function autorizar(Request $request, $variacion_volumen)
    {
        $variacionVolumen = $this->variacionVolumen->autorizar($variacion_volumen, $request->all());

        return $this->response->item($variacionVolumen, function ($item) {
            return $item;
        });
    }

    public function rechazar(Request $request, $variacion_volumen)
    {
        $variacionVolumen = $this->variacionVolumen->rechazar($variacion_volumen, $request->all());

        return $this->response->item($variacionVolumen, function ($item) {
            return $item;
        });
    }

    public function getBasesAfectadas() {
        $bases = $this->variacionVolumen->getBasesAfectadas();
        return $this->response->collection($bases, function ($item) { return $item; });
    }

    public function aplicar(Request $request, $id)
    {
        $variacion_volumen = $this->variacionVolumen->aplicar(VariacionVolumen::find($id), $request->afectaciones);

        return $this->response->item($variacion_volumen, function ($item) { return $item; });
    }
}
