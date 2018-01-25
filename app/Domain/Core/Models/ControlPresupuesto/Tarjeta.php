<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 25/01/2018
 * Time: 04:56 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $table = 'ControlPresupuesto.tarjeta';
    protected $connection = 'cadeco';


}