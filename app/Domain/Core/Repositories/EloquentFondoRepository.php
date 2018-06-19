<?php

namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\FondoRepository;
use Ghi\Domain\Core\Models\Fondo;
use Illuminate\Database\Eloquent\Collection;

class EloquentFondoRepository implements FondoRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Fondo
     */
    protected $model;

    /**
     * EloquentFondoRepository constructor.
     * @param Fondo $model
     */
    public function __construct(Fondo $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los fondos
     * @return Collection | Fondo
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Obtiene un fondo por su Primary Key
     * @param $id
     * @return Fondo
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }


    /**
     * @param array|string $relations Relations
     * @return $this|FondoRepository
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Obtienes los fondos en lista para combo
     * @return array
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion', 'ASC')->lists('descripcion', 'id_fondo');
    }

    /**
     * @param array|string $where Where
     * @return $this|FondoRepository
     */
    public function where($where)
    {
        $this->model = $this->model->where($where);
        return $this;
    }
}