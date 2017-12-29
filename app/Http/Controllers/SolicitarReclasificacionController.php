<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitarReclasificacionesRepository;
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
     * SolicitarReclasificacionController constructor.
     * @param Concepto|ConceptoRepository $concepto
     * @param ConceptoPathRepository $conceptoPath
     * @param SolicitarReclasificacionesRepository $solicitar
     * @param TransaccionRepository $transaccion
     * @internal param TransaccionRepository $trasaccion
     */
    public function __construct(ConceptoRepository $concepto, ConceptoPathRepository $conceptoPath, SolicitarReclasificacionesRepository $solicitar, TransaccionRepository $transaccion)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
        $this->conceptoPath = $conceptoPath;
        $this->solicitar = $solicitar;
        $this->transaccion = $transaccion;
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
        $record = $this->solicitar->create($request->all());

        return response()->json(['data' =>
            [
                'solicitud' => $record
            ]
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
        $detallesRaw = $this->transaccion->detallesTransacciones($id_concepto);
        $detalles = [];

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


        return view('control_costos.solicitar_reclasificacion.items')
            ->with('data_view', [
                'items' => $items,
                'id_transaccion' => $request->id,
                'titulo' => $titulo,
                'max_niveles' => $this->concepto->obtenerMaxNumNiveles(),
                'operadores' => $this->operadores,
                'id_concepto' => $request->id_concepto,
            ]);
    }
}