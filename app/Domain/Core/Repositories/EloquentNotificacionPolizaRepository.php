<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 13/07/2017
 * Time: 02:24 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\Identificador;
use Ghi\Domain\Core\Contracts\NotificacionPolizaRepository;
use Ghi\Domain\Core\Contracts\NotificacionRepository;
use Ghi\Domain\Core\Models\NotificacionPoliza;

class EloquentNotificacionPolizaRepository implements NotificacionPolizaRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\NotificacionPoliza
     */
    protected $model;

    /**
     * EloquentNotificacionPolizaRepository constructor.
     * @param \Ghi\Domain\Core\Models\NotificacionPoliza $model
     */
    public function __construct(NotificacionPoliza $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de la notificacion
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\NotificacionPoliza
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id Identificador de notificacion Poliza
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\NotificacionPoliza
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda un registro de Item
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\NotificacionPoliza
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $item = $this->model->create($data);
            DB::connection('cadeco')->commit();
        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $this->model->find($item->id_item);
    }

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}