<?php

namespace Ghi\Domain\Core\Repositories\Finanzas;


use Ghi\Domain\Core\Contracts\Finanzas\RubroRepository;
use Ghi\Domain\Core\Models\Finanzas\Rubro;

class EloquentRubroRepository implements RubroRepository
{
    /**
     * @var Rubro
     */
    protected $model;

    /**
     * EloquentRubroRepository constructor.
     * @param Rubro $model
     */
    public function __construct(Rubro $model)
    {
        $this->model = $model;
    }

    /**
     * @return Rubro[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * @param array|string $with
     * @return $this|RubroRepository
     */
    public function with($with)
    {
        $this->model = $this->model->with($with);
        return $this;
    }

    /**
     * @param array|string $where Where
     * @return $this|RubroRepository
     */
    public function where($where)
    {
        $this->model = $this->model->where($where);
        return $this;
    }
}