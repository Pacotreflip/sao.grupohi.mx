<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 12:04 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Models\Concepto;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\SolicitudCambioRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Illuminate\Support\Facades\DB;


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
                $conceptoTarjeta=ConceptoTarjeta::where('id_concepto','=',$partida['id_concepto'])->first();
                if($conceptoTarjeta){
                    $partida['id_tarjeta']=$conceptoTarjeta->id;
                }
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
            ///

            foreach ($solicitud->partidas as $partida) {
                $concepto = Concepto::find($partida->id_concepto);
                $tamanioFaltante = strlen($concepto->nivel);
                $propagacionMonto = 0;
                $propagacionCantidadPresupuestada = 0;
                $afectacionConcepto = 0;

                while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba

                   // echo substr($concepto->nivel, 0, $tamanioFaltante) . "<br>";
                    $afectaConcepto = Concepto::where('nivel', '=', substr($concepto->nivel, 0, $tamanioFaltante))->first();

                    if ($afectacionConcepto == 0) {///afectamos el concepto de la solicitud
                        $cantidadNueva = $partida->cantidad_presupuestada_nueva;
                        $cantidadAnterior = $afectaConcepto->cantidad_presupuestada;
                        $factor = $cantidadNueva / $cantidadAnterior;
                        $montoNuevo = $factor * $afectaConcepto->monto_presupuestado;

                        /////////Actualizamos concepto
                        $afectaConcepto->cantidad_presupuestada = $partida->cantidad_presupuestada_nueva;
                        $afectaConcepto->monto_presupuestado = $montoNuevo;

                        $propagacionMonto += $afectaConcepto->monto_presupuestado;
                        $propagacionCantidadPresupuestada += $afectaConcepto->cantidad_presupuestada;
                        $afectacionConcepto=1;
                    } else {//Creamos propagacion hacia niveles altos
                        $afectaConcepto->cantidad_presupuestada = ($afectaConcepto->cantidad_presupuestada + $propagacionCantidadPresupuestada);
                        $afectaConcepto->monto_presupuestado = ($afectaConcepto->monto_presupuestado + $propagacionMonto);
                    }
                    $afectaConcepto->save();
                    $tamanioFaltante -= 4;
                }
            }


            /////guardamos la solicitud autorizada
            $data = ["id_solicitud_cambio" => $id];
            $solicitudCambio = SolicitudCambioAutorizada::create($data);


            dd("termino", $solicitudCambio);
            DB::connection('cadeco')->commit();
            return $solicitud;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

    }


}