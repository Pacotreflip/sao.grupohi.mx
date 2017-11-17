<?php

namespace Ghi\Domain\Core\Contracts;

use Dingo\Api\Http\Request;

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
    //public function create(array $data);
    public function create(Request $request);
    /**
     * Crea relaciones con otros modelos
     * @param $relations
     * @return mixed
     */
    public function with($relations);

    /**
     * Actualiza la información de las partidas de una requisición
     * @param array $data
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $data, $id);

    /**
     * Elimina un Item
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     *
     * @param $attribute
     * @param $operator
     * @param $value
     * @return mixed
    */
    public function getBy($attribute, $operator, $value);

    /**
     * @param $scope Para consulta mixta de Item con Transacción
     * @return mixed
     */
    public function scope($scope);
}