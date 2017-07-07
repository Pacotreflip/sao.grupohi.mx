<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 05/07/2017
 * Time: 01:03 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface ItemsRepository
{
    /**
     * @param $id
     * @return \Ghi\Domain\Core\Models\Items
     */
    public function find($id);

    /**
     * Obtiene el item con relaciones
     * @param array|string $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * @param $attribute
     * @param $operator
     * @param $value
     * @return mixed
     */
    public function getBy($attribute, $operator, $value);

    public function scope($scope);

}