<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\Collection;
use Ghi\Domain\Core\Models\PolizaTipo;
use Ghi\Domain\Core\Contracts\PolizaTipoRepository;

class EloquentPolizaTipoRepository implements PolizaTipoRepository
{

    private $model;

    /**
     * EloquentPolizaTipoRepository constructor.
     * @param $model
     */
    public function __construct(PolizaTipo $model)
    {
        $this->model = $model;
    }


    /**
     * Obtiene todas las polizas tipo
     *
     * @return Collection|PolizaTipo
     */
    public function getAll()
    {
        return $this->model->all();
    }
}