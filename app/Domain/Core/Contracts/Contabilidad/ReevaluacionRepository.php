<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface ReevaluacionRepository
{
    /**
     * Obtiene todas las reevaluaciones
     * @return \Illuminate\Database\Eloquent\Collection | Reevaluacion
     */
    public function all();
}