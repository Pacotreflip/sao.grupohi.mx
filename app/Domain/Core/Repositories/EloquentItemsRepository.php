<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 05/07/2017
 * Time: 01:03 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Models\Items;
use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Contracts\ItemsRepository;

class EloquentItemsRepository implements ItemsRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Empresa
     */
    private $model;

    /**
     * EloquentObraRepository constructor.
     * @param \Ghi\Domain\Core\Models\Empresa $model
     */
    public function __construct(Items $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return Ghi\Domain\Core\Models\Items
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Obtiene el item con relaciones
     * @param array|string $relations
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function getBy($attribute, $operator, $value) {
        return $this->model->where($attribute, $operator, $value)->get();
    }

    public function scope($scope) {
        $this->model = $this->model->$scope();
        return $this;
    }
}