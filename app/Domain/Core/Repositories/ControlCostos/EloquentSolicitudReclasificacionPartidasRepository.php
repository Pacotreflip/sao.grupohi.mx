<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionPartidasRepository;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacionPartidas;

class EloquentSolicitudReclasificacionPartidasRepository implements SolicitudReclasificacionPartidasRepository
{
    /**
     * @var SolicitudReclasificacion $model
     */
    private $model;

    /**
     * EloquentSolicitudReclasificacionRepository constructor.
     * @param SolicitudReclasificacion $model
     */
    public function __construct(SolicitudReclasificacionPartidas $model)
    {
        $this->model = $model;
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

            $record = SolicitudReclasificacionPartidas::create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return SolicitudReclasificacionPartidas::where('id_partida', '=', $record->id_partida)->first();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations) {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {

    }

    public function update($data, $id)
    {

    }
}
