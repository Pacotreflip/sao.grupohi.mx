<?php

namespace Ghi\Domain\Core\Repositories\Compras;

use Ghi\Domain\Core\Contracts\Compras\TipoRequisicionRepository;
use Ghi\Domain\Core\Models\Compras\Requisiciones\TipoRequisicion;

class EloquentTipoRequisicionRepository implements TipoRequisicionRepository
{
    /**
     * @var \Ghi\Domain\Core\Models\Compras\Requisiciones\DepartamentoResponsable
     */
    protected $model;

    /**
     * EloquentTipoRequisicionRepository constructor.
     * @param \Ghi\Domain\Core\Models\Compras\Requisiciones\TipoRequisicion $model
     */
    public function __construct(TipoRequisicion $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene todos los registros de Tipo de Requisición
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoRequisicion
     */
    public function all()
    {
        return $this->model->orderBy('descripcion', 'ASC')->get();
    }
}