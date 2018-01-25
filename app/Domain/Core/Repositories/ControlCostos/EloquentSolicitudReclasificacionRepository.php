<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacionPartidas;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacion;

class EloquentSolicitudReclasificacionRepository implements SolicitudReclasificacionRepository
{
    /**
     * @var SolicitudReclasificacion $model
     */
    private $model;
    /**
     * @var SolicitudReclasificacionPartidas
     */
    private $partidas;

    /**
     * EloquentSolicitudReclasificacionRepository constructor.
     * @param SolicitudReclasificacion $model
     * @param SolicitudReclasificacionPartidas $partidas
     */
    public function __construct(SolicitudReclasificacion $model, SolicitudReclasificacionPartidas $partidas)
    {
        $this->model = $model;
        $this->partidas = $partidas;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Tesoreria\SolicitarReclasificaciones
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function create($data)
    {
        $num_partidas = count($data['partidas']);

        DB::connection('cadeco')->beginTransaction();

        try {

            $record = SolicitudReclasificacion::create(['motivo' => $data['motivo'], 'fecha' => $data['fecha']]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        DB::connection('cadeco')->beginTransaction();

        try {
            foreach ($data['partidas'] as $p)
                $this->partidas->create([
                    'id_solicitud_reclasificacion' => $record->id,
                    'id_item' => $p['id_item'],
                    'id_concepto_original' => $p['id_concepto'],
                    'id_concepto_nuevo' => $p['id_concepto_nuevo']
                ]);

            DB::connection('cadeco')->commit();

            // Revisa que el número de inserciones corresponda al número de partidas a guardar
            $insertadas = $this->partidas->where('id_solicitud_reclasificacion','=', $record->id)->count();

            if ($num_partidas != $insertadas)
            {
                // Elimina la reclasificación
                $record->delete();

                throw new HttpResponseException(new Response('La operación no pudo concretarse', 404));
            }

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return SolicitudReclasificacion::where('id', '=', $record->id)->first();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function paginate(array $data)
    {
        $query = $this->model->with(['autorizacion.usuario', 'rechazo.usuario', 'usuario', 'estatusString', 'partidas.item.material', 'partidas.item.transaccion', 'partidas.item.contrato', 'partidas.conceptoNuevo', 'partidas.conceptoOriginal'])->select('ControlCostos.solicitud_reclasificacion.*')->orderBy('ControlCostos.solicitud_reclasificacion.created_at', 'DESC');
        return $query->paginate($perPage = $data['length'], $columns = ['*'], $pageName = 'page', $page = ($data['start'] / $data['length']) + 1);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update($data, $id)
    {
        // TODO: Implement update() method.
    }

    public function find($id)
    {
        return $this->model->find($id);

    }
}
