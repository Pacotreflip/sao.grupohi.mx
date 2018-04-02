<?php
/**
 * Created by PhpStorm.
 * User: jfesquivel
 * Date: 25/01/2018
 * Time: 17:13 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


use Ghi\Domain\Core\Models\ControlPresupuesto\Tarjeta;

interface TarjetaRepository
{
    /**
     * Obtiene todas las Tarjetas
     * @return \Illuminate\Database\Eloquent\Collection|Tarjeta
     */
    public function all();
    public function lists();
}