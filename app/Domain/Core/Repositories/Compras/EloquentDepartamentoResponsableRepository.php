<?php

namespace Ghi\Domain\Core\Repositories\Compras;

use Ghi\Domain\Core\Contracts\Compras\DepartamentoResponsableRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\DepartamentoResponsable;

class EloquentDepartamentoResponsableRepository implements DepartamentoResponsableRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\DepartamentoResponsable
     */
    protected $model;

    /**
     * EloquentDepartamentoResponsableRepository constructor.
     * @param \Ghi\Domain\Core\Models\Compras\Requisiciones\DepartamentoResponsable $model
     */
    public function __construct(DepartamentoResponsable $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Departamento Responsable
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Compras\DepartamentoResponsable
     */
    public function all()
    {
        return $this->model->orderBy('descripcion', 'ASC')->get();
    }
}