<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\PolizasRepository;


class EloquentPolizasRepository implements PolizasRepository
{

    /**
 * @var \Ghi\Domain\Core\Models\Polizas
 */
    protected $model;

    /**
     * EloquentPolizasRepository constructor.
     * @param \Ghi\Domain\Core\Models\Polizas $model
     */
    public function __construct(Polizas $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las polizas
     *
     * @return \Illuminate\Database\Eloquent\Collection|Polizas
     */
    public function all($with = null)
    {
        if($with != null) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }
}