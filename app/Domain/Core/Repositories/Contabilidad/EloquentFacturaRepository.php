<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 31/07/2017
 * Time: 04:36 PM
 */

namespace Ghi\Domain\Core\Repositories\Contabilidad;


use Ghi\Domain\Core\Contracts\Contabilidad\FacturaRepository;
use Ghi\Domain\Core\Models\Contabilidad\Factura;

class EloquentFacturaRepository implements FacturaRepository
{


    /**
     * @var \Ghi\Domain\Core\Models\Contabilidad\Factura
     */
    protected $model;

    /**
     * EloquentFacturaRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\Factura $model
     */
    public function __construct(Factura $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las facturas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Factura
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     *  Obtiene Factura por su ID
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\Factura
     */
    public function find($id)
    {
        return $this->model->find($id);

    }

    /**
     * Guarda un nuevo registro de factura
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\Factura
     * @throws \Exception
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Factura
     * @throws \Exception
     */
    public function delete(array $data, $id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Factura
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     *  Contiene los parametros de búsqueda
     * @param array $where
     * @return mixed
     */
    public function where(array $where)
    {
        $this->model = $this->model->where($where);
        return $this;
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