<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionPartidasRepository;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Ghi\Domain\Core\Models\ControlCostos\SolicitudReclasificacionPartidas;

class EloquentSolicitudReclasificacionPartidasRepository implements SolicitudReclasificacionPartidasRepository
{
    /**
     * @var SolicitudReclasificacionPartidas $model
     */
    private $model;

    /**
     * EloquentSolicitudReclasificacionRepository constructor.
     * @param SolicitudReclasificacionPartidas $model
     */
    public function __construct(SolicitudReclasificacionPartidas $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection
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

        return SolicitudReclasificacionPartidas::where('id', '=', $record->id)->first();
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
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
