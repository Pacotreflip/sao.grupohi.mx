<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\CostosDolaresRepository;
use Ghi\Domain\Core\Reportes\CostosDolares\CostosDolaresPDF;
use Ghi\Domain\Core\Reportes\CostosDolares\CostosDolaresXLS;
use Illuminate\Http\Request;

class CostosDolaresController extends Controller
{
    use Helpers;

    /**
     * @var Costos Dolares
     */
    private $costos_dolares;

    public function __construct(CostosDolaresRepository $costos_dolares )
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('context');

        $this->costos_dolares = $costos_dolares;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->fechas){
            $fecha_inicial = explode(" - ", $request->fechas)[0] . ' 00:00:00.000';
            $fecha_final = explode(" - ", $request->fechas)[1] . ' 00:00:00.000';
            $rango = "'{$fecha_inicial}' and '{$fecha_final}'";
            return view('sistema_contable.costos_dolares.index')
                ->with('costos', $this->costos_dolares->getBy($rango));
        }
        return view('sistema_contable.costos_dolares.index')->with('costos', "");
    }

    public function reporte(Request $request){
        $fecha_inicial = explode("+-+", $request->fechas)[0] . ' 00:00:00.000';
        $fecha_final = explode("+-+", $request->fechas)[1] . ' 00:00:00.000';
        $rango = "'{$fecha_inicial}' and '{$fecha_final}'";
        $reporte = $this->costos_dolares->getBy($rango);
        //dd($reporte);
        $pdf = new CostosDolaresPDF($reporte);
        $pdf->create();
    }

    public function reportexls(Request $request){
        $fecha_inicial = explode("+-+", $request->fechas)[0] . ' 00:00:00.000';
        $fecha_final = explode("+-+", $request->fechas)[1] . ' 00:00:00.000';
        $rango = "'{$fecha_inicial}' and '{$fecha_final}'";
        $reporte = $this->costos_dolares->getBy($rango);
        $pdf = new CostosDolaresXLS($reporte);
        $pdf->create();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
