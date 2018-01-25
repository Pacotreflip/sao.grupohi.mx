<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 06:52 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Illuminate\Database\Eloquent\Model;

class ConceptoTarjeta extends Modeldel
{
    protected $table = 'ControlPresupuesto.concepto_tarjeta';
    protected $connection = 'cadeco';

}