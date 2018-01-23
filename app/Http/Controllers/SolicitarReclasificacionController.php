<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionPartidasRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
use Ghi\Domain\Core\Contracts\TransaccionRepository;
use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Http\Request;

class SolicitarReclasificacionController extends Controller
{
    use Helpers;
    protected $operadores = [
        'igual a' => "= '{texto}'",
        'diferente de' => "!= '{texto}'",
        'empieza con' => "LIKE '{texto}%'",
        'termina con' => "LIKE '%{texto}'",
        'contiene' => "LIKE '%{texto}%'"
    ];
    protected $condicionantes = [
        'Y' => 'AND',
        'O' => 'OR',
    ];
    /**
     * @var SolicitudReclasificacionRepository
     */
    private $solicitud;

    /**
     * SolicitarReclasificacionController constructor.
     * @param Concepto|ConceptoRepository $concepto
     * @param ConceptoPathRepository $conceptoPath
     * @param SolicitarReclasificacionesRepository $solicitar
     * @param TransaccionRepository $transaccion
     * @internal param TransaccionRepository $trasaccion
     */
    public function __construct(ConceptoRepository $concepto, ConceptoPathRepository $conceptoPath, TransaccionRepository $transaccion, SolicitudReclasificacionRepository $solicitud, SolicitudReclasificacionPartidasRepository $partidas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        // Permisos
        $this->middleware('permission:solicitar_reclasificacion', ['only' => ['index', 'findmovimiento', 'find', 'tipos', 'items', 'store', 'single']]);
        $this->middleware('permission:consultar_reclasificacion', ['only' => ['index', 'findmovimiento', 'find', 'tipos', 'items', 'single']]);

        $this->concepto = $concepto;
        $this->conceptoPath = $conceptoPath;
        $this->transaccion = $transaccion;
        $this->solicitud = $solicitud;
        $this->partidas = $partidas;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $data_view = [
            'max_niveles' => $this->concepto->obtenerMaxNumNiveles(),
            'operadores' => $this->operadores,
            'tipos_transacciones' => $this->transaccion->selectTipos(),
        ];

        return view('control_costos.solicitar_reclasificacion.index')
            ->with('data_view', $data_view);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $motivo = htmlentities($request->motivo, ENT_QUOTES);
        $partidas = $request->solicitudes;
        $where = '';
        $counter = 1;
        $total = count($partidas);

        // Revisa si ya existe una solicitud pendiente con al menos un movimiento previamente usado
        foreach ($partidas as $p)
        {
            $where .= ' ControlCostos.solicitud_reclasificacion_partidas.id_item = '. $p['id_item'] . (($counter != $total) ? ' or ': ' ');
            $counter++;
        }

        $repetidas = $this->partidas->validarPartidas($where)->toArray();

        if (!empty($repetidas))
            return response()->json(
                [
                    'repetidas' => $repetidas
                ], 200);

        $solicitud  = $this->solicitud->create(['motivo' => $motivo, 'fecha' => $request->fecha]);

        if (!empty($solicitud))
            foreach ($partidas as $p)
                $this->partidas->create([
                    'id_solicitud_reclasificacion' => $solicitud->id,
                    'id_item' => $p['id_item'],
                    'id_concepto_original' => $p['id_concepto'],
                    'id_concepto_nuevo' => $p['id_concepto_nuevo']
                ]);

        return response()->json(
            [
                'solicitud' => $solicitud,
                'repetidas' => false,
            ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findmovimiento(Request $request)
    {
        $filtros = json_decode($request->data, true);
        $string = "";
        $niveles = [];
        $string = '';

        foreach ($filtros as $k => $v)
        {
            $o = $this->operadores[$v['operador']];
            $operador = str_replace('{texto}', $v['texto'], $o);
            $nivel = filter_var($v['nivel'], FILTER_SANITIZE_NUMBER_INT);

            //Si existe
            if (in_array( $nivel, array_keys($niveles)))
                $niveles[ $nivel] .= ' OR filtro'. $nivel ." ". $operador;

            else
                $niveles[ $nivel] = " filtro". $nivel ." ". $operador;

        }

        $endValue = end($niveles);
        $end = key($niveles);
        $count = 0;

        foreach ($niveles as $nivel => $cadena)
        {
            $string .= ($count == 0 ? "" : " and") . "(". $cadena .")";
            $count++;
        }

        $resultados = $this->conceptoPath->filtrarConMovimiento($string);
        $r = [];

        foreach ($resultados->toArray() as $k => $v)
            $r[$k] = array_filter($v);

        return response()->json(['data' => ['resultados' => $r]], 200);
    }

    public function findtransaccion(Request $request)
    {
        $filtros = json_decode($request->data, true);
        $where = [];
        list($where['tipo'], $where['opciones']) = explode ('-', $filtros['tipo']);

        if (!empty($filtros['folio']))
            $where['folio'] = filter_var($filtros['folio'], FILTER_SANITIZE_NUMBER_INT);

        $resultados = $this->transaccion->filtrarTipos($where);
        $resumen = $this->transaccion->filtrarTiposTransaccion($where);
        $detalles = [];

        foreach ($resumen as $k => $v)
        {
            $tipo = $v['descripcion'] == null ? '-' : $v['descripcion'];
            $resumen[$k]['descripcion'] = $tipo;
        }

        foreach ($resultados as $k => $r)
        {
            $tipo = $r['descripcion'] == null ? '-' : $r['descripcion'];

            if (!isset($detalles[$r['id_transaccion']]))
                $detalles[$k] = [
                    'total_transacciones' => 0,
                    'importe' => 0,
                    'transacciones' => [],
                    'descripcion' => $tipo,
                    'fecha' => $r['fecha']->format('Y/M/d'),
                    'numero_folio' => $r['numero_folio'],
                    'id_transaccion' => $r['id_transaccion'],
                    'id_concepto' => $r['id_concepto'],
                    'monto' => $r['monto']
                ];

            if (!empty($detalles[$k]))
            {
                $detalles[$k]['total_transacciones']++;
                $detalles[$k]['importe'] = $detalles[$k]['importe'] + $r['monto'];
                $detalles[$k]['transacciones'][] = $r;
            }
        }

        return response()->json([
            'detalles' => $detalles,
            'resumen' => $resumen
        ], 200);
    }

    public function find(Request $request)
    {
        $filtros = json_decode($request->data, true);
        $string = "";
        $niveles = [];
        $string = '';

        foreach ($filtros as $k => $v)
        {
            $o = $this->operadores[$v['operador']];
            $operador = str_replace('{texto}', $v['texto'], $o);
            $nivel = filter_var($v['nivel'], FILTER_SANITIZE_NUMBER_INT);

            //Si existe
            if (in_array( $nivel, array_keys($niveles)))
                $niveles[ $nivel] .= ' OR filtro'. $nivel ." ". $operador;

            else
                $niveles[ $nivel] = " filtro". $nivel ." ". $operador;
        }

        $endValue = end($niveles);
        $end = key($niveles);
        $count = 0;

        foreach ($niveles as $nivel => $cadena)
        {
            $string .= ($count == 0 ? "" : " and") . "(". $cadena ." and len(nivel) / 4 = ". $nivel .")";
            $count++;
        }

        $resultados = $this->conceptoPath->filtrar($string);
        $r = [];

        foreach ($resultados->toArray() as $k => $v)
            $r[$k] = array_filter($v);

        return response()->json(['data' => ['resultados' => $r]], 200);
    }

    public function tipos(Request $request)
    {
        $id_concepto = $request->id_concepto;

        $resumen = $this->transaccion->tiposTransaccion($id_concepto);
        $detalles = $this->transaccion->detallesTransacciones($id_concepto);
        $detallesRaw = [];

        foreach ($resumen as $k => $v)
        {
            $tipo = $v['descripcion'] == null ? '-' : $v['descripcion'];
            $resumen[$k]['descripcion'] = $tipo;
        }

        foreach ($detallesRaw as $r)
        {
            $tipo = $r['descripcion'] == null ? '-' : $r['descripcion'];

            if (!isset($detalles[$r['id_transaccion']]))
                $detalles[$r['id_transaccion']] = [
                    'total_transacciones' => 0,
                    'importe' => 0,
                    'transacciones' => [],
                    'descripcion' => $tipo,
                    'fecha' => $r['fecha'],
                    'folio' => $r['numero_folio'],
                    'id_transaccion' => $r['id_transaccion'],
                    'id_concepto' => $r['id_concepto'],
                ];

            $detalles[$r['id_transaccion']]['total_transacciones']++;
            $detalles[$r['id_transaccion']]['importe'] = $detalles[$r['id_transaccion']]['importe'] + $r['monto'];
            $detalles[$r['id_transaccion']]['transacciones'][] = $r;
        }

        return response()->json([
            'resumen' => $resumen,
            'detalles' => $detalles,
        ], 200);
    }

    public function items(Request $request)
    {
        $items = $this->transaccion->items($request->id);
        $titulo = '';
        $detalles = $this->transaccion->detallesTransacciones($request->id_concepto);
        $transaccion = [];

        foreach ($items as $k => $i)
            $items[$k]['concepto'] = Concepto::where('id_concepto', '=', $i['id_concepto'])->first();

        foreach ($detalles as $d)
            if ($d['id_transaccion'] == $request->id)
            {
                $transaccion = $d;
                break;
            }

        return view('control_costos.solicitar_reclasificacion.items')
            ->with('data_view', [
                'items' => $items,
                'id_transaccion' => $request->id,
                'titulo' => $titulo,
                'max_niveles' => $this->concepto->obtenerMaxNumNiveles(),
                'operadores' => $this->operadores,
                'id_concepto' => $request->id_concepto,
                'transaccion' => $transaccion,
            ]);
    }

    public function single(Request$request)
    {
        $solicitud = $this->solicitud->find($request->id)
            ->with(['autorizacion.usuario', 'rechazo.usuario', 'usuario', 'estatusString', 'partidas.item.material', 'partidas.item.transaccion', 'partidas.conceptoNuevo', 'partidas.conceptoOriginal'])
            ->select('ControlCostos.solicitud_reclasificacion.*')
            ->where('id', $request->id)
            ->first();

        return response()->json([
            'solicitud' => $solicitud,
        ], 200);
    }
}