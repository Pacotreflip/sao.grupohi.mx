<?php

namespace Ghi\Domain\Core\Repositories;

use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Contracts\MovimientosRepository;
use Ghi\Domain\Core\Models\Movimientos;

class EloquentMovimientosRepository implements MovimientosRepository
{

    /**
     * @var Movimientos
     */
    protected $model;


    /**
     * EloquentMovimientosRepository constructor.
     * @param Movimientos $model
     */
    public function __construct(Movimientos $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }


    /**
     * @param Request $request
     */
    public function create($data)
    {

    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update($data, $id)
    {

    }

    /**
     * @param $id
     */
    public function delete($id)
    {

    }
}