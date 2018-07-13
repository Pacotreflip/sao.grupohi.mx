<?php

namespace Ghi\Domain\Core\Contracts;

use Dingo\Api\Http\Request;
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

    /**
     * Almacena un nuevo SubContrato
     * @param  array $data
     * @return Subcontrato
     */
    public function create(Request $request);

    public function search($value, array $columns);

    public function limit($limit);

    public function with($relations);
}