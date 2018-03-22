<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoFiltroRepository;
use Ghi\Domain\Core\Models\ConceptoPath;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioInsumos;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoFiltro;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Formatos\ControlPresupuesto\PDFSolicitudCambioInsumos;
use Illuminate\Http\Request;


class CambioCantidadInsumosController extends Controller
{
    use Helpers;

    private $tipo_filtro;
    private $tarjeta;
    public function __construct(TipoFiltroRepository $tipo_filtro,TarjetaRepository $tarjeta)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        /*
        $this->middleware('permission:consultar_cambio_insumos', ['only' => ['index', 'paginate', 'pdf', 'show']]);
        $this->middleware('permission:registrar_cambio_insumos', ['only' => ['create', 'store','storeIndirecto','indirecto']]);
        $this->middleware('permission:autorizar_cambio_insumos', ['only' => ['autorizar']]);
        $this->middleware('permission:aplicar_cambio_insumos', ['only' => ['aplicar']]);
        $this->middleware('permission:rechazar_cambio_insumos', ['only' => ['rechazar']]);
             */

        $this->tipo_filtro=$tipo_filtro;
        $this->tarjeta=$tarjeta;
    }


    public function create()
    {
        $tipo_filtro=$this->tipo_filtro->all();

        return view('control_presupuesto.cambio_cantidad_insumos.create')
            ->with('tipo_orden', TipoOrden::ORDEN_DE_CAMBIO_DE_CANTIDAD_INSUMOS)
            ->with('tipo_filtro', $tipo_filtro);
    }

    public function getAgrupacionFiltro(Request $request){

       //dd($request->all());
       $data=$request->all();


       $dataConsulta=[];
        $dataConsulta['precios']=$data['precios'];
        $dataConsulta['id_material']=$data['filtro_agrupado']['id_material'];
       switch ($data['filtro_agrupado']['id_tipo_filtro']){
           case TipoFiltro::SECTOR:
               $dataConsulta['columnaFiltro']=ConceptoPath::COLUMN_SECTOR;

               break;
           case TipoFiltro::CUADRANTE:
               $dataConsulta['columnaFiltro']=ConceptoPath::COLUMN_CUADRANTE;
               break;
           case TipoFiltro::TARJETA:
               $dataConsulta['columnaFiltro']="ControlPresupuesto.tarjeta.descripcion";
               break;
           default:
               break;
       }
       $result= $this->tarjeta->getAgrupacionFiltro($dataConsulta);

        return response()->json(
            [
                'data' => $result
            ], 200);


    }
}
