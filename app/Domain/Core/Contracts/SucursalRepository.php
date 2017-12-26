<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 02:39 AM
 */

namespace Ghi\Domain\Core\Contracts;


use Ghi\Domain\Core\Models\Sucursal;

interface SucursalRepository
{
    /**
     * Crea un nuevo registro de Sucursal
     * @param array $data
     * @return Sucursal
     */
    public function create(array $data);
}