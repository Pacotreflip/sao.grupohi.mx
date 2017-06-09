<?php namespace Ghi\Domain\Core\Repositories;

use Ghi\Domain\Core\Contracts\TipoMovimientoRepository;
use Ghi\Domain\Core\Models\TipoMovimiento;

class EloquentTipoMovimientoRepository implements TipoMovimientoRepository
{

    public function lists() {
        return TipoMovimiento::orderBy('descripcion', 'ASC')->lists('descripcion', 'id');
    }
}