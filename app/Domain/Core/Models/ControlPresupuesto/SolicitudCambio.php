<?php
/**
 * Created by PhpStorm.
 * User: EMARTINEZ
 * Date: 24/01/2018
 * Time: 11:37 AM
 */

namespace Ghi\Domain\Core\Models\ControlPresupuesto;

use Ghi\Domain\Core\Models\BaseModel;
use Carbon\Carbon;
use Ghi\Domain\Core\Models\User;

class SolicitudCambio extends BaseModel
{
    protected $table = 'ControlPresupuesto.solicitud_cambio';
    protected $connection = 'cadeco';
    protected $fillable = [
        'fecha_solicitud',
        'id_solicita',
        'id_estatus',
        'id_tipo_orden',
        'motivo'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id_solicita = auth()->id();
            $model->fecha_solicitud = Carbon::now()->toDateTimeString();
            $model->id_estatus = Estatus::GENERADA;

        });
    }

    public function partidas()
    {
        return $this->hasMany(SolicitudCambioPartida::class, "id_solicitud_cambio", "id");
    }

    public function tipoOrden()
    {
        return $this->hasOne(TipoOrden::class, "id", "id_tipo_orden");
    }

    /**
     * @return User
     */
    public function user_registro()
    {
        return $this->belongsTo(User::class, 'id_solicita', 'idusuario');
    }
    /**
     * @return User
     */
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }

}