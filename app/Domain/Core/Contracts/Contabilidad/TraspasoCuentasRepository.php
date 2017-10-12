<?php

namespace Ghi\Domain\Core\Contracts\Contabilidad;

interface TraspasoCuentasRepository
{
    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\TraspasoCuentasRepository
     */
    public function all();
}
