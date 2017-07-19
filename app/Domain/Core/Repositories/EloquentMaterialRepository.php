<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 05/07/2017
 * Time: 12:07 PM
 * User: EMARTINEZ
 * Date: 05/07/2017
 * Time: 01:51 PM
 */

namespace Ghi\Domain\Core\Repositories;


use Ghi\Domain\Core\Contracts\Ghi;
use Ghi\Domain\Core\Contracts\los;
use Ghi\Domain\Core\Contracts\MaterialRepository;
use Ghi\Domain\Core\Contracts\valor;
use Ghi\Domain\Core\Models\Material;
use Illuminate\Support\Facades\DB;

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
    /**
     * @param
     * @return Ghi\Domain\Core\Models\Material
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

    /**
     * @param $value valor de busqueda de materiales de acuerdo a su tipo
     * @return mixed
     */
    public function findBy($value)
    {
        return $this->model->where('tipo_material', $value)->orderBy('nivel', 'asc')->get();
    }

    /**
     * @param $value los datos de busqueda para un material padre y materiales hijos
     * @return mixed
     */
    public function find($tipo, $nivel)
    {
        return $this->model->where(function($query) use($tipo, $nivel){
            $query->orWhere('nivel', 'LIKE', $nivel)
                ->orWhere('nivel', 'LIKE', $nivel.'___.');
        })->where('tipo_material', $tipo)->orderBy('nivel', 'asc')->get();
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