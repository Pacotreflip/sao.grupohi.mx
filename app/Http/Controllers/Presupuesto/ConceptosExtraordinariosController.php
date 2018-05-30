<?php

namespace Ghi\Http\Controllers\Presupuesto;

use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioPartidaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CatalogoExtraordinarioRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\ConceptoExtraordinarioRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoExtraordinarioRepository;
use Ghi\Domain\Core\Contracts\UnidadRepository;
use Ghi\Http\Controllers\Controller;

class ConceptosExtraordinariosController extends Controller
{
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
        /*$this->middleware('permission:consultar_cambio_insumos', ['only' => ['index', 'paginate', 'pdf', 'show']]);
        $this->middleware('permission:registrar_cambio_insumos', ['only' => ['create', 'store','storeIndirecto','indirecto']]);
        $this->middleware('permission:autorizar_cambio_insumos', ['only' => ['autorizar']]);
        $this->middleware('permission:aplicar_cambio_insumos', ['only' => ['aplicar']]);
        $this->middleware('permission:rechazar_cambio_insumos', ['only' => ['rechazar']]);
*/
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
        //dd($this->extraordinario->getDesdeTarjeta(11));
        return view('control_presupuesto.conceptos_extraordinarios.create')
            ->with('unidades', $this->unidades->lists())
            ->with('tipos_extraordinarios', $this->tipos_extraordinario->all())
            ->with('tarjetas', $this->tarjetas->lists())
            ->with('catalogo', $this->catalogo->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
                //dd($this->concepto->geInsumosPorTarjeta($id));
                return response()->json(['data' => $this->concepto->getInsumosPorTarjeta($id) ], 200);
                break;

            case 2:
                return response()->json([ 'data' => $this->extraordinario_partidas->getPartidasByIdCatalogo($id)], 200);
                break;

            case 3:
                return response()->json([ 'data' => $this->extraordinario_partidas->getExtraordinarioNuevo($id)], 200);
                break;
        }
    }
}
