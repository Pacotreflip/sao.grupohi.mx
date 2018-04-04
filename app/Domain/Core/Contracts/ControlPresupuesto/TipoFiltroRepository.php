<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:36 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface TipoFiltroRepository
{
    /**
     * Obtiene todas las Tarjetas
     * @return \Illuminate\Database\Eloquent\Collection|TipoFiltro
     */
    public function all();

    public function lists();
}