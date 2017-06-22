<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\PolizaRepository;
use Ghi\Domain\Core\Models\Poliza;


class EloquentPolizaRepository implements PolizaRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\Poliza
     */
    protected $model;

    /**
     * EloquentPolizaRepository constructor.
     * @param \Ghi\Domain\Core\Models\Poliza $model
     */
    public function __construct(Poliza $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function all($with = null)
    {
        if ($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    /**
     * @param $id
     * @return mixed \Illuminate\Database\Eloquent\Collection|Poliza
     */
    public function find($id)
    {
        return $this->model->find($id);
    }
}