<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\RevaluacionRepository;
use Ghi\Domain\Core\Contracts\Contabilidad\FacturaRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class RevaluacionesController extends Controller
{

    use Helpers;

    private $revaluacion;
    private $factura;

    /**
     * RevaluacionesController constructor.
     */
    public function __construct(RevaluacionRepository $revaluacion, FacturaRepository $factura)
    {
        $this->middleware('auth');
        $this->middleware('context');

        $this->revaluacion = $revaluacion;
        $this->factura = $factura;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $revaluaciones = $this->revaluacion->all();
        return view('sistema_contable.modulos.revaluacion.index')
            ->with('revaluaciones', $revaluaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $facturas = $this->factura->getFacturasPorRevaluar();
        $tipo_cambio= $this->revaluacion->getTipoCambio();

        return view('sistema_contable.modulos.revaluacion.create')
            ->with('facturas', $facturas)
            ->with('tipo_cambio', $tipo_cambio);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $revaluacion = $this->revaluacion->create($request->all());
        return $this->response->created(route('sistema_contable.revaluacion.show', $revaluacion));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $revaluacion = $this->revaluacion->find($id);
        dd('show',$revaluacion);
    }
}
