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
        $facturas = $this->factura->scope('porRevaluar')->all();
        return view('sistema_contable.modulos.revaluacion.create')
            ->with('facturas', $facturas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
