<?php

namespace Ghi\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Ghi\Domain\Core\Contracts\Contabilidad\ConceptoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\BasePresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Reportes\ControlPresupuesto\PDFSolicitudCambio;
use Illuminate\Http\Request;


class CambioPresupuestoController extends Controller
{
    use Helpers;
    protected $operadores = [
        '= "{texto}"' => 'Igual A',
        '!= "{texto}"' => 'Diferente De',
        'like "{texto}%"' => 'Empieza Con',
        'like "%{texto}"' => 'Termina Con',
        'like "%{texto}%"' => 'Contiene'
    ];

    private $presupuesto;
    private $concepto;
    private $basePresupuesto;
    private $solicitud;
    private $partidas;

    public function __construct(PresupuestoRepository $presupuesto, ConceptoRepository $concepto, BasePresupuestoRepository $basePresupuesto, SolicitudCambioRepository $solicitud, SolicitudCambioPartidaRepository $partidas)
    {
        parent::__construct();

        $this->middleware('auth');
        $this->middleware('context');

        $this->presupuesto = $presupuesto;
        $this->basePresupuesto = $basePresupuesto;
        $this->concepto = $concepto;
        $this->solicitud = $solicitud;
        $this->partidas = $partidas;
    }

    public function index()
    {
        return view('control_presupuesto.cambio_presupuesto.index');
    }

    public function paginate(Request $request)
    {
        $solicitudes = $this->solicitud->paginate($request->all());
        return response()->json([
            'recordsTotal' => $solicitudes->total(),
            'recordsFiltered' => $solicitudes->total(),
            'data' => $solicitudes->items()
        ], 200);
    }

    public function create()
    {
        return view('control_presupuesto.cambio_presupuesto.create')
            ->with('operadores', $this->operadores);
    }

    public function getPaths(Request $request)
    {

        $baseDatos = $this->basePresupuesto->findBy($request->all()['baseDatos']);
        $conceptos = $this->concepto->paths($request->all(), $baseDatos[0]->base_datos);

        return response()->json([
            'recordsTotal' => $conceptos->total(),
            'recordsFiltered' => $conceptos->total(),
            'data' => $conceptos->items()
        ], 200);
    }

    public function store(Request $request)
    {
        // Revisa si ya existe una solicitud con al menos una partida ya seleccionada
        $conceptos_ids = [];
        $repetidas = false;

        foreach ($request->partidas as $p)
            $conceptos_ids[] = $p['id_concepto'];

        $repetidas = $this->partidas->findIn($conceptos_ids);

        if (is_null($repetidas))
            return response()->json(
                [
                    'repetidas' => $repetidas
                ], 200);

        $solicitud = '';
        switch ($request->id_tipo_orden) {
            case TipoOrden::ESCALATORIA:
                break;
            case TipoOrden::RECLAMOS_INDIRECTO:
                break;
            case TipoOrden::CONCEPTOS_EXTRAORDINARIOS:
                break;
            case TipoOrden::VARIACION_VOLUMEN:
                $solicitud = $this->solicitud->saveVariacionVolumen($request->all());
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_NO_COBRABLE:
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS:
                break;
        }
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });

    }

    public function pdf(Request $request, $id)
    {
        $solicitud = $this->solicitud->find($id);

        $pdf = new PDFSolicitudCambio($solicitud);
        $pdf->create();
    }

    public function show($id)
    {
        $solicitud = $this->solicitud->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto','partidas.numeroTarjeta'])->find($id);
$afectaciones=array();
        foreach ($solicitud->partidas as $partida) {
            $items = Concepto::orderBy('nivel', 'ASC')->where('nivel', 'like', $partida->concepto->nivel . '%')->get();
            $detalle = array();
            foreach ($items as $index => $item) {

                $nivel_padre = $partida->concepto->nivel;
                $nivel_hijo = $item->nivel;
                $profundidad = (strlen($nivel_hijo) - strlen($nivel_padre)) / 4;
                $factor = $partida->cantidad_presupuestada_nueva / $partida->concepto->cantidad_presupuestada;
                $cantidad_nueva = $item->cantidad_presupuestada * $factor;
                $monto_nuevo = $item->monto_presupuestado * $factor;

                $row=  array( 'index'=>$index + 1,
                    'numTarjeta'=>$item->numero_tarjeta,
                    'descripcion'=> str_repeat("______", $profundidad).' '.$item->descripcion,
                    'unidad'=>utf8_decode($item->unidad),
                    'cantidadPresupuestada'=>number_format($item->cantidad_presupuestada, 2, '.', ','),
                    'cantidadNueva'=>number_format($cantidad_nueva, 2, '.', ','),
                    'monto_presupuestado'=>'$' . number_format($item->monto_presupuestado, 2, '.', ','),
                    'monto_nuevo'=>'$' . number_format($monto_nuevo, 2, '.', ','));

              array_push($detalle,$row);
            }

            $detalle=array('partida'=>$partida,'detalle'=>$detalle);
          array_push($afectaciones,$detalle);
        }

//dd($afectaciones);

        return view('control_presupuesto.cambio_presupuesto.show.variacion_volumen')
            ->with('solicitud', $solicitud)
            ->with('cobrabilidad', $solicitud->tipoOrden->cobrabilidad)
            ->with('afectaciones',(object) $afectaciones);
    }


    public function autorizarSolicitud(Request $request)
    {
        $solicitud = '';
        switch ($request->id_tipo_orden) {
            case TipoOrden::ESCALATORIA:
                break;
            case TipoOrden::RECLAMOS_INDIRECTO:
                break;
            case TipoOrden::CONCEPTOS_EXTRAORDINARIOS:
                break;
            case TipoOrden::VARIACION_VOLUMEN:
                $solicitud = $this->solicitud->autorizarVariacionVolumen($request->id);
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_NO_COBRABLE:
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS:
                break;
        }


        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }
    public function rechazarSolicitud(Request $request)
    {
        $solicitud = '';
        switch ($request->id_tipo_orden) {
            case TipoOrden::ESCALATORIA:
                break;
            case TipoOrden::RECLAMOS_INDIRECTO:
                break;
            case TipoOrden::CONCEPTOS_EXTRAORDINARIOS:
                break;
            case TipoOrden::VARIACION_VOLUMEN:
                $solicitud = $this->solicitud->rechazarVariacionVolumen($request->all());
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_NO_COBRABLE:
                break;
            case TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS:
                break;
        }
        return $this->response->item($solicitud, function ($item) {
            return $item;
        });
    }
}
