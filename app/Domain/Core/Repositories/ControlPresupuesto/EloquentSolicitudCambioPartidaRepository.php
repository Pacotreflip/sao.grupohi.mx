<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:15 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioPartidaRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EloquentSolicitudCambioPartidaRepository implements SolicitudCambioPartidaRepository
{
    /**
     * @var SolicitudCambioPartida
     */
    protected $model;

    public function __construct(SolicitudCambioPartida $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de SolicitudCambioPartida
     *
     * @return SolicitudCambioPartida
     */
    public function all()
    {
        return $this->model->get();
    }


    /**
     * Guarda un registro de SolicitudCambioPartida
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitudCambioPartida = $this->model->create($data);
            DB::connection('cadeco')->commit();
            return $solicitudCambioPartida;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Regresa un registro específico de SolicitudCambioPartida
     * @param $id
     * @return SolicitudCambioPartida
     */
    public function find($id)
    {
        $solicitudCambio = $this->model->find($id);
        return $solicitudCambio;
    }

    public function findIn($ids = [])
    {
        return $this->model->whereIn('id_concepto', $ids)->with('solicitud')->get();
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function mostrarAfectacion($id)
    {

        $partida = $this->find($id);

        $afectaciones = array();
        $items = Concepto::orderBy('nivel', 'ASC')->where('nivel', 'like', $partida->concepto->nivel . '%')->get();
        $detalle = array();
        foreach ($items as $index => $item) {
            $nivel_padre = $partida->concepto->nivel;
            $nivel_hijo = $item->nivel;
            $profundidad = (strlen($nivel_hijo) - strlen($nivel_padre)) / 4;
            $factor = $partida->cantidad_presupuestada_nueva / $partida->concepto->cantidad_presupuestada;
            $cantidad_nueva = $item->cantidad_presupuestada * $factor;
            $monto_nuevo = $item->monto_presupuestado * $factor;

            $row = array('index' => $index + 1,
                'numTarjeta' => $item->numero_tarjeta,
                'descripcion' => str_repeat("______", $profundidad) . ' ' . $item->descripcion,
                'unidad' => utf8_decode($item->unidad),
                'cantidadPresupuestada' => $item->cantidad_presupuestada,
                'cantidadNueva' => $cantidad_nueva,
                'monto_presupuestado' => $item->monto_presupuestado,
                'monto_nuevo' => $monto_nuevo,
                'variacion_volumen' => $cantidad_nueva - $item->cantidad_presupuestada,
                'pu' => $item->precio_unitario
            );
            array_push($afectaciones, $row);

        }
        return $afectaciones;

    }

    public function mostrarAfectacionPresupuesto(array $data)
    {
        $partida = $this->find($data['id_partida']);
        $baseDatos = BasePresupuesto::find($data['presupuesto']);
        $afectaciones = array();
        // $items = Concepto::orderBy('nivel', 'ASC')->where('nivel', 'like', $partida->concepto->nivel . '%')->get();
        $conceptoBase = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->where('clave_concepto', '=', $partida->concepto->clave_concepto)->first();
        if (!$conceptoBase) {
            throw new HttpResponseException(new Response('El concepto ' . $partida->concepto->descripcion . ' no cuenta con clave de concepto registrada en ' . $baseDatos->base_datos, 404));
        }

        $items = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->orderBy('nivel', 'ASC')->where('id_obra', '=', Context::getId())->where('nivel', 'like', $conceptoBase->nivel . '%')->get();
        $detalle = array();

        foreach ($items as $index => $item) {
            $hijos = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', 'like', $item->nivel . '%')->count();
            $nivel_padre = $partida->concepto->nivel;
            $nivel_hijo = $item->nivel;
            $profundidad = (strlen($nivel_hijo) - strlen($nivel_padre)) / 4;
            $factor = $partida->cantidad_presupuestada_nueva / $partida->concepto->cantidad_presupuestada;
            $cantidad_nueva = $item->cantidad_presupuestada * $factor;
            $monto_nuevo = $item->monto_presupuestado * $factor;

            $row = array('index' => $index + 1,
                //'numTarjeta'=>$item->numero_tarjeta,
                'descripcion' => str_repeat("______", $profundidad) . ' ' . $item->descripcion,
                'unidad' => utf8_decode($item->unidad),
                'cantidadPresupuestada' => $item->cantidad_presupuestada,
                'cantidadNueva' => $cantidad_nueva,
                'monto_presupuestado' => $item->monto_presupuestado,
                'monto_nuevo' => $monto_nuevo,
                'variacion_volumen' => $cantidad_nueva - $item->cantidad_presupuestada,
                'pu' => $item->precio_unitario,
                'variacion_importe' => ($monto_nuevo - $item->monto_presupuestado),
                'hijos' => $hijos,
                'nivel' => $item->nivel
            );
            if ($hijos == 1 && strlen($item->nivel) == 40) {
            } else {
                array_push($afectaciones, $row);
            }
        }
        return $afectaciones;

    }

    public function mostrarSubtotalTarjeta(array $data)
    {
        $baseDatos = BasePresupuesto::find($data['presupuesto']);

        $claves = [];
        $claves_seleccionados = [];
        $numero_tarjeta = 0;
        $importeConceptosSeleccionado = 0;
        $importeConceptosTarjeta = 0;
        $importeConceptoNoSeleccionado = 0;
        $response = [];

        if ($data['agregados']) {////obtenemos clave de concepto para busqueda en presupuestos
            foreach ($data['agregados'] as $agregado) {
                $numero_tarjeta = $agregado['numero_tarjeta'];
                array_push($claves_seleccionados, $agregado['clave_concepto']);
            }
        }
        ////////////////////////////////////////////////////////////////////////// importe conceptos seleccionados

        $conceptosAgregados = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->whereIn('clave_concepto', $claves_seleccionados)->get();
        if ($conceptosAgregados) {
            foreach ($conceptosAgregados as $conceptoAgregado) {
                $importeConceptosSeleccionado += $conceptoAgregado->monto_presupuestado; ////sumatoria monto_presupuestado
            }
        }


        ////////////////////////////////////////////////////////////////////////// importe conceptos de tarjeta
        $tarjeta = Tarjeta::where('descripcion', '=', $numero_tarjeta)->first();//tarjeta
        $conceptosTarjeta = ConceptoTarjeta::with('concepto')->where('id_tarjeta', '=', $tarjeta->id)->get(); ///conceptos de tarjeta
        $claves = [];
        foreach ($conceptosTarjeta as $agregado) { /////obtenemos claves para buscar en otra base
            if ($agregado->concepto->clave_concepto != null) {
                array_push($claves, $agregado->concepto->clave_concepto);
            }
        }
        $conceptosAgregados = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->whereIn('clave_concepto', $claves)->get(); ///buscamos en otra base
        if ($conceptosAgregados) {
            foreach ($conceptosAgregados as $conceptoAgregado) {
                $importeConceptosTarjeta += $conceptoAgregado->monto_presupuestado; ////sumatoria monto_presupuestado todos los conceptos
            }
        }

        ////////////////////////////////////////////////////////////////////////// importe conceptos de tarjeta no seleccionados
        $importeConceptoNoSeleccionado = ($importeConceptosTarjeta - $importeConceptosSeleccionado);
        $response['total_seleccionados'] =$importeConceptosSeleccionado;
        $response['total_tarjeta'] =$importeConceptosTarjeta;
        $response['total_sin_seleccion'] =$importeConceptoNoSeleccionado;
        return $response;
    }
}