<?php

namespace Ghi\Domain\Core\Models\ControlCostos;

use Ghi\Core\Facades\Context;
use Ghi\Domain\Core\Models\BaseModel;
use Ghi\Domain\Core\Models\Concepto;
use Ghi\Domain\Core\Models\Scopes\ObraScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitarReclasificaciones extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'ControlCostos.solicitar_reclasificacion';
    protected $primaryKey = 'id_solicitar_reclasificacion';
    protected $fillable = [
        'id_concepto_nuevo',
        'id_concepto',
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

    public function concepto() {
        return $this->belongsTo(Concepto::class, 'id_concepto', 'id_concepto');
    }
}
