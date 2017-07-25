<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 13/07/2017
 * Time: 02:24 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\NotificacionPolizaRepository;
use Ghi\Domain\Core\Contracts\Identificador;

use Ghi\Domain\Core\Models\Contabilidad\NotificacionPoliza;


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

    /**
     * Las notificaciones_html que coincidan con la busqueda
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where($where)
    {
        return $this->model->where($where)->get();
    }
}