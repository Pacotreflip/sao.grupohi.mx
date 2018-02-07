<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 06:52 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Ghi\Domain\Core\Models\Concepto;
use Illuminate\Database\Eloquent\Model;

class ConceptoTarjeta extends Model
{
    protected $table = 'ControlPresupuesto.concepto_tarjeta';
    protected $connection = 'cadeco';
    public function concepto()
    {
        return $this->hasOne(Concepto::class, 'id_concepto', 'id_concepto');
    }
}