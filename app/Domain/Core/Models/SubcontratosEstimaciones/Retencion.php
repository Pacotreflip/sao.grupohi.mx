<?php

namespace Ghi\Domain\Core\Models\SubcontratosEstimaciones;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Francisco Esquivel
 * Date: 26/09/2017
 * Time: 04:41 PM
 */

class Retencion extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'SubcontratosEstimaciones.retencion';
    protected $primaryKey = 'id_retencion';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_transaccion',
        'id_tipo_retencion',
        'importe',
        'concepto',
        'creado'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->creado =  '2017-06-06 14:45:00'; ///Carbon::now()->toDateTimeString();
        });
    }

}