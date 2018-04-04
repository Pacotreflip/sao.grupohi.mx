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

    public function getCambioAutorizadoAttribute(){
        return
        DB::connection('cadeco')->table('ControlProyectos.cambios_autorizados')
            ->join('ControlProyectos.cambios_autorizados', 'ControlProyectos.cambios_autorizados.id_moneda', '=', $this->id_moneda)
            ->where('ControlProyectos.cambios_autorizados.id_moneda', '=', $this->id_moneda);
            //->first();
    }

    public function scopeCambio($query){
        return $query->join('ControlProyectos.cambios_autorizados', 'ControlProyectos.cambios_autorizados.id_moneda', '=', 'dbo.monedas.id_moneda');
    }
}