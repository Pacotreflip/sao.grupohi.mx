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
        'igual a' => '=',
        'diferente de' => '!=',
        'empieza con' => '{texto}%',
        'termina con' => '%{texto}',
        'contiene' => '%{texto}%'
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

//        $this->middleware('auth');
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
    public function find(Request $request)
    {
        $filtros = json_decode($request->data, true);
        $string = "";
        $niveles = [];
        $string = '';

        foreach ($filtros as $k => $v)
            foreach ($filtros as $k => $v)
            {
                $o = $this->operadores[$v['operador']];

                if (strpos($o, '=') !== false)
                    $operador = $o . " '" . $v['texto'] . "'";

                else
                    $operador = "LIKE '". str_replace('{texto}', $v['texto'], $o). "'";

                $nivel = filter_var($v['nivel'], FILTER_SANITIZE_NUMBER_INT);

                //Si existe
                if (in_array( $nivel, array_keys($niveles)))
                {
                    $niveles[ $nivel] .= ' OR filtro'. $nivel ." ". $operador;
                }

                else
                {
                    $niveles[ $nivel] = " filtro". $nivel ." ". $operador;
                }

            }

        $endValue = end($niveles);
        $end = key($niveles);
        $count = 0;

        foreach ($niveles as $nivel => $cadena)
        {
            $string .= ($count == 0 ? "" : " and") . "(". $cadena .")";
            $count++;
        }

        $resultados = $this->conceptoPath->buscarCostoTotal($string);

        return response()->json(['data' => ['resultados' => $resultados]], 200);
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

            if (!isset($detalles[$tipo]))
                $detalles[$tipo] = [
                    'total_transacciones' => 0,
                    'monto_total' => 0,
                    'transacciones' => [],
                ];

            $detalles[$tipo]['total_transacciones']++;
            $detalles[$tipo]['monto_total'] = $detalles[$tipo]['monto_total'] + $r['monto'];
            $detalles[$tipo]['transacciones'][] = $r;
        }

        return response()->json([
            'resumen' => $resumen,
            'detalles' => $detalles,
        ], 200);
    }

    public function items(Request $request)
    {
        $items = $this->transaccion->items($request->id);
        $titulo = !empty($items[0]) ? $items[0]['observaciones'] : '';


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