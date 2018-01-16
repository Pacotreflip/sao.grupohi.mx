<?php

namespace Ghi\Domain\Core\Models\Tesoreria;

use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoMovimiento extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'cadeco';
    protected $table = 'Tesoreria.tipos_movimientos';
    protected $primaryKey = 'id_tipo_movimiento';
    protected $fillable = [
        'descripcion',
        'naturaleza',
        'estatus',
        'registro',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->estatus = 1;
        });
    }
}
