<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:36 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface TipoOrdenRepository
{
    /**
     * Obtiene todos los tipos de orden
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoOrden
     */
    public function all();
}