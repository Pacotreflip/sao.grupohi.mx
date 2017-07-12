<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 10/07/2017
 * Time: 06:49 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface CuentaMaterialRepository
{

    /**
     * Guarda un registro de cuenta almacén
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un registro de cuenta almacén
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaMaterial
     * @throws \Exception
     */
    public function update(array $data,$id);
}