<?php

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Contracts\ControlPresupuesto\EscalatoriaRepository;
use Ghi\Domain\Core\Models\ControlPresupuesto\AfectacionOrdenesPresupuesto;
use Ghi\Domain\Core\Models\ControlPresupuesto\ConceptoEscalatoria;
use Ghi\Domain\Core\Models\ControlPresupuesto\Estatus;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioAutorizada;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartida;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioPartidaHistorico;
use Ghi\Domain\Core\Models\ControlPresupuesto\SolicitudCambioRechazada;
use Ghi\Domain\Core\Models\ControlPresupuesto\TipoOrden;
use Ghi\Domain\Core\Models\ControlPresupuesto\Escalatoria;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class EloquentEscalatoriaRepository implements EscalatoriaRepository
{
    /**
     * @var Escalatoria
     */
    private $model;

    /**
     * EloquentSolicitudCambioRepository constructor.
     * @param Escalatoria $model
     */
    public function __construct(Escalatoria $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Escalatoria
     * @return Escalatoria
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
     * Guarda un registro de Escalatoria
     * @param array $data
     * @throws \Exception
     * @return Escalatoria
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();

            $solicitud = $this->model->create($data);
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

    /**
     * Regresa un registro específico de Escalatoria
     * @param $id
     * @return Escalatoria
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
     * Autoriza una Escalatoria
     * @param $id
     * @param array $data
     * @return Escalatoria
     * @throws \Exception
     */
    public function autorizar($id, array $data)
    {
        $solicitud = $this->model->with('partidas')->find($id);

        try {
            DB::connection('cadeco')->beginTransaction();

            // No existe la solicitud
            if (is_null($solicitud))
                throw new HttpResponseException(new Response('No existe la solicitud', 404));

            // La solicitud ya está autorizada
            if ($solicitud->id_estatus == Estatus::AUTORIZADA)
                throw new HttpResponseException(new Response('No se puede autorizar la solicitud porque ya se encuentra autorizada', 404));

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
                            'descripcion' => 'ESCALATORIAS'
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
                        'monto_presupuestado' => $partida->monto_presupuestado
                    ]);

                    $concepto_partida =  DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', '=', $concepto_partida_nivel)->first();

                    //Propagación
                    $continua = true;
                    $siguienteNivel = substr($concepto_partida_nivel, 0, -4);
                    $cantidadMonto = $partida->monto_presupuestado;

                    while ($continua)
                    {
                        $conceptoAfectado = DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")->where('id_obra', '=', Context::getId())->where('nivel', '=', $siguienteNivel)->first();

                        if (!is_null($conceptoAfectado))
                        {
                            $cantidadMonto = $conceptoAfectado->monto_presupuestado + $cantidadMonto;

                            SolicitudCambioPartidaHistorico::create([
                                'id_solicitud_cambio_partida' => $partida->id,
                                'id_base_presupuesto' => $basePresupuesto->baseDatos->id,
                                'nivel' => $conceptoAfectado->nivel,
                                'monto_presupuestado_original' => $partida->monto_presupuestado,
                                'monto_presupuestado_actualizado' => $cantidadMonto
                            ]);

                            DB::connection('cadeco')->table($basePresupuesto->baseDatos->base_datos . ".dbo.conceptos")
                                ->where('id_concepto', $conceptoAfectado->id_concepto)
                                ->update(['monto_presupuestado' => $cantidadMonto]);

                            $siguienteNivel = substr($conceptoAfectado->nivel, 0, -4);
                            $continua = $siguienteNivel > 0;
                        }

                    }
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
     * Rechaza una Escalatoria
     * @param array $data
     * @throws \Exception
     * @return Escalatoria
     */
    public function rechazar(array $data)
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

    /**
     * Aplica una Escalatoria a un Presupuesto
     * @param Escalatoria $escalatoria
     * @param $id_base_presupuesto
     * @return void
     */
    public function aplicar(Escalatoria $escalatoria, $id_base_presupuesto)
    {
 
    }
}
