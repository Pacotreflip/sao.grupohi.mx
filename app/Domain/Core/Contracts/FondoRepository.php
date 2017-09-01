<?php

namespace Ghi\Domain\Core\Contracts;

use Ghi\Domain\Core\Models\Fondo;
use Illuminate\Database\Eloquent\Collection;

interface FondoRepository
{
    /**
     * Obtiene todos los fondos
     * @return Collection | Fondo
     */
    public function all();

    /**
     * Obtiene un fondo por su Primary Key
     * @param $id
     * @return Fondo
     */
    public function find($id);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);
}