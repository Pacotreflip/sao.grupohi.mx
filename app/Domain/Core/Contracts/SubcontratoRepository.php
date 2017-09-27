<?php

namespace Ghi\Domain\Core\Contracts;

use Ghi\Domain\Core\Models\Fondo;
use Illuminate\Database\Eloquent\Collection;

interface SubcontratoRepository
{
    /**
     * Obtiene los Subcontratos que coincidan con los campos de búsqueda
     * @param $attribute
     * @param $operator
     * @param $value
     * @return Collection
     */
    public function getBy($attribute, $operator, $value);
}