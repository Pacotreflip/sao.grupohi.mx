<?php

namespace Ghi\Domain\Core\Models\ControlRec;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RQCTOCTablaComparativa
 * @package Ghi\Domain\Core\Models\ControlRec
 */
class RQCTOCTablaComparativa extends Model
{
    /**
     * @var string
     */
    protected $connection = 'controlrec';

    /**
     * @var string
     */
    protected $table = 'rqctoc_tabla_comparativa';
    /**
     * @var string
     */
    protected $primaryKey = 'idrqctoc_tabla_comparativa';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [
        'idrqctoc_solicitudes',
        'idserie',
        'registro',
        'timestamp_registro',
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
