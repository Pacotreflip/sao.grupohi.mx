<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\AfectacionOrdenPresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioCantidadInsumosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\CambioInsumosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PartidasInsumosAgrupadosRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TarjetaRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\TipoFiltroRepository;
use Ghi\Domain\Core\Formatos\ControlPresupuesto\PDFSolicitudCambioCantidadInsumos;
use Ghi\Domain\Core\Models\ConceptoPath;
use Ghi\Domain\Core\Models\ControlPresupuesto\CambioCantidadInsumos;
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
    private $cambio_cantidad;
    private $solicitud;
    private $partidas;


    public function __construct(TipoFiltroRepository $tipo_filtro, TarjetaRepository $tarjeta, CambioCantidadInsumosRepository $cambio_cantidad, SolicitudCambioRepository $solicitud, SolicitudCambioPartidaRepository $partidas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');


        $this->middleware('permission:consultar_cambio_cantidad_insumos', ['only' => ['pdf', 'show']]);
        $this->middleware('permission:registrar_cambio_cantidad_insumos', ['only' => ['create', 'store']]);
        $this->middleware('permission:autorizar_cambio_cantidad_insumos', ['only' => ['autorizar']]);
        $this->middleware('permission:rechazar_cambio_cantidad_insumos', ['only' => ['rechazar']]);


        $this->tipo_filtro = $tipo_filtro;
        $this->tarjeta = $tarjeta;
        $this->cambio_cantidad = $cambio_cantidad;
        $this->solicitud = $solicitud;
        $this->partidas = $partidas;

    }

    public function show($id)
    {
        $solicitud = CambioCantidadInsumos::with(['filtroCambioCantidad','filtroCambioCantidad.tipoFiltro', 'tipoOrden', 'tipoOrden.cobrabilidad', 'userRegistro', 'estatus'])->find($id);
        $dataConsulta = [];
        $dataConsulta['id_solicitud'] = $solicitud->id;
        $dataConsulta['columnaFiltro'] = $this->generaColumnaFiltro($solicitud->filtroCambioCantidad->id_tipo_filtro);
        $agrupacion = $this->cambio_cantidad->getAgrupacionFiltroPartidas($dataConsulta);
        $afectaciones = $this->cambio_cantidad->getAfectacionesSolicitud($id);
        return view('control_presupuesto.cambio_cantidad_insumos.show')
            ->with('solicitud', $solicitud)
            ->with('agrupacion', $agrupacion)
            ->with('detalle_afectacion', $afectaciones);

    }

    public function create()
    {
        $tipo_filtro = $this->tipo_filtro->all();

        return view('control_presupuesto.cambio_cantidad_insumos.create')
            ->with('tipo_orden', TipoOrden::ORDEN_DE_CAMBIO_DE_CANTIDAD_INSUMOS)
            ->with('tipo_filtro', $tipo_filtro);
    }

    private function generaColumnaFiltro($id_tipo_filtro)
    {

        switch ($id_tipo_filtro) {
            case TipoFiltro::SECTOR:
                return ConceptoPath::COLUMN_SECTOR;

                break;
            case TipoFiltro::CUADRANTE:
                return ConceptoPath::COLUMN_CUADRANTE;
                break;
            case TipoFiltro::TARJETA:
                return "ControlPresupuesto.tarjeta.descripcion";
                break;
            default:
                break;
        }
        return null;
    }

    public function getAgrupacionFiltro(Request $request)
    {

        //dd($request->all());
        $data = $request->all();
        $dataConsulta = [];
        $dataConsulta['precios'] = $data['precios'];
        $dataConsulta['id_material'] = $data['filtro_agrupado']['id_material'];
        $dataConsulta['columnaFiltro'] = $this->generaColumnaFiltro($data['filtro_agrupado']['id_tipo_filtro']);
        $result = $this->cambio_cantidad->getAgrupacionFiltro($dataConsulta);

        return response()->json(
            [
                'data' => $result
            ], 200);


    }

    public function getExplosionAgrupados(Request $request)
    {

        //dd($request->all());
        $data = $request->all();
        $dataConsulta = [];
        $dataConsulta['precio'] = $data['precio'];
        $dataConsulta['id_material'] = $data['filtro_agrupado']['id_material'];
        $dataConsulta['columnaFiltro'] = $this->generaColumnaFiltro($data['filtro_agrupado']['id_tipo_filtro']);
        $dataConsulta['descripcion'] = $data['descripcion'];
        $result = $this->cambio_cantidad->getExplosionAgrupados($dataConsulta);

        return response()->json(
            [
                'data' => $result
            ], 200);


    }

    public function getExplosionAgrupadosPartidas(Request $request)
    {

        //dd($request->all());
        $data = $request->all();
        $dataConsulta = [];
        $dataConsulta['precio'] = $data['precio'];
        $dataConsulta['id_material'] = $data['id_material'];
        $dataConsulta['id_solicitud'] = $data['id_solicitud'];
        $dataConsulta['columnaFiltro'] = $this->generaColumnaFiltro($data['id_tipo_filtro']);
        $dataConsulta['descripcion'] = $data['descripcion'];
        $result = $this->cambio_cantidad->getExplosionAgrupadosPartidas($dataConsulta);

        return response()->json(
            [
                'data' => $result
            ], 200);


    }

    public function store(Request $request)
    {
        $solicitud = $this->cambio_cantidad->create($request->all());

        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    public function rechazar(Request $request)
    {
        $solicitud = $this->cambio_cantidad->rechazar($request->all());
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    public function autorizar($id)
    {
        $solicitud = $this->cambio_cantidad->autorizar($id);
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }

    public function pdf(Request $request, $id)
    {

        $solicitud = CambioCantidadInsumos::with(['filtroCambioCantidad', 'tipoOrden', 'tipoOrden.cobrabilidad', 'userRegistro', 'estatus'])->find($id);
        $dataConsulta = [];
        $dataConsulta['id_solicitud'] = $solicitud->id;
        $dataConsulta['columnaFiltro'] = $this->generaColumnaFiltro($solicitud->filtroCambioCantidad->id_tipo_filtro);
        $agrupacion = $this->cambio_cantidad->getAgrupacionFiltroPartidas($dataConsulta);
        $afectaciones = $this->cambio_cantidad->getAfectacionesSolicitud($id);
        $data['agrupacion'] = $agrupacion;
        $data['detalle_afectacion'] = $afectaciones;
        $data['columna_filtro'] = $dataConsulta['columnaFiltro'];

        $solicitud = CambioCantidadInsumos::with(['filtroCambioCantidad', 'tipoOrden', 'tipoOrden.cobrabilidad', 'userRegistro', 'estatus'])->find($id);
        $pdf = new PDFSolicitudCambioCantidadInsumos($solicitud, $data, $this->cambio_cantidad);
        if (is_object($pdf))
            $pdf->create();
    }
}
