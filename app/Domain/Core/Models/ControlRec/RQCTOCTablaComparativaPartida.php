<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RQCTOCTablaComparativaPartida
 * @package Ghi\Domain\Core\Models\ControlRec
 */
class RQCTOCTablaComparativaPartida extends Model
{
    /**
     * @var string
     */
    protected $connection = 'controlrec';
    /**
     * @var string
     */
    protected $table = 'rqctoc_tabla_comparativa_partidas';
    /**
     * @var string
     */
    protected $primaryKey = 'idrqctoc_tabla_comparativa_partidas';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [
        'idrqctoc_tabla_comparativa',
        'idrqctoc_solicitudes_partidas',
        'idrqctoc_cotizaciones_partidas',
        'cantidad_asignada',
        'cantidad_autorizada',
        'registro',
        'timestamp_registro',
        'autorizo',
        'estatus',
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->registro =  auth()->id();
            $model->estatus = 1;
            $model->timestamp_registro = date('Y-m-d H:i:s');
        });
    }
}
