<?php

namespace Ghi\Http\Controllers\Presupuesto;

use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioPartidaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\ConceptoExtraordinarioRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoExtraordinarioRepository;
use Ghi\Domain\Core\Contracts\UnidadRepository;
use Ghi\Domain\Core\Formatos\ControlPresupuesto\PDFSolicitudCambioExtraordinario;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class ConceptosExtraordinariosController extends Controller
{
    use Helpers;

    private $extraordinario;
    private $unidades;
    private $tipos_extraordinario;
    private $tarjetas;
    private $catalogo;
    private $concepto;
    private $extraordinario_partidas;

    public function __construct(ConceptoExtraordinarioRepository $extraordinario,
                                UnidadRepository $unidades,
                                TipoExtraordinarioRepository $tipos_extraordinario,
                                TarjetaRepository $tarjetas,
                                CatalogoExtraordinarioRepository $catalogo,
                                ConceptoRepository $concepto, CatalogoExtraordinarioPartidaRepository $extraordinario_partidas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');


        //Permisos
        $this->middleware('permission:consultar_escalatoria', ['only' => ['index', 'pdf', 'show', 'getExtraordinario']]);
        $this->middleware('permission:registrar_escalatoria', ['only' => ['create', 'store', 'guardarCatalogo']]);
        $this->middleware('permission:autorizar_escalatoria', ['only' => ['autorizar']]);
        $this->middleware('permission:rechazar_escalatoria', ['only' => ['rechazar']]);

        $this->extraordinario = $extraordinario;
        $this->unidades = $unidades;
        $this->tipos_extraordinario = $tipos_extraordinario;
        $this->tarjetas = $tarjetas;
        $this->catalogo = $catalogo;
        $this->concepto = $concepto;
        $this->extraordinario_partidas = $extraordinario_partidas;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $conceptos = $this->concepto->getBy('nivel', 'like', '___.', 'cuentaConcepto');
        $unidades = $this->unidades->lists();
        $tipos_extraordinarios = $this->tipos_extraordinario->all();
        $tarjetas = $this->tarjetas->lists();
        $catalogo = $this->catalogo->all();

        return view('control_presupuesto.conceptos_extraordinarios.create')
            ->with('unidades', $unidades)
            ->with('tipos_extraordinarios',$tipos_extraordinarios )
            ->with('tarjetas', $tarjetas)
            ->with('catalogo', $catalogo)
            ->with('conceptos', $conceptos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $solicitud = $this->extraordinario->store($request->all());
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $resumen = $this->extraordinario->getResumenExtraordinario($id);
        $partidas = $this->extraordinario->getSolicitudCambioPartidas($id);
        $solicitud = SolicitudCambio::with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'aplicaciones'])->find($id);
        return view('control_presupuesto.conceptos_extraordinarios.show')
            ->with('solicitud', $solicitud)
            ->with('partidas', $partidas)
            ->with('resumen', $resumen);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getExtraordinario($tipo, $id){
        switch ($tipo){
            case 1:
                return response()->json(['data' => $this->concepto->getInsumosPorTarjeta($id) ], 200);
                break;
            case 2:
                return response()->json([ 'data' => $this->extraordinario_partidas->getPartidasByIdCatalogo($id)], 200);
                break;
            case 3:
                return response()->json([ 'data' => $this->extraordinario_partidas->getExtraordinarioNuevo()], 200);
                break;
        }
    }

    public function autorizar($id){
        $solicitud = $this->extraordinario->autorizar($id);
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    public function rechazar(Request $request){
        $solicitud = $this->extraordinario->rechazar($request->all());
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    public function pdf($id){
        $partidas = $this->extraordinario->getPdfData($id);
        $pdf = new PDFSolicitudCambioExtraordinario($partidas);
        if (is_object($pdf))
            $pdf->create();
    }

    public function guardarCatalogo(Request $request){
        $solicitud = $this->extraordinario_partidas->guardarExtraordinario($request->all());
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }
}
