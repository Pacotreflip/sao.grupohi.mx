<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Repositories\EloquentFondoRepository;
use Illuminate\Http\Request;
use Ghi\Domain\Core\Contracts\Finanzas\ComprobanteFondoFijoRepository;

class ComprobanteFondoFijoController extends Controller
{

    use Helpers;
    protected $comprobante_fondo_fijo;
    protected $eloquentFondoRepository;

    /**
     * ComprobanteFondoFijoController constructor.
     */
    public function __construct(ComprobanteFondoFijoRepository $comprobante_fondo_fijo, EloquentFondoRepository $eloquentFondoRepository)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');
        $this->comprobante_fondo_fijo = $comprobante_fondo_fijo;
        $this->eloquentFondoRepository = $eloquentFondoRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->comprobante_fondo_fijo->all();

        return view("finanzas.comprobante_fondo_fijo.index")
            ->with("comprobantes_fondo_fijo", $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $fondos = $this->eloquentFondoRepository->lists();


        return view("finanzas.comprobante_fondo_fijo.create")
            ->with("fondos",$fondos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
