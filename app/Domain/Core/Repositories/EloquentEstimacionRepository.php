<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 22/09/2017
 * Time: 01:40 PM
 */

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\EstimacionRepository;
use Ghi\Domain\Core\Models\Transacciones\Estimacion;
use Illuminate\Database\Eloquent\Collection;

class EloquentEstimacionRepository implements EstimacionRepository
{
    /**
     * @var Estimacion
     */
    protected $model;

    /**
     * EloquentEstimacionRepository constructor.
     * @param Estimacion $model
     */
    public function __construct(Estimacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Estimaciones
     * @return Collection|Estimacion
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param int $id
     * @return Estimacion
     */
    public function find($id)
    {
       return $this->model->findOrFail($id);
    }

    /**
     * Crea relaciones con otros modelos
     * @param array $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}