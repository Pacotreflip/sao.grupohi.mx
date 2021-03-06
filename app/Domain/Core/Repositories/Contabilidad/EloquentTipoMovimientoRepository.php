<?php namespace Ghi\Domain\Core\Repositories\Contabilidad;

use Ghi\Domain\Core\Contracts\Contabilidad\TipoMovimientoRepository;
use Ghi\Domain\Core\Models\Contabilidad\TipoMovimiento;

class EloquentTipoMovimientoRepository implements TipoMovimientoRepository
{

    /**
     * @var \Ghi\Domain\Core\Models\TipoMovimiento $model
     */
    private $model;

    /**
     * EloquentTipoMovimientoRepository constructor.
     * @param \Ghi\Domain\Core\Models\TipoMovimiento $model
     */
    public function __construct(TipoMovimiento $model)
    {
        $this->model = $model;
    }

    /**
     * Obtiene los tipos de Movimiento en forma de lista para combos
     * @return  \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\TipoMovimiento
     */
    public function lists()
    {
        return $this->model->orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
    }
}