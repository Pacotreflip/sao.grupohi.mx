<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 05/07/2017
 * Time: 11:43 AM
 */

namespace Ghi\Domain\Core\Contracts\Compras;


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

    /**Crea relaciones con otros modelos
     * @param array $array
     * @return mixed
     */
    public function with($relations);
}