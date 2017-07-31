<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface RevaluacionRepository
{
    /**
     * Obtiene todas las revaluacion
     * @return \Illuminate\Database\Eloquent\Collection | \Ghi\Domain\Core\Models\Contabilidad\Revaluacion;

     */
    public function all();
}