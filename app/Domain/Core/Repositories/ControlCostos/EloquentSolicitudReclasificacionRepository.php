<?php

namespace Ghi\Domain\Core\Repositories\ControlCostos;

use Ghi\Domain\Core\Contracts\ControlCostos\SolicitudReclasificacionRepository;
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
     * EloquentSolicitudReclasificacionRepository constructor.
     * @param SolicitudReclasificacion $model
     */
    public function __construct(SolicitudReclasificacion $model)
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

            $record = SolicitudReclasificacion::create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return SolicitudReclasificacion::where('id_solicitud_reclasificacion', '=', $record->id_solicitud_reclasificacion)->first();
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
