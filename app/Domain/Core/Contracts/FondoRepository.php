<?php

namespace Ghi\Domain\Core\Contracts;

use Ghi\Domain\Core\Models\Fondo;
use Ghi\Domain\Core\Repositories\EloquentFondoRepository;
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
     * @param array|string $relations Relations
     * @return $this|FondoRepository
     */
    public function with($relations);

    /**
     * Obtienes los fondos en lista para combo
     * @return array
     */
    public function lists();

    /**
     * @param array|string $where Where
     * @return $this|FondoRepository
     */
    public function where($where);
}