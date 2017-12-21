<?php

namespace Ghi\Domain\Core\Repositories\ControlPresupuesto;

use Ghi\Domain\Core\Contracts\ControlPresupuesto\PresupuestoRepository;
use Ghi\Domain\Core\Models\ConceptoPath;

class EloquentPresupuestoRepository implements PresupuestoRepository
{

    /**
     * @return mixed
     */
    public function getMaxNiveles()
    {
        $resp = ConceptoPath::selectRaw('MAX(LEN(nivel)) / 4 as max_nivel')->first();
        return $resp->max_nivel;
    }
}