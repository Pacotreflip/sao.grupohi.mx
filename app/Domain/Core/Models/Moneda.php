<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 31/07/2017
 * Time: 04:45 PM
 */

namespace Ghi\Domain\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Moneda extends Model
{
    const DOLARES=2;

    protected $connection = 'cadeco';
    protected $table = 'dbo.monedas';
    protected $primaryKey = 'id_moneda';
    /**
     * @var bool
     */
    public $timestamps = false;

    public function __toString()
    {
        return $this->nombre;
    }

    public function scopeExtranjeras($query) {
        return $query->where('tipo', '=', 0);
    }

    public function scopeCambio($query){
        return $query->join('ControlPresupuesto.cambios_autorizados', 'ControlPresupuesto.cambios_autorizados.id_moneda', '=', 'dbo.monedas.id_moneda');
    }
}