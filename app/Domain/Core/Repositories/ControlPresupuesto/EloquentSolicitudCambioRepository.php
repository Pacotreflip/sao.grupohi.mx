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
use Ghi\Domain\Core\Models\ControlPresupuesto\BasePresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoEscalatoria;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoTarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\PartidasInsumosAgrupados;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambio;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Database\Eloquent\Collection;
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
        if (!$solicitudCambio = $this->model->find($id)) {
            throw new HttpResponseException(new Response('No se encontró la solicitud', 404));
        }
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

            foreach ($data['afectaciones'] as $index => $afectacion) {
                $solicitud->aplicaciones()->attach([$afectacion => [
                    'registro' => auth()->id(),
                    'aplicada' => false
                ]]);
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

    public function autorizarEscalatoria($id)
    {
        $solicitud = $this->model->with('partidas')->find($id);

        try {
            DB::connection('cadeco')->beginTransaction();

            // No existe la solicitud
            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud', 404));

            // La solicitud ya está autorizada
            if ($solicitud->id_estatus == Estatus::AUTORIZADA)
                throw new HttpResponseException(new Response('La solicitud ya está autorizada', 404));

            $basesAfectadas = AfectacionOrdenesPresupuesto::with('baseDatos')->where('id_tipo_orden', '=', $solicitud->id_tipo_orden)->get();

            foreach ($solicitud->partidas as $partida)
                foreach ($basesAfectadas as $k => $basePresupuesto) {
                    // Revisa si ya existe una escalatoria
                    $escalatoria = ConceptoEscalatoria::select('*')->first();
                    $concepto = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('descripcion', 'like', '%costo directo%')->first();

                    if (is_null($concepto))
                        throw new HttpResponseException(new Response('No se encontró el concepto costo directo', 404));

                    // No existe registro
                    if (is_null($escalatoria)) {
                        $max_nivel = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->selectRaw('max(nivel) as max_nivel')->whereraw("nivel like '" . $concepto->nivel . "___.'")->first();

                        // El concepto no tiene hijos
                        if (is_null($max_nivel))
                            $nuevo_nivel = $concepto->nivel . '001.';

                        // Incrementa
                        else {
                            $ultimos_numeros = str_replace('.', '', substr($max_nivel->max_nivel, -4));
                            $nuevo_nivel = $concepto->nivel . str_pad($ultimos_numeros + 1, 3, 0, STR_PAD_LEFT) . '.';
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
                        $nuevo_nivel_hijo = $nuevo_nivel . '001.';
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
                    } // Obtiene el concepto escalatoria
                    else {
                        $concepto_escalatoria = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('id_concepto', '=', $escalatoria->id_concepto)->first();
                        $concepto_escalatoria_hijo = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->select('*')->where('nivel', 'like', $concepto_escalatoria->nivel . '___.')->first();
                    }

                    // Registra el concepto de la partida
                    $concepto_escalatoria_hijo_max_nivel = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->selectRaw('max(nivel) as max_nivel')->whereraw("nivel like '" . $concepto_escalatoria_hijo->nivel . "___.'")->first();

                    // El concepto escalatoria hijo no tiene hijos
                    if (is_null($concepto_escalatoria_hijo_max_nivel))
                        $concepto_partida_nivel = $concepto_escalatoria_hijo->nivel . '001.';

                    else {
                        $concepto_escalatoria_hijo_ultimos_numeros = str_replace('.', '', substr($concepto_escalatoria_hijo_max_nivel->max_nivel, -4));
                        $concepto_partida_nivel = $concepto_escalatoria_hijo->nivel . str_pad($concepto_escalatoria_hijo_ultimos_numeros + 1, 3, 0, STR_PAD_LEFT) . '.';
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

    public function aplicarVariacionVolumen($solicitud, $id_base_presupuesto) {
        $db = BasePresupuesto::find($id_base_presupuesto);

        foreach ($solicitud->partidas as $partida) {
            $conceptoSolicitud = Concepto::find($partida->id_concepto); ///concepto raiz para obtener la clave
            if ($conceptoSolicitud->clave_concepto == null) {
                throw new HttpResponseException(new Response('El concepto ' . $conceptoSolicitud->descripcion . ' no cuenta con clave de concepto registrada', 404));
                //////////////////////////////////// sin clave de concepto
            }
            //foreach ($basesAfectadas as $basePresupuesto) { /////////seleccionamos el tipo de presupuesto a afectar
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
            //}
        }

        if($aplicacion = $solicitud->aplicaciones()->find($id_base_presupuesto)) {
            $solicitud->aplicaciones()->updateExistingPivot($id_base_presupuesto, ['aplicada' => true]);
        } else {
            $solicitud->aplicaciones()->attach([$id_base_presupuesto => [
                'registro' => auth()->id(),
                'aplicada' => true
            ]]);
        }
    }

    /**
     * Autoriza una solicitud de cambio
     * @param $id
     * @param array $data
     * @return SolicitudCambio
     * @throws \Exception
     */
    public function  autorizarVariacionVolumen($id, array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $solicitud = $this->model->with('partidas')->find($id);

            // La solicitud ya está autorizada
            if ($solicitud->id_estatus == Estatus::AUTORIZADA)
                throw new HttpResponseException(new Response('La solicitud ya está autorizada', 404));

            foreach ($data['afectaciones'] as $index => $afectacion) {
                $this->aplicarVariacionVolumen($solicitud, $afectacion);
            }

            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();

            $data = ["id_solicitud_cambio" => $id];
            SolicitudCambioAutorizada::create($data);

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

            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud a rechazar', 404));

            // La solicitud ya está rechazada
            if ($solicitud->id_estatus == Estatus::RECHAZADA)
                throw new HttpResponseException(new Response('La solicitud ya está rechazada', 404));

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

            // La solicitud ya está rechazada
            if ($solicitud->id_estatus == Estatus::RECHAZADA)
                throw new HttpResponseException(new Response('La solicitud ya está rechazada', 404));


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

                $cantidad_presupuestada_concepto = $partida['cobrable']['cantidad_presupuestada'];

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
                        array_key_exists('precio_unitario_nuevo', $material) ? $material['precio_unitario_nuevo'] = $material['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $material) ? $material['rendimiento_nuevo'] = $material['rendimiento_nuevo'] : '';
                        $material['rendimiento_original'] = $material['rendimiento_actual'];

                        //  dd($material['rendimiento_nuevo']);
                        if (array_key_exists('precio_unitario_nuevo', $material) || array_key_exists('rendimiento_nuevo', $material)) {
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
                        $mano['precio_unitario_original'] = $mano['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $mano) ? $mano['precio_unitario_nuevo'] = $mano['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $mano) ? $mano['rendimiento_nuevo'] = $mano['rendimiento_nuevo'] : '';
                        $mano['rendimiento_original'] = $mano['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $mano) || array_key_exists('rendimiento_nuevo', $mano)) {
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
                        $herramienta['precio_unitario_original'] = $herramienta['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $herramienta) ? $herramienta['precio_unitario_nuevo'] = $herramienta['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $herramienta) ? $herramienta['rendimiento_nuevo'] = $herramienta['rendimiento_nuevo'] : '';
                        $herramienta['rendimiento_original'] = $herramienta['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $herramienta) || array_key_exists('rendimiento_nuevo', $herramienta)) {
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
                        $maquinaria['precio_unitario_original'] = $maquinaria['precio_unitario'];
                        array_key_exists('precio_unitario_nuevo', $maquinaria) ? $maquinaria['precio_unitario_nuevo'] = $maquinaria['precio_unitario_nuevo'] : '';
                        array_key_exists('rendimiento_nuevo', $maquinaria) ? $maquinaria['rendimiento_nuevo'] = $maquinaria['rendimiento_nuevo'] : '';
                        $maquinaria['rendimiento_original'] = $maquinaria['rendimiento_actual'];

                        if (array_key_exists('precio_unitario_nuevo', $maquinaria) || array_key_exists('rendimiento_nuevo', $maquinaria)) {
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

    public function autorizarCambioInsumos($id)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $sumas_insumos = 0;

            $insumosAgrupados = PartidasInsumosAgrupados::where('id_solicitud_cambio', '=', $id)->get();
            $conceptoTarjeta = ConceptoTarjeta::where('id_concepto', '=', $insumosAgrupados[0]->id_concepto)->first();
            //////////////generamos nueva tarjeta
            $tarjeta = Tarjeta::find($conceptoTarjeta->id_tarjeta);
            $numAux = 0;
            for ($num = 1; ; $num++) {
                $tarjetaNueva = Tarjeta::where('descripcion', '=', $tarjeta->descripcion . '-' . $num)->get();
                $numAux = $num;
                if (count($tarjetaNueva) == 0) {
                    break;
                }
            }
            $tarjetaNueva = $tarjeta->descripcion . '-' . ($numAux);
            $nuevaTarjeta = Tarjeta::create(['descripcion' => $tarjetaNueva]);


            foreach ($insumosAgrupados as $insumo) {

                $partidas = SolicitudCambioPartida::with('material')->where('id_solicitud_cambio', '=', $id)->get();
                $concepto = Concepto::find($insumo['id_concepto']);

                $materiales = [];
                $mano_obra = [];
                $herramienta = [];
                $maquinaria = [];
                $data = [];
                $tarjeta_id = 0;
                foreach ($partidas as $partida) {
                    $tarjeta_id = $partida->id_tarjeta;
                    if ($partida['rendimiento_nuevo'] != null) {
                        $partida['cantidad_presupuestada'] = $partida['rendimiento_nuevo'] * $concepto->cantidad_presupuestada;
                    } else {
                        $item = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_material', '=', $partida['id_material'])->first();
                        $partida['cantidad_presupuestada'] = $item->cantidad_presupuestada;
                    }
                    if ($partida['precio_unitario_nuevo'] != null) {
                        $partida['precio_unitario_original'] = $partida['precio_unitario_original'];
                        $partida['precio_unitario_nuevo'] = $partida['precio_unitario_nuevo'];
                        $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_nuevo'];
                    } else {
                        $partida['precio_unitario_nuevo'] = 0;
                        $partida['monto_presupuestado'] = $partida['cantidad_presupuestada'] * $partida['precio_unitario_original'];
                    }


                    $conceptoReset = Concepto::where('nivel', 'like', $concepto->nivel . '%')->where('id_material', '=', $partida->id_material)->first();
                    if ($conceptoReset) {
                        $partida->id_concepto = $conceptoReset->id_concepto;
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


                foreach ($materiales as $material) ////integracion materiales tarjeta nueva
                {

                    if ($material->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($material->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $material['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($material['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $material['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();
                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $material->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);


                    } else { ////nuevo concepto generar nuevo nivel
                        $dataHist = [];
                        $conceptoMaterial = Concepto::where('descripcion', '=', 'MATERIALES')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $material->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $material->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $material->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $material->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($material->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $material->precio_unitario_nuevo,
                            "precio_unitario" => $material->precio_unitario_nuevo,

                        ];
                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);

                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $material->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);


                        //  dd($nuevoInsumo);

                    }
                }

                foreach ($mano_obra as $manoObra) ////integracion materiales tarjeta nueva
                {
                    if ($manoObra->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($manoObra->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $manoObra['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($manoObra['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $manoObra['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $manoObra->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'MANO OBRA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $manoObra->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $manoObra->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $manoObra->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $manoObra->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($manoObra->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $manoObra->precio_unitario_nuevo,
                            "precio_unitario" => $manoObra->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $manoObra->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    }
                }
                ///cambio nueva tarjeta

                foreach ($herramienta as $herram) ////integracion materiales tarjeta nueva
                {
                    if ($herram->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($herram->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $herram['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($herram['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $herram['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();

                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $herram->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $herram->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $herram->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $herram->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $herram->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($herram->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $herram->precio_unitario_nuevo,
                            "precio_unitario" => $herram->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $herram->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    }
                }

                foreach ($maquinaria as $maquina) ////integracion materiales tarjeta nueva
                {
                    if ($maquina->id_concepto) { ////actualizacion de concepto
                        $dataHist = [];
                        $conceptoUpdate = Concepto::find($maquina->id_concepto);
                        $conceptoUpdate->cantidad_presupuestada = $maquina['cantidad_presupuestada']; //cambio cantidad presupuestada
                        if ($maquina['precio_unitario_nuevo'] > 0) {
                            $dataHist['precio_unitario_original'] = $conceptoUpdate->precio_unitario;
                            $conceptoUpdate->precio_unitario = $maquina['precio_unitario_nuevo'];
                            $dataHist['precio_unitario_actualizado'] = $conceptoUpdate->precio_unitario;
                        }

                        $dataHist['monto_presupuestado_original'] = $conceptoUpdate->monto_presupuestado;
                        $conceptoUpdate->monto_presupuestado = $conceptoUpdate->cantidad_presupuestada * $conceptoUpdate->precio_unitario;
                        $conceptoUpdate->save();
                        $dataHist['monto_presupuestado_actualizado'] = $conceptoUpdate->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $maquina->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $conceptoUpdate->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);

                    } else { ////nuevo concepto generar nuevo nivel

                        $conceptoMaterial = Concepto::where('descripcion', '=', 'MAQUINARIA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                        $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '%')->get();

                        $total = count($totalInsumos);
                        $ceros = 3 - strlen($total);
                        $nuevo_nivel = $conceptoMaterial->nivel . str_repeat("0", $ceros) . $total . '.';
                        $unidadMaterial = Material::select('unidad')->where('id_material', '=', $maquina->id_material)->first();
                        $dataNuevoInsumo = [
                            "id_material" => $maquina->id_material,
                            "id_obra" => Context::getId(),
                            "nivel" => $nuevo_nivel,
                            "descripcion" => $maquina->descripcion,
                            "unidad" => $unidadMaterial->unidad,
                            "cantidad_presupuestada" => $maquina->rendimiento_nuevo * $concepto->cantidad_presupuestada,
                            "monto_presupuestado" => ($maquina->rendimiento_nuevo * $concepto->cantidad_presupuestada) * $maquina->precio_unitario_nuevo,
                            "precio_unitario" => $maquina->precio_unitario_nuevo,

                        ];

                        $nuevoInsumo = \Ghi\Domain\Core\Models\Concepto::create($dataNuevoInsumo);
                        $dataHist = [];
                        $dataHist['precio_unitario_original'] = 0;
                        $dataHist['precio_unitario_actualizado'] = $nuevoInsumo->precio_unitario;
                        $dataHist['monto_presupuestado_original'] = 0;
                        $dataHist['monto_presupuestado_actualizado'] = $nuevoInsumo->monto_presupuestado;
                        $dataHist['id_solicitud_cambio_partida'] = $maquina->id;
                        $dataHist['id_base_presupuesto'] = 2;
                        $dataHist['nivel'] = $nuevoInsumo->nivel;
                        $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                        SolicitudCambioPartidaHistorico::create($dataHist);
                    }
                }

                $conceptosNuevaTarjeta = Concepto::where('nivel', 'like', $concepto->nivel . '%')->get();
                foreach ($conceptosNuevaTarjeta as $conceptoNuevaTarjeta) {
                    //  $conceptoNuevaTarjeta->id_concepto;
                    $conceptoTarjetaUpdate = ConceptoTarjeta::where('id_concepto', '=', $conceptoNuevaTarjeta->id_concepto)->first();
                    if ($conceptoTarjetaUpdate) { //caso anteriores update
                        $conceptoTarjetaUpdate->id_tarjeta = $nuevaTarjeta->id;
                        $conceptoTarjetaUpdate->save();
                    } else { ///caso nuevos insert
                        ConceptoTarjeta::create(['id_concepto' => $conceptoNuevaTarjeta->id_concepto, 'id_tarjeta' => $nuevaTarjeta->id]);
                    }
                }

                ///////////Suma de montos a propagar
                ///
                $dataHist = [];
                $afectacion_mmonto_propagacion = 0;
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MATERIALES')->where('nivel', 'like', $concepto->nivel . '%')->first();

                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados']=$insumo->id;

                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();

                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);



                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MANO OBRA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);


                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'HERRAMIENTA Y EQUIPO')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);

                $dataHist = [];
                $conceptoMaterial = Concepto::where('descripcion', '=', 'MAQUINARIA')->where('nivel', 'like', $concepto->nivel . '%')->first();
                $dataHist['precio_unitario_original'] = $conceptoMaterial->precio_unitario;
                $dataHist['monto_presupuestado_original'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['precio_unitario_actualizado'] = $conceptoMaterial->precio_unitario;
                $dataHist['id_partidas_insumos_agrupados']=$insumo->id;
                $totalInsumos = Concepto::where('nivel', 'like', $conceptoMaterial->nivel . '___.')->get();
                $afectacion_mmonto_propagacion += $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->monto_presupuestado = $totalInsumos->sum('monto_presupuestado');
                $conceptoMaterial->save();
                $dataHist['monto_presupuestado_actualizado'] = $conceptoMaterial->monto_presupuestado;
                $dataHist['id_base_presupuesto'] = 2;
                $dataHist['nivel'] = $conceptoMaterial->nivel;
                SolicitudCambioPartidaHistorico::create($dataHist);
                //propagacion hacia arriba monto_presupuestado

                $tamanioFaltante = strlen($concepto->nivel);

                $monto_anterior = $concepto->monto_presupuestado;
                while ($tamanioFaltante > 0) { ///////////////recorrido todos los niveles hacia arriba

                    $dataHist = [];
                    $afectaConcepto = Concepto::where('nivel', '=', substr($concepto->nivel, 0, $tamanioFaltante))->where('id_obra', '=', Context::getId())->first();
                    $dataHist['precio_unitario_original'] = $afectaConcepto->precio_unitario;
                    $dataHist['monto_presupuestado_original'] = $afectaConcepto->monto_presupuestado;
                    $dataHist['precio_unitario_actualizado'] = $afectaConcepto->precio_unitario;
                    $dataHist['id_partidas_insumos_agrupados']=$insumo->id;

                    $afectaConcepto->monto_presupuestado = ($afectaConcepto->monto_presupuestado - $monto_anterior) + $afectacion_mmonto_propagacion;
                    $afectaConcepto->save();

                    $dataHist['monto_presupuestado_actualizado'] = $afectaConcepto->monto_presupuestado;
                    $dataHist['id_base_presupuesto'] = 2;
                    $dataHist['nivel'] = $afectaConcepto->nivel;
                    SolicitudCambioPartidaHistorico::create($dataHist);
                    $tamanioFaltante -= 4;
                }

            }

            $solicitud = SolicitudCambio::find($id);
            $solicitud->id_estatus = Estatus::AUTORIZADA;
            $solicitud->save();
            $data = ["id_solicitud_cambio" => $id];
            $solicitudCambio = SolicitudCambioAutorizada::create($data);
            $solicitud = $this->model->find($id);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollback();
            throw $e;
        }
    }
}







