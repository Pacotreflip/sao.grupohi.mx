<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudReclasificacion extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'ControlCostos.solicitud_reclasificacion';
    protected $primaryKey = 'id_solicitud_reclasificacion';
    protected $fillable = [
        'motivo',
        'estatus',
        'registro',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->estatus = 1;
            $model->registro = auth()->user()->idusuario;
        });
    }

    public function partidas()
    {
        return $this->hasMany(SolicitudReclasificacionPartidas::class, 'id_solicitud_reclasificacion', 'id_solicitud_reclasificacion');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'estatus', 'estatus');
    }
}
