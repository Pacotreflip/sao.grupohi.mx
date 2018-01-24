<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:38 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Ghi\Domain\Core\Models\BaseModel;

class SolicitudCambioRechazada extends BaseModel
{
    protected $table = 'ControlPresupuesto.solicitud_cambio_rechazada';
    protected $connection = 'cadeco';
    protected $fillable = [
        'id_solicitud_cambio',
        'id_rechazo'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id_rechazo = auth()->id();
        });
    }
}