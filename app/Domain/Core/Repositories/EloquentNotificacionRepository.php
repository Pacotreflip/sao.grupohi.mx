<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 10/07/2017
 * Time: 07:00 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\CuentaEmpresa;
use Ghi\Domain\Core\Contracts\NotificacionRepository;
use Ghi\Domain\Core\Models\Notificacion;
use Illuminate\Support\Facades\DB;

class EloquentNotificacionRepository implements NotificacionRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Notificacion
     */
    private $model;

    /**
     * EloquentNotificacionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Notificacion $model
     */
    public function __construct(Notificacion $model)
    {
        $this->model = $model;
    }
    /**
     * Obtiene todas las Notificaciones
     *
     * @return \Illuminate\Database\Eloquent\Collection|CuentaEmpresa
     */
    public function all()
    {
        return $this->model->get();
    }
    /**
     * @param $id
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Guarda una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            DB::connection('cadeco')->beginTransaction();
            $data['estatus'] = 1;
            $item = $this->model->create($data);
            DB::connection('cadeco')->commit();

        } catch (\Exception $e) {
            DB::connection('cadeco')->rollBack();
            throw $e;
        }

        return $item;
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
     * Actualiza una notificacion
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Notificacion
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            $notificacion = $this->model->find($id);
            $notificacion->estatus = 0;
            $notificacion->update();
        } catch (\Exception $e) {
            throw $e;
        }
        return $notificacion;
    }

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */

    public function scope($scope)
    {
        $this->model = $this->model->$scope();
        return $this;
    }
    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }
}