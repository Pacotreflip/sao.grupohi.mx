<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 05/07/2017
 * Time: 01:50 PM
 */

namespace Ghi\Domain\Core\Contracts;


interface MaterialRepository
{
    /**
     * Obtiene todos los registros de Material
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Models\Material
     */
    public function all();

    /**
     * Buscar materiales
     * @param $attribute
     * @param $operator
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|Material
     */
    public function getBy($attribute, $operator, $value);

    /**
     * Obtiene un scope sobre el modelo
     * @param string $scope
     * @return mixed
     */
    public function scope($scope);
}