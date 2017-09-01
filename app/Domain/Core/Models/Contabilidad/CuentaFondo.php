<?php

namespace Ghi\Domain\Core\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;

class CuentaFondo extends Model
{
    protected $connection = 'cadeco';
    protected $table = 'Contabilidad.cuentas_fondos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_fondo',
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
