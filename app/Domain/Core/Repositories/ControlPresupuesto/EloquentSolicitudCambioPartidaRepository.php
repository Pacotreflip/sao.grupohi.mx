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
        $subcontratos = [];
        $gastos = [];
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


            // dd($partida);

            if ($partida['id_concepto'] == null) {
                $partida['monto_presupuestado'] = $partida['cantidad_presupuestada_nueva'] * $partida['precio_unitario_nuevo'];
            } else {
                if ($partida['rendimiento_nuevo'] != null) { ////no cambio rendimiento

                    if ($partida['precio_unitario_nuevo'] != null) {
                        $partida['monto_presupuestado'] = ($partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario_nuevo'];
                    } else {
                        // dd("panda");
                        $partida['monto_presupuestado'] = ($partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario_original'];
                    }
                } else {
                    $partida['monto_presupuestado'] = ($partida['rendimiento_original'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario_nuevo'];
                }
            }

            //  dd($partida);
            /* if ($partida['precio_unitario_nuevo'] != null) {
                 $partida['precio_unitario_original'] = $partida['precio_unitario_original'];
                 $partida['precio_unitario_nuevo'] = $partida['precio_unitario_nuevo'];
                 if ($partida['id_concepto'] == null) {
                     $partida['monto_presupuestado'] = $partida['cantidad_presupuestada_nueva'] * $partida['precio_unitario_nuevo'];
                 } else {
 dd($partida);
                     if ($partida['rendimiento_nuevo'] != null) { ////no cambio rendimiento
                         if($partida['precio_unitario_nuevo']!=null){
                             $partida['monto_presupuestado'] = (  $partida['monto_presupuestado_nuevo'] *$concepto->cantidad_presupuestada)*$partida['precio_unitario_nuevo'];
                         }else{
                             $partida['monto_presupuestado']=  (  $partida['monto_presupuestado_nuevo'] *$concepto->cantidad_presupuestada)*$partida['precio_unitario_original'];
                         }
                     }else{
                         $partida['monto_presupuestado']=($partida['rendimiento_original'] * $concepto->cantidad_presupuestada)*$partida['precio_unitario_nuevo'];
                     }

                 }

             }
            */
            $partida->toArray();
            switch ($partida->tipo_agrupador) {
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
                case 5:/// Maquinaria
                    array_push($subcontratos, $partida);
                    break;
                case 6:/// Maquinaria
                    array_push($gastos, $partida);
                    break;
            }
        }


        $materiales = ['tipo' => 'MATERIALES', 'id_tipo' => 1, 'items' => $materiales];
        $mano_obra = ['tipo' => 'MANO DE OBRA', 'id_tipo' => 2, 'items' => $mano_obra];
        $herramienta = ['tipo' => 'HERRAMIENTA', 'id_tipo' => 4, 'items' => $herramienta];
        $maquinaria = ['tipo' => 'MAQUINARIA Y EQUIPO', 'id_tipo' => 8, 'items' => $maquinaria];
        $subcontratos = ['tipo' => 'SUBCONTRATOS', 'id_tipo' => 5, 'items' => $subcontratos];
        $gastos = ['tipo' => 'GASTOS', 'id_tipo' => 6, 'items' => $gastos];
        array_push($data, $materiales);
        array_push($data, $mano_obra);
        array_push($data, $herramienta);
        array_push($data, $maquinaria);
        array_push($data, $subcontratos);
        array_push($data, $gastos);


        return $data;
    }

    public function getTotalesClasificacionInsumos(array $data)
    {

        $conceptosSol = [];
        $imp_anterior_gen = 0;
        $imp_nuevo_gen = 0;
        $var_gen = 0;
        $total_presupuesto_hist = 0;
        $estatus_solicitud = 0;
        $solicitud = SolicitudCambio::find($data[0]['id_solicitud_cambio']);
        $id_solicitud_historico = 0;
        $total_presupuesto = Concepto::where('nivel', '=', '000.001.')->where('id_obra', '=', Context::getId())->first();
        $total_presupuesto_hist = $total_presupuesto->monto_presupuestado;
        foreach ($data as $conceptoAgr) {


            $concMatOr = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'MATERIALES')->first();
            $conceptoAgr['concepto']['materiales_monto_original'] = $concMatOr->monto_presupuestado;

            $concManObr = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'MANO OBRA')->first();
            $conceptoAgr['concepto']['mano_obra_monto_original'] = $concManObr->monto_presupuestado;

            $concHyEqOr = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->first();
            $conceptoAgr['concepto']['herramienta_monto_original'] = $concHyEqOr->monto_presupuestado;

            $concMaqOr = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'MAQUINARIA')->first();
            $conceptoAgr['concepto']['maquinaria_monto_original'] = $concMaqOr->monto_presupuestado;

            $concsSubOr = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'SUBCONTRATOS')->first();
            $conceptoAgr['concepto']['subcontratos_monto_original'] = $concsSubOr->monto_presupuestado;

            $concGastOr = Concepto::where('nivel', 'like', $conceptoAgr['concepto']['nivel'] . '%')->where('descripcion', '=', 'GASTOS')->first();
            $conceptoAgr['concepto']['gastos_monto_original'] = $concGastOr->monto_presupuestado;

            $id_solicitud_historico = $conceptoAgr['id'];
            //  dd( $conceptoAgr['concepto']);
            $partidas = SolicitudCambioPartida::with('material')->where('id_solicitud_cambio', '=', $conceptoAgr['id_solicitud_cambio'])->get();
            $concepto = Concepto::find($conceptoAgr['concepto']['id_concepto']);

            $materiales = 0;
            $mano_obra = 0;
            $herramienta = 0;
            $maquinaria = 0;
            $subcontratos = 0;
            $gastos = 0;

            foreach ($partidas as $partida) {
                $existe = false;
                $item = null;
                $auxmonto = 0;
                if ($partida['rendimiento_nuevo'] != null) { ////no cambio rendimiento
                    $partida['cantidad_presupuestada_nueva'] = $partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada;
                    $partida['cantidad_presupuestada'] = $partida['rendimiento_original'] * $concepto->cantidad_presupuestada;
                } else { ////////cambio rendimiento
                    $item = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_material', '=', $partida['id_material'])->first();
                    $partida['cantidad_presupuestada'] = $item->cantidad_presupuestada;
                    $partida['cantidad_presupuestada_nueva'] = 0;
                }


                // dd($partida);

                if ($partida['id_concepto'] == null) {
                    $partida['monto_presupuestado'] = $partida['cantidad_presupuestada_nueva'] * $partida['precio_unitario_nuevo'];
                } else {
                    if ($partida['rendimiento_nuevo'] != null) { ////no cambio rendimiento

                        if ($partida['precio_unitario_nuevo'] != null) {
                            $partida['monto_presupuestado'] = ($partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario_nuevo'];
                        } else {
                            // dd("panda");
                            $partida['monto_presupuestado'] = ($partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario_original'];
                        }
                    } else {
                        $partida['monto_presupuestado'] = ($partida['rendimiento_original'] * $concepto->cantidad_presupuestada) * $partida['precio_unitario_nuevo'];
                    }
                }


                if ($partida['id_concepto'] != null) {
                    $conceptoMpO = Concepto::find($partida['id_concepto']);
                    $auxmpnto = ($conceptoMpO->monto_presupuestado);
                    $partida['variacion'] = $partida['monto_presupuestado'] - $auxmpnto;
                } else {

                    $partida['variacion'] = $partida['monto_presupuestado'];
                }

//dd($partida);

//echo "<br var-->". $partida['variacion'];
                switch ($partida->tipo_agrupador) {
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
                    case 5:/// Subcontratos
                        $subcontratos += $partida->variacion;
                        break;
                    case 6:/// Gastos
                        $gastos += $partida->variacion;
                        break;
                }

            }

//dd($materiales);
            $conceptoAgr['concepto']['materiales_variacion'] = $materiales;
            $conceptoAgr['concepto']['mano_obra_variacion'] = $mano_obra;
            $conceptoAgr['concepto']['herramienta_variacion'] = $herramienta;
            $conceptoAgr['concepto']['maquinaria_variacion'] = $maquinaria;
            $conceptoAgr['concepto']['subcontratos_variacion'] = $subcontratos;
            $conceptoAgr['concepto']['gastos_variacion'] = $gastos;


            $conceptoAgr['concepto']['variacion'] = $materiales + $mano_obra + $herramienta + $maquinaria + $subcontratos + $gastos;

            $importe_new = $conceptoAgr['concepto']['variacion'] +
                $conceptoAgr['concepto']['materiales_monto_original'] +
                $conceptoAgr['concepto']['mano_obra_monto_original'] +
                $conceptoAgr['concepto']['herramienta_monto_original'] +
                $conceptoAgr['concepto']['maquinaria_monto_original'] +
                $conceptoAgr['concepto']['subcontratos_monto_original'] +
                $conceptoAgr['concepto']['gastos_monto_original'];


            $conceptoAgr['concepto']['importe_nuevo'] = $solicitud->id_estatus == 2 ? $importe_new - $conceptoAgr['concepto']['variacion'] : $importe_new;

            $itemC = Concepto::where('id_concepto', '=', $conceptoAgr['concepto']['id_concepto'])->first();

            $imporertAnt = $itemC->monto_presupuestado;
            //  dd($imporertAnt);
            $conceptoAgr['concepto']['importe_anterior'] = $solicitud->id_estatus == 2 ? ($conceptoAgr['concepto']['importe_nuevo'] - $conceptoAgr['concepto']['variacion']) : $imporertAnt;


            $conceptoAgr['concepto']['variacion'] = $conceptoAgr['concepto']['importe_nuevo'] - $conceptoAgr['concepto']['importe_anterior'];

            if ($solicitud->id_estatus == 2) {
                $concHA = SolicitudCambioPartidaHistorico::where('nivel', '=', $itemC->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();

                $h_mp_mat = SolicitudCambioPartidaHistorico::where('nivel', '=', $concMatOr->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();

                $h_mp_mano = SolicitudCambioPartidaHistorico::where('nivel', '=', $concManObr->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();
                $h_herr_equipo = SolicitudCambioPartidaHistorico::where('nivel', '=', $concHyEqOr->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();
                $h_maqui = SolicitudCambioPartidaHistorico::where('nivel', '=', $concMaqOr->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();

                $h_subcon = SolicitudCambioPartidaHistorico::where('nivel', '=', $concsSubOr->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();

               //dd($h_subcon);
                $h_gastos = SolicitudCambioPartidaHistorico::where('nivel', '=', $concGastOr->nivel)->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();

                $conceptoAgr['concepto']['materiales_monto_original'] = $h_mp_mat->monto_presupuestado_original;
                $conceptoAgr['concepto']['materiales_variacion'] = $h_mp_mat->monto_presupuestado_actualizado - $h_mp_mat->monto_presupuestado_original;
                $conceptoAgr['concepto']['mano_obra_monto_original'] = $h_mp_mano->monto_presupuestado_original;
                $conceptoAgr['concepto']['mano_obra_variacion'] = $h_mp_mano->monto_presupuestado_actualizado - $h_mp_mano->monto_presupuestado_original;
                $conceptoAgr['concepto']['herramienta_monto_original'] = $h_herr_equipo->monto_presupuestado_original;
                $conceptoAgr['concepto']['herramienta_variacion'] = $h_herr_equipo->monto_presupuestado_actualizado - $h_herr_equipo->monto_presupuestado_original;


                $conceptoAgr['concepto']['maquinaria_monto_original'] = $h_maqui->monto_presupuestado_original;
                $conceptoAgr['concepto']['maquinaria_variacion'] = $h_maqui->monto_presupuestado_actualizado - $h_maqui->monto_presupuestado_original;

                $conceptoAgr['concepto']['subcontratos_monto_original'] = $h_subcon->monto_presupuestado_original;
                $conceptoAgr['concepto']['subcontratos_variacion'] = $h_subcon->monto_presupuestado_actualizado - $h_subcon->monto_presupuestado_original;

                $conceptoAgr['concepto']['gastos_monto_original'] = $h_gastos->monto_presupuestado_original;
                $conceptoAgr['concepto']['gastos_variacion'] = $h_gastos->monto_presupuestado_actualizado - $h_gastos->monto_presupuestado_original;


                $conceptoAgr['concepto']['importe_anterior'] = $concHA->monto_presupuestado_original;
                $conceptoAgr['concepto']['importe_nuevo'] = $concHA->monto_presupuestado_actualizado;
                $conceptoAgr['concepto']['variacion'] = $concHA->monto_presupuestado_actualizado - $concHA->monto_presupuestado_original;
                // dd($conceptoAgr['concepto']['materiales_monto_original'] , $conceptoAgr['concepto']['materiales_variacion']);


            }


            $imp_anterior_gen += $conceptoAgr['concepto']['importe_anterior'];
            $imp_nuevo_gen += $conceptoAgr['concepto']['importe_nuevo'];
            $var_gen += $conceptoAgr['concepto']['variacion'];
            array_push($conceptosSol, $conceptoAgr);

        }

        $total_presupuesto_hist = $total_presupuesto_hist;
        if ($solicitud->id_estatus == 2) {

            $total_presupuesto = SolicitudCambioPartidaHistorico::where('nivel', '=', '000.001.')->where('id_partidas_insumos_agrupados', '=', $id_solicitud_historico)->first();
            $total_presupuesto_hist = $total_presupuesto->monto_presupuestado_actualizado - $var_gen;
        }

        $baseDatos = BasePresupuesto::find(3); ////validacion proforma
        $maximo_proforma = 0;
        foreach ($data as $conceptoAgr) {
            $afectaciones = [];
            $conceptoProforma = DB::connection('cadeco')->table($baseDatos->base_datos . ".dbo.conceptos")->where('clave_concepto', '=', $conceptoAgr['concepto']['clave_concepto'])->first();
            if (!$conceptoProforma) {
                //  throw new HttpResponseException(new Response('El concepto ' . $conceptoAgr['concepto']['descripcion']. ' no cuenta con clave de concepto registrada en ' . $baseDatos->base_datos, 404));
            } else {
                $montoProfC = $conceptoProforma->cantidad_presupuestada * $conceptoProforma->precio_unitario;
                $maximo_proforma += $montoProfC;
            }
        }

        $data = ['conceptos' => $conceptosSol,
            'imp_anterior_gen' => $imp_anterior_gen,
            'imp_nuevo_gen' => $imp_nuevo_gen,
            'total_presupuesto' => $total_presupuesto_hist,
            'total_variaciones' => $var_gen,
            'total_agrupados_nuevo' => $imp_nuevo_gen - $var_gen,
            'maximo_proforma' => ['maximo' => $maximo_proforma, 'diferencia' => ($maximo_proforma - $imp_nuevo_gen), 'variacion' => $var_gen]];


        return $data;
    }


}