<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 28/07/2017
 * Time: 07:44 PM
 */

namespace Ghi\Domain\Core\Models\Contabilidad;


use Illuminate\Database\Eloquent\Model;

class Revaluacion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.revaluacion';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Factura
     */
    public function facturas() {
        return $this->belongsToMany(Factura::class, 'Contabilidad.revaluacion_transaccion', 'id_revaluacion', 'id_transaccion');
    }
}