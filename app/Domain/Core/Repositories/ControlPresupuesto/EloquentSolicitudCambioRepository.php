<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:04 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Core\Models\Concepto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoEscalatoria;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class EloquentSolicitudCambioRepository implements SolicitudCambioRepository
{
    /**
     * @var SolicitudCambio
     */
    protected $model;

    public function __construct(SolicitudCambio $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todos los registros de la SolicitudCambioPartida
     *
     * @return SolicitudCambio
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa todas las solicitudes de cambio
     * @return Collection | SolicitudCambio
     */

    public function paginate(array $data)
    {
        $query = $this->model->with(['tipoOrden', 'userRegistro', 'estatus']);
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de SolicitudCambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitudCambio = $this->model->create($data);
            DB::connection('cadeco')->commit();
            return $solicitudCambio;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Regresa un registro específico de SolicitudCambio
     * @param $id
     * @return SolicitudCambio
     */
    public function find($id)
    {
        $solicitudCambio = $this->model->find($id);
        return $solicitudCambio;
    }

    public function saveVariacionVolumen(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->create($data);
            foreach ($data['partidas'] as $partida) {
                $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $partida['id_concepto'])->first();
                if ($conceptoTarjeta) {
                    $partida['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                }
                $partida['cantidad_presupuestada_nueva'] = ($partida['cantidad_presupuestada_original'] + $partida['variacion_volumen']);
                $partida['id_solicitud_cambio'] = $solicitud->id;
                $partida['id_tipo_orden'] = TipoOrden::VARIACION_VOLUMEN;
                $partida = SolicitudCambioPartida::create($partida);
            }

            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    public function saveEscalatoria(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->create($data);
            foreach ($data['partidas'] as $partida) {
                $partida['id_solicitud_cambio'] = $solicitud->id;
                $partida['id_tipo_orden'] = TipoOrden::ESCALATORIA;
                SolicitudCambioPartida::create($partida);
            }
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Autoriza una solicitud de cambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function autorizarVariacionVolumen($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();


            $solicitud = $this->model->with('partidas')->find($id);
            $basesAfectadas = AfectacionOrdenesPresupuesto::with('baseDatos')->where('id_tipo_orden', '=', $solicitud->id_tipo_orden)->get();


            foreach ($solicitud->partidas as $partida) {

                $conceptoSolicitud = Concepto::find($partida->id_concepto); ///concepto raiz para obtener la clave
                //  echo "A-".$concepto->clave_concepto;
                if ($conceptoSolicitud->clave_concepto == null) {
                    throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada', 404));
                    //////////////////////////////////// sin clave de concepto
                }
                foreach ($basesAfectadas as $basePresupuesto) { /////////seleccionamos el tipo de presupuesto a afectar
                    $concepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('clave_concepto', '=', $conceptoSolicitud->clave_concepto)->first();
                    if (!$concepto) {
                        throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada en ' . $basePresupuesto->baseDatos->base_datos, 404));

                    }
                    $montoAnterior = $concepto->monto_presupuestado;

                    $factor = ($partida->cantidad_presupuestada_nueva / $concepto->cantidad_presupuestada);
                    $concepto->cantidad_presupuestada = $partida->cantidad_presupuestada_nueva;
                    $concepto->monto_presupuestado = $concepto->monto_presupuestado * $factor;

                    //propagacion hacia abajo
                    $conceptosPropagacion = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('nivel', 'like', $concepto->nivel . '%')->where('id_obra', '=', Context::getId())->get();
                    $afectacion = 0;
                    foreach ($conceptosPropagacion as $conceptoPropagacion) {

                        $conceptoPropagacion->cantidad_presupuestada = $conceptoPropagacion->cantidad_presupuestada * $factor;
                        $conceptoPropagacion->monto_presupuestado = $conceptoPropagacion->monto_presupuestado * $factor;
                        if ($afectacion > 0) {
                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $conceptoPropagacion->id_concepto)
                                ->update(['cantidad_presupuestada' => $conceptoPropagacion->cantidad_presupuestada, 'monto_presupuestado' => $conceptoPropagacion->monto_presupuestado]);
                            // $conc = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_concepto', '=', $conceptoPropagacion->id_concepto)->first();
                        }
                        $afectacion++;

                        //echo "cp->" . $conceptoPropagacion->id_concepto;
                    }

                    DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                        ->where('id_concepto', $concepto->id_concepto)
                        ->update(['cantidad_presupuestada' => $concepto->cantidad_presupuestada, 'monto_presupuestado' => $concepto->monto_presupuestado]);
                    $conc = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_concepto', '=', $concepto->id_concepto)->where('id_obra', '=', Context::getId())->first();

                    //propagacion hacia arriba monto

                    $tamanioFaltante = strlen($conc->nivel);
                    $afectacionConcepto = 0;

                    while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba
                        $afectaConcepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', '=', substr($conc->nivel, 0, $tamanioFaltante))->first();
                        if ($afectacionConcepto > 0) {///afectamos el concepto de la solicitud
                            $cantidadMonto = ($afectaConcepto->monto_presupuestado - $montoAnterior) + $conc->monto_presupuestado;
                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $conc->id_concepto)
                                ->update(['monto_presupuestado' => $cantidadMonto]);
                        }
                        $afectacionConcepto++;
                        $tamanioFaltante -= 4;
                    }
                }

            }

            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();
            $data = ["id_solicitud_cambio" => $id];
            $solicitudCambio = SolicitudCambioAutorizada::create($data);
            $solicitud = $this->model->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($id);
            $solicitud['cobrabilidad'] = $solicitud->tipoOrden->cobrabilidad;


            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }


    /**
     * Rechaza una solicitud de cambio
     * @param array $data
     * @throws \Exception
     * @return SolicitudCambio
     */
    public function rechazarVariacionVolumen(array $data)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            $solicitud = $this->model->with('partidas')->find($data['id_solicitud_cambio']);
            $solicitud->id_estatus = Estatus::RECHAZADA;
            // $data = ["id_solicitud_cambio" => $data['id'],"motivo"=>$data['motivo']];
            $solicitudCambio = SolicitudCambioRechazada::create($data);
            $solicitud->save();
            $solicitud = $this->model->with(['tipoOrden', 'userRegistro', 'estatus', 'partidas', 'partidas.concepto', 'partidas.numeroTarjeta'])->find($data['id_solicitud_cambio']);
            $solicitud['cobrabilidad'] = $solicitud->tipoOrden->cobrabilidad;

            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }

    public function saveCambioInsumos(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->create($data);

            foreach ($data['agrupadas'] as $conceptoAgrupado) { /////////partidas agrupadas
                $partidaInsumo['id_solicitud_cambio'] = $solicitud->id;
                $partidaInsumo['id_concepto'] = $conceptoAgrupado;
                PartidasInsumosAgrupados::create($partidaInsumo);
            }

            foreach ($data['partidas'] as $partida) {


                $cantidad_presupuestada_concepto=$partida['cobrable']['cantidad_presupuestada'];






                ////////impacto materiales
                if (array_key_exists('insumos', $partida['conceptos']['MATERIALES'])) {
                    foreach ($partida['conceptos']['MATERIALES']['insumos'] as $material) {

                        if (isset($material['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $material['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $material['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }

                        $material['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $material['id_solicitud_cambio'] = $solicitud->id;
                        $material['precio_unitario_original'] = $material['precio_unitario'];
                        $existe = true;
                        array_key_exists('precio_unitario_nuevo', $material) ? $material['precio_unitario_nuevo'] = $material['precio_unitario_nuevo'] : '';
                        array_key_exists('cantidad_presupuestada_nueva', $material) ? $material['cantidad_presupuestada_nueva'] = $material['cantidad_presupuestada_nueva'] : '';

                        $material['cantidad_presupuestada_original'] = $material['cantidad_presupuestada']*$cantidad_presupuestada_concepto;
                       // $material['cantidad_presupuestada_nueva'] = $material['cantidad_presupuestada_nueva'];

                        if (array_key_exists('precio_unitario_nuevo', $material) || array_key_exists('cantidad_presupuestada_nueva', $material)) {
                            SolicitudCambioPartida::create($material);
                        }
                    }
                }
                ////////impacto Mano obra
                if (array_key_exists('insumos', $partida['conceptos']['MANOOBRA'])) {
                    foreach ($partida['conceptos']['MANOOBRA']['insumos'] as $mano) {
                        if (isset($mano['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $mano['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $mano['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $mano['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $mano['id_solicitud_cambio'] = $solicitud->id;
                        $mano['precio_unitario_original'] = $material['precio_unitario'];
                        $existe = true;
                        array_key_exists('precio_unitario_nuevo', $material) ? $mano['precio_unitario_nuevo'] = $mano['precio_unitario_nuevo'] : '';
                        array_key_exists('cantidad_presupuestada_nueva', $material) ? $mano['cantidad_presupuestada_nueva'] = $mano['cantidad_presupuestada_nueva'] : '';

                        $mano['cantidad_presupuestada_original'] = $mano['cantidad_presupuestada']*$cantidad_presupuestada_concepto;
                      //  $mano['cantidad_presupuestada_nueva'] = $mano['cantidad_presupuestada_nueva'];

                        if (array_key_exists('precio_unitario_nuevo', $mano) || array_key_exists('cantidad_presupuestada_nueva', $mano)) {
                            SolicitudCambioPartida::create($mano);
                        }
                    }
                }
                ////////impacto Herramienta y equipo
                if (array_key_exists('insumos', $partida['conceptos']['HERRAMIENTAYEQUIPO'])) {
                    foreach ($partida['conceptos']['HERRAMIENTAYEQUIPO']['insumos'] as $herramienta) {
                        if (isset($herramienta['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $herramienta['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $herramienta['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $herramienta['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $herramienta['id_solicitud_cambio'] = $solicitud->id;
                        $herramienta['precio_unitario_original'] = $material['precio_unitario'];
                        $existe = true;
                        array_key_exists('precio_unitario_nuevo', $material) ? $herramienta['precio_unitario_nuevo'] = $herramienta['precio_unitario_nuevo'] : '';
                        array_key_exists('cantidad_presupuestada_nueva', $material) ? $herramienta['cantidad_presupuestada_nueva'] = $herramienta['cantidad_presupuestada_nueva'] : '';

                        $herramienta['cantidad_presupuestada_original'] = $herramienta['cantidad_presupuestada']*$cantidad_presupuestada_concepto;
                      //  $herramienta['cantidad_presupuestada_nueva'] = $herramienta['cantidad_presupuestada_nueva'];

                        if (array_key_exists('precio_unitario_nuevo', $herramienta) || array_key_exists('cantidad_presupuestada_nueva', $herramienta)) {
                            SolicitudCambioPartida::create($herramienta);
                        }
                    }
                }

                ////////impacto Maquinaria

                if (array_key_exists('insumos', $partida['conceptos']['MAQUINARIA'])) {
                    foreach ($partida['conceptos']['MAQUINARIA']['insumos'] as $maquinaria) {
                        if (isset($maquinaria['id_concepto'])) {
                            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $maquinaria['id_concepto'])->first();
                            if ($conceptoTarjeta) {
                                $maquinaria['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                            }
                        }
                        $maquinaria['id_tipo_orden'] = TipoOrden::ORDEN_DE_CAMBIO_DE_INSUMOS;
                        $maquinaria['id_solicitud_cambio'] = $solicitud->id;
                        $maquinaria['precio_unitario_original'] = $material['precio_unitario'];
                        $existe = true;
                        array_key_exists('precio_unitario_nuevo', $material) ? $maquinaria['precio_unitario_nuevo'] = $maquinaria['precio_unitario_nuevo'] : '';
                        array_key_exists('cantidad_presupuestada_nueva', $material) ? $maquinaria['cantidad_presupuestada_nueva'] = $maquinaria['cantidad_presupuestada_nueva'] : '';

                        $maquinaria['cantidad_presupuestada_original'] = $maquinaria['cantidad_presupuestada']*$cantidad_presupuestada_concepto;
                       // $maquinaria['cantidad_presupuestada_nueva'] = $maquinaria['cantidad_presupuestada_nueva'];

                        if (array_key_exists('precio_unitario_nuevo', $maquinaria) || array_key_exists('cantidad_presupuestada_nueva', $maquinaria)) {
                            SolicitudCambioPartida::create($maquinaria);
                        }


                    }
                }
            }

            //   dd($solicitud);
            $solicitud = $this->with('partidas')->find($solicitud->id);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch
        (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

}