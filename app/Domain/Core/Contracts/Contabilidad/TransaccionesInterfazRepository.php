<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 19/07/2017
 * Time: 01:43 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface TransaccionesInterfazRepository
{
    /**
     * Obtiene todos los elementos
     * @return \Illuminate\Database\Eloquent\Collection|\Ghi\Domain\Core\Contracts\Contabilidad\TransaccionInterfaz
     */
    public function all();

    /**
     * Obtienes las trnsacciones sao en lista para combo
     * @return array
     */
    public function lists();

    /**
     * @param $scope
     * @return mixed
     */
    public function scope($scope);
}