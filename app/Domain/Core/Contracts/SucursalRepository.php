<?php
/**
 * Created by PhpStorm.
 * User: froke
 * Date: 03/11/2017
 * Time: 02:39 AM
 */

namespace Ghi\Domain\Core\Contracts;


use Ghi\Domain\Core\Models\Sucursal;
use Illuminate\Database\Eloquent\Collection;

interface SucursalRepository
{

    /**
     * Crea un nuevo registro de Sucursal
     * @return Sucursal
     */
    public function create(array $data);
}