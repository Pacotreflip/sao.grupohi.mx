<?php
/**
 * Created by PhpStorm.
 * User: LERDES2
 * Date: 28/06/2017
 * Time: 01:40 PM
 */

namespace Ghi\Domain\Core\Contracts\Contabilidad;


interface CuentaAlmacenRepository
{
    /**
     * Guarda un nuevo registro de Cuenta de Almacén
     *
     * @param $data
     * @return \Ghi\Domain\Core\Models\CuentaAlmacen
     * @throws \Exception
     */
    public function create($data);
}