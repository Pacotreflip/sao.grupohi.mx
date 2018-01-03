<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 02/01/2018
 * Time: 04:29 PM
 */

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudReclasificacionRechazada extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'ControlCostos.solicitud_reclasificacion_rechazada';
    protected $fillable = [
        'id_solicitud_reclasificacion',
        'id_rechazo',
        'motivo',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id_rechazo = auth()->user()->idusuario;
        });
    }

    /**
     * @return mixed
     */
    public function solicitud()
    {
        return $this->belongsTo(SolicitudReclasificacion::class, 'id_solicitud_reclasificacion', 'id');
    }

    /**
     * @return mixed
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_rechazo', 'idusuario');
    }
}