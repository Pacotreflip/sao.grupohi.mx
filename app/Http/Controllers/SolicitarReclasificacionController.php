<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoPathRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitarReclasificacionesRepository;

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
     */
    public function __construct(ConceptoRepository $concepto, ConceptoPathRepository $conceptoPath, SolicitarReclasificacionesRepository $solicitar)
    {
        parent::__construct();

//        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
        $this->conceptoPath = $conceptoPath;
        $this->solicitar = $solicitar;
    }

    public function index(Request $request)
    {
        $data_view = [
            'max_niveles' => $this->concepto->obtenerMaxNumNiveles(),
            'operadores' => $this->operadores,
        ];

        return view('control_costos.solicitar_reclasificacion.index')
            ->with('data_view', $data_view);
    }

    public function store(Request $request)
    {
        $record = $this->solicitar->create($request->all());

        return response()->json(['data' =>
            [
                'solicitud' => $record
            ]
        ], 200);
    }

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

//        dd($string);die;

        return response()->json(['data' => ['resultados' => $resultados]], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findBy(Request $request)
    {
        $item = $this->concepto->findBy($request->attribute, $request->value, $request->with);
        return response()->json(['data' => ['concepto' => $item]], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBy(Request $request) {
        $items = $this->concepto->getBy($request->attribute, $request->operator, $request->value, $request->with);
        return response()->json(['data' => ['conceptos' => $items]], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function getRoot()
    {
        $roots = $this->concepto->getRootLevels();
        $resp=ConceptoTreeTransformer::transform($roots);
        return response()->json($resp, 200);

    }

    public function getNode($id)
    {
        $node = $this->concepto->getDescendantsOf($id);


        $resp=ConceptoTreeTransformer::transform($node);

        // $data = Fractal::createData($resource);
        return response()->json($resp, 200);

    }
}