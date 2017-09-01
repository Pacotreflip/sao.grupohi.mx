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