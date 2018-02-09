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
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
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

    public function saveEscalatoria(array $data) {
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

    public function autorizarEscalatoria($id)
    {
        $solicitud = $this->model->with('partidas')->find($id);

        try{
            DB::connection('cadeco')->beginTransaction();

            // No existe la solicitud
            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud', 404));

            // La solicitud ya está autorizada
            if ($solicitud->id_estatus == Estatus::AUTORIZADA)
                throw new HttpResponseException(new Response('La solicitud ya está autorizada', 404));

            $basesAfectadas = AfectacionOrdenesPresupuesto::with('baseDatos')->where('id_tipo_orden', '=', $solicitud->id_tipo_orden)->get();

            foreach ($solicitud->partidas as $partida)
                foreach ($basesAfectadas as $k => $basePresupuesto)
                {
                    // Revisa si ya existe una escalatoria
                    $escalatoria = ConceptoEscalatoria::select('*')->first();
                    $concepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('descripcion', 'like', '%costo directo%')->first();

                    if (is_null($concepto))
                        throw new HttpResponseException(new Response('No se encontró el concepto costo directo', 404));

                    // No existe registro
                    if (is_null($escalatoria))
                    {
                        $max_nivel =  DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->selectRaw('max(nivel) as max_nivel')->whereraw("nivel like '". $concepto->nivel ."___.'")->first();

                        // El concepto no tiene hijos
                        if (is_null($max_nivel))
                            $nuevo_nivel = $concepto->nivel .'001.';

                        // Incrementa
                        else
                        {
                            $ultimos_numeros = str_replace('.', '', substr($max_nivel->max_nivel, -4));
                            $nuevo_nivel = $concepto->nivel . str_pad($ultimos_numeros + 1, 3, 0, STR_PAD_LEFT) .'.';
                        }

                        // Registra el concepto escalatoria
                        $concepto_escalatoria = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->insert([
                            'id_obra' => Context::getId(),
                            'nivel' => $nuevo_nivel,
                            'descripcion' => 'ESCALATORIAS',
                        ]);

                        if (!$concepto_escalatoria)
                            throw new HttpResponseException(new Response('No se creo el concepto ESCALATORIAS', 404));

                        $concepto_escalatoria = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('nivel', 'like', $nuevo_nivel)->first();

                        if (is_null($concepto_escalatoria))
                            throw new HttpResponseException(new Response('No se creo el registro concepto escalatoria', 404));

                        // Registra el "hijo" ESCALATORIA
                        $nuevo_nivel_hijo = $nuevo_nivel .'001.';
                        $concepto_escalatoria_hijo = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->insert([
                            'id_obra' => Context::getId(),
                            'nivel' => $nuevo_nivel_hijo,
                            'descripcion' => 'ESCALATORIAS',
                        ]);

                        if (!$concepto_escalatoria_hijo)
                            throw new HttpResponseException(new Response('No se creo el registro concepto escalatoria', 404));

                        // Obtiene el concepto escalatoria hijo
                        $concepto_escalatoria_hijo = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('nivel', 'like', $nuevo_nivel_hijo)->first();

                        $escalatoria = ConceptoEscalatoria::create([
                            'id_concepto' => $concepto_escalatoria->id_concepto,
                        ]);

                        if (is_null($escalatoria))
                            throw new HttpResponseException(new Response('No se creo el registro concepto escalatoria', 404));
                    }

                    // Obtiene el concepto escalatoria
                    else
                    {
                        $concepto_escalatoria = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('id_concepto', '=', $escalatoria->id_concepto)->first();
                        $concepto_escalatoria_hijo = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('nivel', 'like', $concepto_escalatoria->nivel .'___.')->first();
                    }

                    // Registra el concepto de la partida
                    $concepto_escalatoria_hijo_max_nivel =  DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->selectRaw('max(nivel) as max_nivel')->whereraw("nivel like '". $concepto_escalatoria_hijo->nivel ."___.'")->first();

                    // El concepto escalatoria hijo no tiene hijos
                    if (is_null($concepto_escalatoria_hijo_max_nivel))
                        $concepto_partida_nivel = $concepto_escalatoria_hijo->nivel .'001.';

                    else
                    {
                        $concepto_escalatoria_hijo_ultimos_numeros = str_replace('.', '', substr($concepto_escalatoria_hijo_max_nivel->max_nivel, -4));
                        $concepto_partida_nivel = $concepto_escalatoria_hijo->nivel . str_pad($concepto_escalatoria_hijo_ultimos_numeros + 1, 3, 0, STR_PAD_LEFT) .'.';
                    }

                    // Inserta el nuevo concepto
                    $concepto_partida = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->insert([
                        'id_obra' => Context::getId(),
                        'nivel' => $concepto_partida_nivel,
                        'descripcion' => $partida->descripcion,
                    ]);
                }

            // Actualiza el estatus de la solicitud
            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();

            // Inserta registro autorizó
            $autorizo = SolicitudCambioAutorizada::create([
                'id_solicitud_cambio' => $solicitud->id
            ]);

            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }

        return $solicitud;
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

                    //propagacion hacia abajo
                    $conceptosPropagacion =
                        DB::connection('cadeco')
                            ->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                            ->where('nivel', 'like', $concepto->nivel . '%')
                            ->where('id_obra', '=', Context::getId())
                            ->orderBy('nivel')
                            ->get();

                    $afectacion = 0;
                    foreach ($conceptosPropagacion as $conceptoPropagacion) {
                        if ($afectacion > 0) {
                            //Guardar un registro en una tabla de historicos para conservar la imagen de la solicitud en el momento de la autorización
                            SolicitudCambioPartidaHistorico::create([
                                'id_solicitud_cambio_partida' => $partida->id,
                                'id_base_presupuesto' => $basePresupuesto->id_base_presupuesto,
                                'nivel' => $conceptoPropagacion->nivel,
                                'cantidad_presupuestada_original' => $conceptoPropagacion->cantidad_presupuestada,
                                'cantidad_presupuestada_actualizada' => $conceptoPropagacion->cantidad_presupuestada * $factor,
                                'monto_presupuestado_original' => $conceptoPropagacion->monto_presupuestado,
                                'monto_presupuestado_actualizado' => $conceptoPropagacion->monto_presupuestado * $factor
                            ]);

                            //Actualizar las cantidades en la base de datos del presupuesto


                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $conceptoPropagacion->id_concepto)
                                ->update(['cantidad_presupuestada' => $conceptoPropagacion->cantidad_presupuestada * $factor, 'monto_presupuestado' => $conceptoPropagacion->monto_presupuestado * $factor]);

                        }
                        $afectacion++;
                    }

                    SolicitudCambioPartidaHistorico::create([
                        'id_solicitud_cambio_partida' => $partida->id,
                        'id_base_presupuesto' => $basePresupuesto->id_base_presupuesto,
                        'nivel' => $concepto->nivel,
                        'cantidad_presupuestada_original' => $concepto->cantidad_presupuestada,
                        'cantidad_presupuestada_actualizada' => $concepto->cantidad_presupuestada * $factor,
                        'monto_presupuestado_original' => $concepto->monto_presupuestado,
                        'monto_presupuestado_actualizado' => $concepto->monto_presupuestado * $factor
                    ]);

                    DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                        ->where('id_concepto', $concepto->id_concepto)
                        ->update(['cantidad_presupuestada' => $concepto->cantidad_presupuestada * $factor, 'monto_presupuestado' => $concepto->monto_presupuestado * $factor]);
                    $conc = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_concepto', '=', $concepto->id_concepto)->where('id_obra', '=',Context::getId())->first();

                    //propagacion hacia arriba monto

                    $tamanioFaltante = strlen($conc->nivel);
                    $afectacionConcepto = 0;

                    while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba
                        $afectaConcepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=',Context::getId())->where('nivel', '=', substr($conc->nivel, 0, $tamanioFaltante))->first();
                        if ($afectacionConcepto > 0) {///afectamos el concepto de la solicitud
                            $cantidadMonto = ($afectaConcepto->monto_presupuestado - $montoAnterior) + $conc->monto_presupuestado;

                            SolicitudCambioPartidaHistorico::create([
                                'id_solicitud_cambio_partida' => $partida->id,
                                'id_base_presupuesto' => $basePresupuesto->id_base_presupuesto,
                                'nivel' => $afectaConcepto->nivel,
                                'monto_presupuestado_original' => $afectaConcepto->monto_presupuestado,
                                'monto_presupuestado_actualizado' => $cantidadMonto
                            ]);

                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $afectaConcepto->id_concepto)
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
        } catch (\Exception $e) {
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

    public function rechazarEscalatoria(array $data)
    {
        try {

            DB::connection('cadeco')->beginTransaction();
            $solicitud = $this->model->with('partidas')->find($data['id_solicitud_cambio']);

            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud a rechazar', 404));

            $solicitud->id_estatus = Estatus::RECHAZADA;
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
}