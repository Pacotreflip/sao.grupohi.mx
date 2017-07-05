<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class CuentaAlmacen extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_almacenes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_almacen',
        'cuenta',
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
