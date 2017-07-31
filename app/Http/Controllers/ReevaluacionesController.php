<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ReevaluacionRepository;
use Illuminate\Http\Request;

use Ghi\Http\Requests;

class ReevaluacionesController extends Controller
{

    use Helpers;

    private $reevaluacion;
    /**
     * ReevaluacionesController constructor.
     */
    public function __construct(ReevaluacionRepository $reevaluacion)
    {
        $this->middleware('auth');
        $this->middleware('context');

        $this->reevaluacion = $reevaluacion;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reevaluaciones = $this->reevaluacion->all();
        return view('sistema_contable.modulos.reevaluaciones.index')
            ->with('reevaluaciones', $reevaluaciones);
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
