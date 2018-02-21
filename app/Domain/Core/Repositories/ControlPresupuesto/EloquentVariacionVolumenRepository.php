<?php
/**
 * Created by PhpStorm.
 * User: JFESQUIVEL
 * Date: 16/02/2018
 * Time: 12:46 PM
 */

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\VariacionVolumenRepository;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\ControlPresupuesto\VariacionVolumen;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class EloquentVariacionVolumenRepository implements VariacionVolumenRepository
{
    /**
     * @var VariacionVolumen
     */
    private $model;

    /**
     * EloquentSolicitudCambioRepository constructor.
     * @param VariacionVolumen $model
     */
    public function __construct(VariacionVolumen $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Variación de Volúmen
     * @return VariacionVolumen
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Regresa las Variaciones de Volúmen Paginadas
     * @param array $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $data)
    {
        $query = $this->model->with(['tipoOrden', 'userRegistro', 'estatus']);
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    /**
     * Guarda un registro de Variación de Volúmen
     * @param array $data
     * @throws \Exception
     * @return VariacionVolumen
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $variacion_volumen = $this->model->create($data);

            foreach ($data['partidas'] as $partida) {

                if ($conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $partida['id_concepto'])->first()) {
                    $partida['id_tarjeta'] = $conceptoTarjeta->id_tarjeta;
                }

                $partida['cantidad_presupuestada_nueva'] = ($partida['cantidad_presupuestada_original'] + $partida['variacion_volumen']);
                $partida['id_solicitud_cambio'] = $variacion_volumen->id;
                $partida['id_tipo_orden'] = TipoOrden::VARIACION_VOLUMEN;

                SolicitudCambioPartida::create($partida);
            }

            foreach ($data['afectaciones'] as $index => $afectacion) {
                $variacion_volumen->aplicaciones()->attach([$afectacion => [
                    'registro' => auth()->id(),
                    'aplicada' => false
                ]]);
            }

            DB::connection('cadeco')->commit();

            return $this->model->find($variacion_volumen->id);
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Regresa un registro específico de Variación de Volúmen
     * @param $id
     * @return VariacionVolumen
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function with($relations)
    {
        $this->model->with($relations);
        return $this;
    }

    /**
     * Autoriza una Variación de Volúmen
     * @param $id
     * @param array $data
     * @return VariacionVolumen
     * @throws \Exception
     */
    public function autorizar($id, array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $variacion_volumen = $this->model->with('partidas')->find($id);

            // La solicitud ya está autorizada
            if ($variacion_volumen->id_estatus == Estatus::AUTORIZADA)
                throw new HttpResponseException(new Response('No se puede autorizar la solicitud porque ya se encuentra autorizada', 404));

            foreach ($data['afectaciones'] as $index => $afectacion) {
                $this->aplicar($variacion_volumen, $afectacion);
            }

            $variacion_volumen->id_estatus = Estatus::AUTORIZADA;
            $variacion_volumen->save();


            $data['id_solicitud_cambio'] = $id;
            SolicitudCambioAutorizada::create($data);

            DB::connection('cadeco')->commit();

            return $variacion_volumen;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Rechaza una Variación de Volúmen
     * @param $id
     * @param array $data
     * @throws \Exception
     * @return VariacionVolumen
     */
    public function rechazar($id, array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            if(! $variacion_volumen = $this->model->with('partidas')->find($id)) {
                throw new HttpResponseException(new Response('No existe la solicitud a rechazar', 404));
            }

            // La solicitud ya está rechazada
            if ($variacion_volumen->id_estatus == Estatus::RECHAZADA || $variacion_volumen->id_estatus == Estatus::AUTORIZADA) {
                throw new HttpResponseException(new Response('La solicitud no puede ser rechazada', 404));
            }

            $variacion_volumen->id_estatus = Estatus::RECHAZADA;
            $variacion_volumen->save();

            $data['id_solicitud_cambio'] = $id;
            SolicitudCambioRechazada::create($data);

            DB::connection('cadeco')->commit();

            return $variacion_volumen;
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Aplica una Variación de Volúmen a un Presupuesto
     * @param VariacionVolumen $variacionVolumen
     * @param $id_base_presupuesto
     * @return void
     * @throws \Exception
     */
    public function aplicar(VariacionVolumen $variacionVolumen, $id_base_presupuesto)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $db = BasePresupuesto::find($id_base_presupuesto);

            foreach ($variacionVolumen->partidas as $partida) {
                $conceptoSolicitud = Concepto::find($partida->id_concepto); ///concepto raiz para obtener la clave
                if ($conceptoSolicitud->clave_concepto == null) {
                    throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada', 404));
                    //////////////////////////////////// sin clave de concepto
                }

                $concepto = DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")->select('*')->where('clave_concepto', '=', $conceptoSolicitud->clave_concepto)->first();
                if (!$concepto) {
                    throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada en ' . $db->base_datos, 404));
                }

                $monto_presupuestado_original = $concepto->monto_presupuestado;

                $cantidad_presupuestada_original = $concepto->cantidad_presupuestada;
                $cantidad_presupuestada_actualizada = $cantidad_presupuestada_original + $partida->variacion_volumen;
                $factor = $cantidad_presupuestada_actualizada / $cantidad_presupuestada_original;

                //propagacion hacia abajo
                $conceptos_propagacion = DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")->where('nivel', 'like', $concepto->nivel . '%')->where('id_obra', '=', Context::getId())->orderBy('nivel', 'ASC')->get();

                $afectacion = 0;

                foreach ($conceptos_propagacion as $concepto_propagacion) {
                    if ($afectacion > 0) {
                        //Guardar un registro en una tabla de historicos para conservar la imagen de la solicitud en el momento de la autorización
                        SolicitudCambioPartidaHistorico::create([
                            'id_solicitud_cambio_partida' => $partida->id,
                            'id_base_presupuesto' => $db->id,
                            'nivel' => $concepto_propagacion->nivel,
                            'cantidad_presupuestada_original' => $concepto_propagacion->cantidad_presupuestada,
                            'cantidad_presupuestada_actualizada' => $concepto_propagacion->cantidad_presupuestada * $factor,
                            'monto_presupuestado_original' => $concepto_propagacion->monto_presupuestado,
                            'monto_presupuestado_actualizado' => $concepto_propagacion->monto_presupuestado * $factor
                        ]);

                        //Actualizar las cantidades en la base de datos del presupuesto
                        DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")
                            ->where('id_concepto', $concepto_propagacion->id_concepto)
                            ->update(['cantidad_presupuestada' => $concepto_propagacion->cantidad_presupuestada * $factor, 'monto_presupuestado' => $concepto_propagacion->monto_presupuestado * $factor]);

                    }
                    $afectacion++;
                }

                SolicitudCambioPartidaHistorico::create([
                    'id_solicitud_cambio_partida' => $partida->id,
                    'id_base_presupuesto' => $db->id,
                    'nivel' => $concepto->nivel,
                    'cantidad_presupuestada_original' => $concepto->cantidad_presupuestada,
                    'cantidad_presupuestada_actualizada' => $concepto->cantidad_presupuestada * $factor,
                    'monto_presupuestado_original' => $concepto->monto_presupuestado,
                    'monto_presupuestado_actualizado' => $concepto->monto_presupuestado * $factor
                ]);

                DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")
                    ->where('id_concepto', $concepto->id_concepto)
                    ->update(['cantidad_presupuestada' => $concepto->cantidad_presupuestada * $factor, 'monto_presupuestado' => $concepto->monto_presupuestado * $factor]);
                $conc = DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")->where('id_concepto', '=', $concepto->id_concepto)->where('id_obra', '=', Context::getId())->first();

                //propagacion hacia arriba monto

                $tamanioFaltante = strlen($conc->nivel);
                $afectacionConcepto = 0;

                while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba
                    $afectaConcepto = DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', '=', substr($conc->nivel, 0, $tamanioFaltante))->first();
                    if ($afectacionConcepto > 0) {///afectamos el concepto de la solicitud
                        $cantidadMonto = ($afectaConcepto->monto_presupuestado - $monto_presupuestado_original) + $conc->monto_presupuestado;

                        SolicitudCambioPartidaHistorico::create([
                            'id_solicitud_cambio_partida' => $partida->id,
                            'id_base_presupuesto' => $db->id,
                            'nivel' => $afectaConcepto->nivel,
                            'monto_presupuestado_original' => $afectaConcepto->monto_presupuestado,
                            'monto_presupuestado_actualizado' => $cantidadMonto
                        ]);


                        DB::connection('cadeco')->table($db->base_datos . ".dbo.conceptos")
                            ->where('id_concepto', $afectaConcepto->id_concepto)
                            ->update(['monto_presupuestado' => $cantidadMonto]);
                    }
                    $afectacionConcepto++;
                    $tamanioFaltante -= 4;
                }
            }

            if($aplicacion = $variacionVolumen->aplicaciones()->find($id_base_presupuesto)) {
                $variacionVolumen->aplicaciones()->updateExistingPivot($id_base_presupuesto, ['aplicada' => true]);
            } else {
                $variacionVolumen->aplicaciones()->attach([$id_base_presupuesto => [
                    'registro' => auth()->id(),
                    'aplicada' => true
                ]]);
            }
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }

    /**
     * Obtiene las bases de datos que afecta el tipo de solicitud Variación de Volumen
     * @return Collection | BasePresupuesto
     */
    public function getBasesAfectadas()
    {
        return BasePresupuesto::whereHas('tiposOrden', function ($query) {
            $query->where('id_tipo_orden', '=', TipoOrden::VARIACION_VOLUMEN);
        })->get();
    }
}
