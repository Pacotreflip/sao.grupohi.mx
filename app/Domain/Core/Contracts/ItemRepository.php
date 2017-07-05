<?php

namespace Ghi\Domain\Core\Contracts;

interface ItemRepository
{
    /**
     * Obtiene todos los registros de Item
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Item
     */
    public function all();

    /**
     * @param $id Identificador del Item
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Transacciones\Item
     */
    public function find($id);
    /**
     * Guarda un registro de Item
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Transacciones\Item
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);
}