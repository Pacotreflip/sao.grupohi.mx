<?php
/**
 * Created by PhpStorm.
 * User: 25852
 * Date: 18/05/2018
 * Time: 04:53 PM
 */

namespace Ghi\Domain\Core\Contracts\ControlPresupuesto;


interface ConceptoExtraordinarioRepository
{
    public function store(array $data);
    public function autorizar($id);
}