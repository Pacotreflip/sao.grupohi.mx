<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 05/07/2017
 * Time: 01:51 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\MaterialRepository;
use Ghi\Domain\Core\Models\Material;

class EloquentMaterialRepository implements MaterialRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Material
     */
    protected $model;

    /**
     * EloquentMaterialRepository constructor.
     * @param \Ghi\Domain\Core\Models\Material $model
     */
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Material
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Buscar materiales
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Material
     */
    public function getBy($attribute, $operator, $value)
    {
        return $this->model->where($attribute, $operator, $value)->get();
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
}