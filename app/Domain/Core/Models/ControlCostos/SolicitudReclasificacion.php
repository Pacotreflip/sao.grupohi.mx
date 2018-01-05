<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Ghi\Domain\Core\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudReclasificacion extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'ControlCostos.solicitud_reclasificacion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'motivo',
        'estatus',
        'registro',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ObraScope());

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->user()->idusuario;
            $model->id_obra = Context::getId();
        });
    }

    public function partidas()
    {
        return $this->hasMany(SolicitudReclasificacionPartidas::class, 'id_solicitud_reclasificacion', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'estatus', 'estatus');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'registro', 'idusuario');
    }

    public function autorizadas()
    {
        return $this->hasMany(SolicitudReclasificacionAutorizada::class, 'id_solicitud_reclasificacion', 'id');
    }

    public function rechazadas()
    {
        return $this->hasMany(SolicitudReclasificacionRechazada::class, 'id_solicitud_reclasificacion', 'id');
    }
}
