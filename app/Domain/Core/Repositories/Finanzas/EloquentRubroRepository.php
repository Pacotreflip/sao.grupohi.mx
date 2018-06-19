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
     * @return mixed
     */
    public function lists()
    {
        return $this->model->lists('descripcion', 'id_rubro');
    }
}