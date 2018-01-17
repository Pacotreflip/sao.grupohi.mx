<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 11/01/2018
 * Time: 11:45 AM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface BasePresupuestoRepository
{
    /**
     * @return BasePresupuesto
     *
     */
    public function all();

    /**
     * @param $value valor de busqueda de Bases de acuerdo a su id
     * @return mixed
     */
    public function findBy($value);

}