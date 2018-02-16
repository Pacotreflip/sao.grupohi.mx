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
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
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

    /*public function mostrarAfectacion($id)
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

    }*/

    public function mostrarAfectacionPresupuesto(array $data)
    {
        $partida = $this->find($data['id_partida']);
        $baseDatos = BasePresupuesto::find($data['presupuesto']);
        $afectaciones = [];
        $conceptoBase = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->where('clave_concepto', '=', $partida->concepto->clave_concepto)->first();
        if (!$conceptoBase) {
            throw new HttpResponseException(new Response('El concepto ' . $partida->concepto->descripcion . ' no cuenta con clave de concepto registrada en ' . $baseDatos->base_datos, 404));
        }

        $items = DB::connection('cadeco')
            ->table($baseDatos->base_datos . ".dbo.conceptos")
            ->orderBy('nivel', 'ASC')
            ->where('id_obra', '=', Context::getId())
            ->where('nivel', 'like', $conceptoBase->nivel . '%')
            ->get();
        $detalle = array();

        foreach ($items as $index => $item) {
            $historico = SolicitudCambioPartidaHistorico::where('id_solicitud_cambio_partida', '=', $partida->id)
                ->where('id_base_presupuesto', '=', $data['presupuesto'])
                ->where('nivel', '=', $item->nivel)
                ->first();

            $hijos = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', 'like', $item->nivel . '%')->count();
            $nivel_padre = $partida->concepto->nivel;
            $nivel_hijo = $item->nivel;
            $profundidad = (strlen($nivel_hijo) - strlen($nivel_padre)) / 4;
            $factor = $partida->cantidad_presupuestada_nueva / $partida->cantidad_presupuestada_original;

            $row = array('index' => $index + 1,
                //'numTarjeta'=>$item->numero_tarjeta,
                'descripcion' => str_repeat("______", $profundidad) . ' ' . $item->descripcion,
                'unidad' => utf8_decode($item->unidad),
                'pu' => $item->precio_unitario,
                'hijos' => $hijos,
                'nivel' => $item->nivel
            );

            if ($historico) {
                $row = array_add($row, 'cantidadPresupuestada', $historico->cantidad_presupuestada_original);
                $row = array_add($row, 'cantidadNueva', $historico->cantidad_presupuestada_actualizada);
                $row = array_add($row, 'monto_presupuestado', $historico->monto_presupuestado_original);
                $row = array_add($row, 'monto_nuevo', $historico->monto_presupuestado_actualizado);
                $row = array_add($row, 'variacion_volumen', $historico->cantidad_presupuestada_actualizada - $historico->cantidad_presupuestada_original);
                $row = array_add($row, 'variacion_importe', ($historico->monto_presupuestado_actualizado - $historico->monto_presupuestado_original));
            } else {
                $row = array_add($row, 'cantidadPresupuestada', $item->cantidad_presupuestada);
                $row = array_add($row, 'cantidadNueva', $item->cantidad_presupuestada * $factor);
                $row = array_add($row, 'monto_presupuestado', $item->monto_presupuestado);
                $row = array_add($row, 'monto_nuevo', $item->monto_presupuestado * $factor);
                $row = array_add($row, 'variacion_volumen', ($item->cantidad_presupuestada * $factor) - $item->cantidad_presupuestada);
                $row = array_add($row, 'variacion_importe', ($item->monto_presupuestado * $factor) - $item->monto_presupuestado);
            }

            if ($hijos == 1 && strlen($item->nivel) == 40) {
            } else {
                array_push($afectaciones, $row);
            }
        }
        return $afectaciones;
    }

    public function getClasificacionInsumos(array $data)
    {
        $partidas = SolicitudCambioPartida::with('material')->where('id_solicitud_cambio', '=', $data['id_solicitud_cambio'])->get();
        $concepto = Concepto::find($data['id_concepto']);
        $materiales = [];
        $mano_obra = [];
        $herramienta = [];
        $maquinaria = [];
        $data = [];
        foreach ($partidas as $partida) {

            if ($partida['rendimiento_nuevo'] != null) { ////no cambio rendimiento
                $partida['cantidad_presupuestada_nueva'] = $partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada;
                $partida['cantidad_presupuestada'] = $partida['rendimiento_original'] * $concepto->cantidad_presupuestada;
            } else { ////////cambio rendimiento
                $item = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_material', '=', $partida['id_material'])->first();
                $partida['cantidad_presupuestada'] = $item->cantidad_presupuestada;
                $partida['cantidad_presupuestada_nueva'] = 0;
            }
            if ($partida['precio_unitario_nuevo'] != null) {
                $partida['precio_unitario_original'] = $partida['precio_unitario_original'];
                $partida['precio_unitario_nuevo'] = $partida['precio_unitario_nuevo'];
                $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_nuevo'];
            } else {
                $partida['precio_unitario_nuevo'] = 0;
                $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_original'];
            }


            switch ($partida->material->tipo_material) {
                case 1:///materiales
                    array_push($materiales, $partida);
                    break;
                case 2:///Mano obra
                    array_push($mano_obra, $partida);
                    break;
                case 4:///Herramienta y equipo
                    array_push($herramienta, $partida);
                    break;
                case 8:/// Maquinaria
                    array_push($maquinaria, $partida);
                    break;
            }
        }


        $materiales = ['tipo' => 'MATERIALES', 'id_tipo' => 1, 'items' => $materiales];
        $mano_obra = ['tipo' => 'MANO DE OBRA', 'id_tipo' => 2, 'items' => $mano_obra];
        $herramienta = ['tipo' => 'HERRAMIENTA', 'id_tipo' => 4, 'items' => $herramienta];
        $maquinaria = ['tipo' => 'MAQUINARIA Y EQUIPO', 'id_tipo' => 8, 'items' => $maquinaria];
        array_push($data, $materiales);
        array_push($data, $mano_obra);
        array_push($data, $herramienta);
        array_push($data, $maquinaria);
        return $data;
    }

    public function getTotalesClasificacionInsumos(array $data)
    {

        $conceptosSol = [];
        $imp_anterior_gen = 0;
        $imp_nuevo_gen = 0;
        $var_gen = 0;
        $estatus_solicitud = 0;
        $solicitud = SolicitudCambio::find($data[0]['id_solicitud_cambio']);
        $id_solicitud_historico = 0;
        foreach ($data as $conceptoAgr) {

            $conceptoAgr['concepto']['materiales_monto_original'] = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'MATERIALES')->first()->monto_presupuestado;
            $conceptoAgr['concepto']['mano_obra_monto_original'] = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'MANO OBRA')->first()->monto_presupuestado;
            $conceptoAgr['concepto']['herramienta_monto_original'] = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->first()->monto_presupuestado;
            $conceptoAgr['concepto']['maquinaria_monto_original'] = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'MAQUINARIA')->first()->monto_presupuestado;
            $id_solicitud_historico = $conceptoAgr['id'];
            //  dd( $conceptoAgr['concepto']);
            $partidas = SolicitudCambioPartida::with('material')->where('id_solicitud_cambio', '=', $conceptoAgr['id_solicitud_cambio'])->get();
            $concepto = Concepto::find($conceptoAgr['concepto']['id_concepto']);

            $materiales = 0;
            $mano_obra = 0;
            $herramienta = 0;
            $maquinaria = 0;

            foreach ($partidas as $partida) {
                $existe = false;
                $item = null;
                if ($partida['rendimiento_nuevo'] != null) { ///NUEVO
                    $partida['cantidad_presupuestada'] = ($partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario'];
                } else {  ////original
                    $item = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_material', '=', $partida['id_material'])->first();
                    $partida['cantidad_presupuestada'] = $partida['rendimiento_original'] * $concepto->cantidad_presupuestada;
                    $existe = true;
                }


                if ($partida['precio_unitario_nuevo'] != null) {
                    $partida['precio_unitario_original'] = $partida['precio_unitario_original'];
                    $partida['precio_unitario_nuevo'] = $partida['precio_unitario_nuevo'];
                    $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_nuevo'];
                } else {
                    $partida['precio_unitario_nuevo'] = 0;
                    $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_original'];
                }

                if ($existe) {
                    $partida['variacion'] = $partida['monto_presupuestado'] - ($partida['cantidad_presupuestada'] * $partida['precio_unitario_original']);
                } else {
                    $partida['variacion'] = $partida['monto_presupuestado'];
                }

                switch ($partida->material->tipo_material) {
                    case 1:///materiales
                        $materiales += $partida->variacion;
                        break;
                    case 2:///Mano obra
                        $mano_obra += $partida->variacion;
                        break;
                    case 4:///Herramienta y equipo
                        $herramienta += $partida->variacion;
                        break;
                    case 8:/// Maquinaria
                        $maquinaria += $partida->variacion;
                        break;
                }
            }


            $conceptoAgr['concepto']['materiales_variacion'] = $materiales;
            $conceptoAgr['concepto']['mano_obra_variacion'] = $mano_obra;
            $conceptoAgr['concepto']['herramienta_variacion'] = $herramienta;
            $conceptoAgr['concepto']['maquinaria_variacion'] = $maquinaria;
            $conceptoAgr['concepto']['variacion'] = $materiales + $mano_obra + $herramienta + $maquinaria;

            $importe_new = $conceptoAgr['concepto']['variacion'] +
                $conceptoAgr['concepto']['materiales_monto_original'] +
                $conceptoAgr['concepto']['mano_obra_monto_original'] +
                $conceptoAgr['concepto']['herramienta_monto_original'] +
                $conceptoAgr['concepto']['maquinaria_monto_original'];


            $conceptoAgr['concepto']['importe_nuevo'] = $solicitud->id_estatus == 2 ? $importe_new - $conceptoAgr['concepto']['variacion'] : $importe_new;
            $conceptoAgr['concepto']['importe_anterior'] = $solicitud->id_estatus == 2 ? ($conceptoAgr['concepto']['importe_nuevo'] - $conceptoAgr['concepto']['variacion']) : $conceptoAgr['concepto']['importe_nuevo'] - $conceptoAgr['concepto']['variacion'];

            if ($solicitud->id_estatus == 2) {

                // dd($conceptoAgr['concepto']['materiales_monto_original'] , $conceptoAgr['concepto']['materiales_variacion']);
                $conceptoAgr['concepto']['materiales_monto_original'] = $conceptoAgr['concepto']['materiales_monto_original'] - $conceptoAgr['concepto']['materiales_variacion'];
                $conceptoAgr['concepto']['mano_obra_monto_original'] = $conceptoAgr['concepto']['mano_obra_monto_original'] - $conceptoAgr['concepto']['mano_obra_variacion'];
                $conceptoAgr['concepto']['herramienta_monto_original'] = $conceptoAgr['concepto']['herramienta_monto_original'] - $conceptoAgr['concepto']['herramienta_variacion'];
                $conceptoAgr['concepto']['maquinaria_monto_original'] = $conceptoAgr['concepto']['maquinaria_monto_original'] - $conceptoAgr['concepto']['maquinaria_variacion'];

            }


            $imp_anterior_gen += $conceptoAgr['concepto']['importe_anterior'];
            $imp_nuevo_gen += $conceptoAgr['concepto']['importe_nuevo'];
            $var_gen += $conceptoAgr['concepto']['variacion'];
            array_push($conceptosSol, $conceptoAgr);
        }

        $total_presupuesto_hist = 0;
        if ($solicitud->id_estatus == 2) {

            $total_presupuesto = SolicitudCambioPartidaHistorico::where('nivel', '=', '000.001.')->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();
            $total_presupuesto_hist = $total_presupuesto->monto_presupuestado_original;
        } else {
            $total_presupuesto = Concepto::where('nivel', '=', '000.001.')->where('id_obra', '=', Context::getId())->first();
            $total_presupuesto_hist = $total_presupuesto->monto_presupuestado;
        }

        $baseDatos = BasePresupuesto::find(3); ////validacion proforma
        $maximo_proforma = 0;
        foreach ($data as $conceptoAgr) {
            $afectaciones = [];
            $conceptoProforma = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->where('clave_concepto', '=', $conceptoAgr['concepto']['clave_concepto'])->first();
            if (!$conceptoProforma) {
                throw new HttpResponseException(new Response('El concepto ' . $partida->concepto->descripcion . ' no cuenta con clave de concepto registrada en ' . $baseDatos->base_datos, 404));
            }
            $montoProfC=$conceptoProforma->cantidad_presupuestada*$conceptoProforma->precio_unitario;

            $maximo_proforma += $montoProfC;

        }

        $data = ['conceptos' => $conceptosSol,
            'imp_anterior_gen' => $imp_anterior_gen,
            'imp_nuevo_gen' => $imp_nuevo_gen,
            'total_presupuesto' => $total_presupuesto_hist,
            'total_variaciones' => $var_gen,
            'total_agrupados_nuevo' => $imp_nuevo_gen - $var_gen,
            'maximo_proforma' => ['maximo'=>$maximo_proforma,'diferencia'=>($maximo_proforma-$imp_nuevo_gen),'variacion'=>$var_gen]];

        return $data;
    }


}