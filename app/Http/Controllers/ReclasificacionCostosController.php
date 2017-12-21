<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;


use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlCostos\SolicitarReclasificacionesRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Transacciones\Transaccion;
use Ghi\Domain\Core\Transformers\ConceptoTreeTransformer;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;

class ReclasificacionCostosController extends Controller
{
    use Helpers;

    protected $concepto;
    /**
     * @var SolicitarReclasificacionesRepository
     */
    private $solicitar;

    /**
     * ConceptoController constructor.
     * @param ConceptoRepository $concepto
     * @param Transaccion $transaccion
     */
    public function __construct(ConceptoRepository $concepto, Transaccion $transaccion, SolicitarReclasificacionesRepository $solicitar)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->concepto = $concepto;
        $this->transaccion = $transaccion;
        $this->solicitar = $solicitar;
    }

    public function index(Request $request)
    {
        $solicitudes = $this->solicitar->all();

        foreach ($solicitudes as $k => $s)
        {
            $solicitudes[$k]['transacciones'] = $this->transaccion->reclasificacion($s->id_concepto);
        }

        $dataView = [
            'solicitudes' => $solicitudes,
        ];

        return view('control_costos.reclasificacion_costos.index')
            ->with('dataView', $dataView);
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