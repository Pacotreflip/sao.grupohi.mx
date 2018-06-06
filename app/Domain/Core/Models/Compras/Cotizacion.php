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

/**
 * Class Cotizacion
 * @package Ghi\Domain\Core\Models\Compras
 */
class Cotizacion extends Model
{
    /**
     * @var string
     */
    protected $connection = 'cadeco';
    /**
     * @var string
     */
    protected $table = 'dbo.cotizaciones';
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var array
     */
    protected $primaryKey = ['id_transaccion','id_material'];
    /**
     * @var array
     */
    protected $fillable = [
        'disponibles',
        'precio_unitario',
        'descuento',
        'anticipo',
        'dias_entrega',
        'id_moneda',
        'dias_credito',
        'no_cotizado',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moneda() {
        return $this->belongsTo(Moneda::class, 'id_moneda');
    }
}