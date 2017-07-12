<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Ghi\Domain\Core\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaMaterial extends BaseModel
{
    use SoftDeletes;

    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_materiales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_almacen',
        'cuenta',
        'id_tipo_cuenta_material',
        'id_obra',
        'registro',
        'estatus'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->estatus = 1;
        });
    }
}
