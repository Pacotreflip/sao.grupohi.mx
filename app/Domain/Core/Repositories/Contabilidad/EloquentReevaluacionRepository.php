<?php

namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\ReevaluacionRepository;
use Ghi\Domain\Core\Models\Contabilidad\Reevaluacion;

class EloquentReevaluacionRepository implements ReevaluacionRepository
{

    /**
     * @var Reevaluacion
     */
    protected $model;

    /**
     * EloquentReevaluacionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Contabilidad\Reevaluacion $model
     */
    public function __construct(Reevaluacion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todas las reevaluaciones
     * @return \Illuminate\Database\Eloquent\Collection | \Ghi\Domain\Core\Contracts\Contabilidad\Reevaluacion
     */
    public function all()
    {
        return $this->model->get();
    }
}