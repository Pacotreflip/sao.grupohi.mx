<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 23/01/2018
 * Time: 12:36 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface TipoCobrabilidadRepository
{
    /**
     * Obtiene las cobrabilidades
     *
     * @return \Illuminate\Database\Eloquent\Collection|TipoCobrabilidad
     */
    public function all();
}