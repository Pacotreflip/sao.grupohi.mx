<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:37 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\User;

class SolicitudCambioAutorizada extends BaseModel
{
    protected $table = 'ControlPresupuesto.solicitud_cambio_autorizada';
    protected $connection = 'cadeco';
    protected $fillable = [
        'id_solicitud_cambio',
        'id_autorizo'
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id_autorizo = auth()->id();
        });
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userAutorizo()
    {
        return $this->hasOne(User::class, 'idusuario','id_autorizo');
    }

}