<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/06/2018
 * Time: 04:53 PM
 */

namespace Ghi\Domain\Core\Repositories\Compras;


use Ghi\Domain\Core\Contracts\Compras\OrdenCompraRepository;
use Ghi\Domain\Core\Models\Compras\OrdenCompra;

class EloquentOrdenCompraRepository implements OrdenCompraRepository
{
    /**
     * @var OrdenCompra
     */
    protected $model;

    /**
     * EloquentOrdenCompraRepository constructor.
     *
     * @param OrdenCompra $model
     */
    public function __construct(OrdenCompra $model)
    {
        $this->model = $model;
    }


    /**
     * @param integer $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Compras\OrdenCompra
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    public function search($value, array $columns)
    {
        return $this->model->where(function ($q) use ($value, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', '%' . $value . '%');
            }
        })->get();
    }

    public function limit($limit)
    {
        $this->model = $this->model->limit($limit);
        return $this;
    }

    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }
}