<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Transformers\ConceptoTreeTransformer;
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

    protected $concepto;
    /**
     * ConceptoController constructor.
     * @param ConceptoRepository $concepto
     */
    public function __construct(ConceptoRepository $concepto)
    {
        parent::__construct();

//        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
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

    public function find(Request $request)
    {
        $filtros = $request->all();
        $string = "";
        $counter = 0;

        foreach ($filtros as $k => $v)
        {
            // @todo agregar soporte para operador OR
             $string .= ($counter = 0 ? "" : "AND") . " ";

             $nivel = filter_var($v['nivel'], FILTER_SANITIZE_NUMBER_INT);
             $operador = $v['operador'];

            // Like o condicionante?
            $texto = strpos($operador, '=') ? ($operador . " ". $texto) : ("LIKE '". str_replace('{texto}', $v['texto'], $operador). "'");

            $string .= "LEN(nivel)/4 = ". $nivel ." AND descripcion ". $texto;

            $counter++;
        }

        $resultados = $this->concepto->buscarRaw($string);

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