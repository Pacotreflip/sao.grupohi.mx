<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 06:52 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Illuminate\Database\Eloquent\Model;

class AfectacionOrdenesPresupuesto extends Model
{
    protected $table = 'ControlPresupuesto.afectacion_ordenes_presupuesto';
    protected $connection = 'cadeco';

    public function baseDatos()
    {
        return $this->hasOne(BasePresupuesto::class, 'id', 'id_base_presupuesto');
    }
}