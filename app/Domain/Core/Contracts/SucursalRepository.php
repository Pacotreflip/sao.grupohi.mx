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
     * Obtiene todas las sucursales
     * @return Collection|Sucursal
     */
    public function all();

    /**
     * Obtiene una Sucursal por si ID
     * @return Sucursal
     */
    public function find(int $id);

    /**
     * Crea un nuevo registro de Sucursal
     * @return Sucursal
     */
    public function create(array $data);
}