<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 01:40 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


use Ghi\Domain\Core\Models\Almacen;

interface CuentaAlmacenRepository
{
    /**
     * Guarda un registro de cuenta almacén
     * @param array $data
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen
     * @throws \Exception
     */
    public function create(array $data);

    /**
     * Actualiza un registro de cuenta almacén
     * @param array $data
     * @param $id
     * @return \Ghi\Domain\Core\Models\Contabilidad\CuentaAlmacen
     * @throws \Exception
     */
    public function update(array $data,$id);

}