<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRechazadaRepository;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacionRechazada;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacion;

class EloquentSolicitudReclasificacionRechazadaRepository implements SolicitudReclasificacionRechazadaRepository
{
    /**
     * @var SolicitudReclasificacion $model
     */
    private $model;
    /**
     * @var SolicitudReclasificacion
     */
    private $solicitud;

    /**
     * EloquentSolicitudReclasificacionAutorizadaRepository constructor.
     * @param SolicitudReclasificacionRechazada|SolicitudReclasificacionAutorizada $model
     * @param $
     * @param SolicitudReclasificacion $solicitud
     */
    public function __construct(SolicitudReclasificacionRechazada $model, SolicitudReclasificacion $solicitud)
    {
        $this->model = $model;
        $this->solicitud = $solicitud;
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

        try {
            DB::connection('cadeco')->beginTransaction();

            $record = SolicitudReclasificacionRechazada::create([
                'id_solicitud_reclasificacion' => $data['id'],
                'motivo' => $data['motivo_rechazo'],
            ]);

            // Cambia el estado a la solicitud
            $solicitud = $this->solicitud->where('id', '=', $data['id']);

            // Estatus -1 Rechazada
            $solicitud->update([
                'estatus' => -1,
            ]);

            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->solicitud->with([
            'autorizadas.usuario',
            'rechazadas.usuario',
            'usuario',
            'estatus',
            'partidas.item.material',
            'partidas.item.transaccion',
            'partidas.conceptoNuevo',
            'partidas.conceptoOriginal'])
            ->where('id', '=', $data['id'])
            ->select('ControlCostos.solicitud_reclasificacion.*')
            ->orderBy('ControlCostos.solicitud_reclasificacion.created_at', 'DESC')
            ->first();
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
        $query = $this->model->with(['usuario', 'estatus', 'partidas.item.material', 'partidas.item.transaccion', 'partidas.conceptoNuevo', 'partidas.conceptoOriginal'])->select('ControlCostos.solicitud_reclasificacion.*')->orderBy('ControlCostos.solicitud_reclasificacion.created_at', 'DESC');
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
}
