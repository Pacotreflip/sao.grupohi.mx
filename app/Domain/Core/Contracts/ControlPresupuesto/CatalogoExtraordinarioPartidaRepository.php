<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 21/05/2018
 * Time: 04:54 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface CatalogoExtraordinarioPartidaRepository
{
    public function getPartidasByIdCatalogo($id);
    public function getExtraordinarioNuevo();
    public function guardarExtraordinario(array $array);
}