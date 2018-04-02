<?php
/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 27/03/2018
 * Time: 11:29 AM
 */

namespace Ghi\Domain\Core\Models\Compras;


use Ghi\Domain\Core\Models\Moneda;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.cotizaciones';
    protected $primaryKey = false;

    public function moneda() {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }
}