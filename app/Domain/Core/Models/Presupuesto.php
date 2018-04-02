<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 07/03/2018
 * Time: 01:20 PM
 */

namespace Ghi\Domain\Core\Models;


use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.presupuestos';

    public function contrato() {
        return $this->belongsTo(Contrato::class, 'id_concepto', 'id_concepto');
    }
}