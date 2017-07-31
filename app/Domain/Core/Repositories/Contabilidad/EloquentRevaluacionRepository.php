<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\RevaluacionRepository;
use Ghi\Domain\Core\Models\Contabilidad\Revaluacion;

class EloquentRevaluacionRepository implements RevaluacionRepository
{

    /**
     * @var Revaluacion
     */
    protected $model;

    /**
     * EloquentRevaluacionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\Revaluacion $model
     */
    public function __construct(Revaluacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las revaluacion
     * @return \Illuminate\Database\Eloquent\Collection | \Ghi\Domain\Core\Contracts\Contabilidad\Revaluacion
     */
    public function all()
    {
        return $this->model->get();
    }
}