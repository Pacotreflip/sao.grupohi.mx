<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\RevaluacionRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class RevaluacionesController extends Controller
{

    use Helpers;

    private $revaluacion;
    /**
     * RevaluacionesController constructor.
     */
    public function __construct(RevaluacionRepository $revaluacion)
    {
        $this->middleware('auth');
        $this->middleware('context');

        $this->revaluacion = $revaluacion;
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
            ->with('revaluacion', $revaluaciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
