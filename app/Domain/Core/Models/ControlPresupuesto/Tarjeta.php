<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 25/01/2018
 * Time: 04:56 PM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;


use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;

class Tarjeta extends BaseModel
{
    protected $table = 'ControlPresupuesto.tarjeta';
    protected $connection = 'cadeco';
    protected $fillable = [
        'descripcion',
        'id_obra',
        'estatus'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->estatus =1;
            $model->id_obra = Context::getId();
        });
    }
}